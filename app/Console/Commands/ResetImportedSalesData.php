<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ResetImportedSalesData extends Command
{
    private const CONFIRMATION_TOKEN = 'RESET-IMPORTED-DATA';

    private const IMPORT_TABLES = [
        'import_batches',
        'import_batch_sheets',
        'sales_transactions',
        'import_errors',
        'import_conflicts',
    ];

    private const DELETION_ORDER = [
        'import_conflicts',
        'import_errors',
        'sales_transactions',
        'import_batch_sheets',
        'import_batches',
    ];

    private const PRESERVED_TABLES = [
        'users',
        'roles',
        'business_units',
        'locations',
        'branches',
        'product_lines',
        'categories',
        'brands',
        'branch_allowed_product_lines',
        'migrations',
        'cache',
        'cache_locks',
        'jobs',
        'failed_jobs',
        'job_batches',
    ];

    protected $signature = 'imports:reset
        {--dry-run : Preview import-generated sales data without deleting anything}
        {--confirm= : Required exact token for destructive reset}
        {--backup-file= : Required readable database backup file for destructive reset}';

    protected $description = 'Safely dry-run or reset import-generated sales data for controlled chronological re-import.';

    public function handle(): int
    {
        $confirm = $this->option('confirm');
        $backupFile = $this->option('backup-file');
        $explicitDryRun = (bool) $this->option('dry-run');
        $destructiveRequested = ! $explicitDryRun && ($confirm !== null || $backupFile !== null);

        if (! $destructiveRequested) {
            $this->info('DRY RUN ONLY. No records will be deleted.');
            $this->printSummary($this->buildSummary());

            return self::SUCCESS;
        }

        if ($confirm !== self::CONFIRMATION_TOKEN) {
            $this->error('Reset refused. Destructive mode requires --confirm=' . self::CONFIRMATION_TOKEN . '.');

            return self::FAILURE;
        }

        if (app()->environment('production')) {
            $this->error('Reset refused. Production environment is not supported by this command.');

            return self::FAILURE;
        }

        $databaseName = (string) config('database.connections.' . config('database.default') . '.database');

        if (trim($databaseName) === '') {
            $this->error('Reset refused. Database name is empty or unavailable.');

            return self::FAILURE;
        }

        $backup = $this->verifiedBackupFile($backupFile);

        if (! $backup) {
            return self::FAILURE;
        }

        $summary = $this->buildSummary();

        if ($summary['pending_import_jobs'] > 0) {
            $this->error('Reset refused. Pending import-processing queue jobs were detected.');
            $this->line('Pending import-related jobs: ' . $summary['pending_import_jobs']);
            $this->line('Failed import-related jobs: ' . $summary['failed_import_jobs']);

            return self::FAILURE;
        }

        if ($summary['queue_warning']) {
            $this->error('Reset refused. ' . $summary['queue_warning']);

            return self::FAILURE;
        }

        $this->warn('THIS WILL DELETE ALL IMPORTED SALES HISTORY.');
        $this->printEnvironment($backup);
        $this->printSummary($summary);

        if (! $this->input->isInteractive()) {
            $this->error('Destructive reset requires an interactive confirmation prompt.');

            return self::FAILURE;
        }

        if (! $this->confirm('Final confirmation: delete all imported sales history?', false)) {
            $this->error('Reset cancelled. No records were deleted.');

            return self::FAILURE;
        }

        try {
            $deleted = DB::transaction(function () {
                $deletedRows = [];

                foreach (self::DELETION_ORDER as $table) {
                    $deletedRows[$table] = Schema::hasTable($table)
                        ? DB::table($table)->delete()
                        : 0;
                }

                return $deletedRows;
            });
        } catch (Throwable $exception) {
            $this->error('Reset failed and was rolled back: ' . $exception->getMessage());

            return self::FAILURE;
        }

        $this->info('Imported sales data reset completed.');
        $this->line('Deleted rows:');

        foreach (self::DELETION_ORDER as $table) {
            $this->line('- ' . $table . ': ' . number_format($deleted[$table] ?? 0));
        }

        $this->line('Preserved master tables: ' . implode(', ', self::PRESERVED_TABLES));
        $this->line('Uploaded workbook files were left untouched.');
        $this->line('Database transaction committed successfully.');
        $this->line('Next step: re-import final workbooks from oldest month to newest month.');

        return self::SUCCESS;
    }

    private function buildSummary(): array
    {
        return [
            'table_counts' => $this->tableCounts(),
            'batches_by_status' => $this->groupCounts('import_batches', 'status'),
            'batches_by_source_type' => $this->groupCounts('import_batches', 'source_type'),
            'sheets_by_status' => $this->groupCounts('import_batch_sheets', 'status'),
            'conflicts_by_type_status' => $this->conflictCounts(),
            'invoice_date_range' => $this->invoiceDateRange(),
            'sales_by_invoice_month' => $this->salesByInvoiceMonth(),
            'sales_sums' => $this->salesSums(),
            'pending_import_jobs' => $this->pendingImportJobCount(),
            'failed_import_jobs' => $this->failedImportJobCount(),
            'queue_warning' => $this->queueWarning(),
            'stored_workbook_paths' => $this->storedWorkbookPathCounts(),
        ];
    }

    private function printSummary(array $summary): void
    {
        $this->line('Affected table counts:');

        foreach (self::IMPORT_TABLES as $table) {
            $this->line('- ' . $table . ': ' . number_format($summary['table_counts'][$table] ?? 0));
        }

        $this->printGroup('Import batches by status', $summary['batches_by_status']);
        $this->printGroup('Import batches by source type', $summary['batches_by_source_type']);
        $this->printGroup('Sheets by status', $summary['sheets_by_status']);
        $this->printGroup('Conflicts by type and status', $summary['conflicts_by_type_status']);

        $range = $summary['invoice_date_range'];
        $this->line('Invoice date range: ' . ($range['min'] ?? 'none') . ' to ' . ($range['max'] ?? 'none'));

        $this->printGroup('Sales transactions by invoice month', $summary['sales_by_invoice_month']);

        $this->line('Sales amount sums:');

        foreach ($summary['sales_sums'] as $field => $sum) {
            $this->line('- ' . $field . ': ' . number_format((float) $sum, 2));
        }

        $this->line('Pending import-related queue jobs: ' . number_format($summary['pending_import_jobs']));
        $this->line('Failed import-related jobs: ' . number_format($summary['failed_import_jobs']));

        if ($summary['queue_warning']) {
            $this->warn($summary['queue_warning']);
        }

        $paths = $summary['stored_workbook_paths'];
        $this->line('Stored workbook paths found: ' . number_format($paths['found']));
        $this->line('Missing workbook files: ' . number_format($paths['missing']));
    }

    private function printEnvironment(array $backup): void
    {
        $connection = config('database.default');
        $databaseConfig = config('database.connections.' . $connection, []);

        $this->line('Execution context:');
        $this->line('- APP_ENV: ' . app()->environment());
        $this->line('- Database driver: ' . ($databaseConfig['driver'] ?? 'unknown'));
        $this->line('- Database host: ' . ($databaseConfig['host'] ?? 'n/a'));
        $this->line('- Database name: ' . ($databaseConfig['database'] ?? 'n/a'));
        $this->line('- Current time: ' . now()->toDateTimeString());
        $this->line('- Backup file: ' . $backup['path']);
        $this->line('- Backup file size: ' . number_format($backup['size']) . ' bytes');
    }

    private function printGroup(string $title, array $rows): void
    {
        $this->line($title . ':');

        if ($rows === []) {
            $this->line('- none');

            return;
        }

        foreach ($rows as $label => $count) {
            $this->line('- ' . $label . ': ' . number_format($count));
        }
    }

    private function tableCounts(): array
    {
        $counts = [];

        foreach (self::IMPORT_TABLES as $table) {
            $counts[$table] = Schema::hasTable($table)
                ? DB::table($table)->count()
                : 0;
        }

        return $counts;
    }

    private function groupCounts(string $table, string $column): array
    {
        if (! Schema::hasTable($table)) {
            return [];
        }

        return DB::table($table)
            ->selectRaw("COALESCE(NULLIF({$column}, ''), 'Unspecified') as label, COUNT(*) as aggregate_count")
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('aggregate_count', 'label')
            ->map(fn ($count) => (int) $count)
            ->all();
    }

    private function conflictCounts(): array
    {
        if (! Schema::hasTable('import_conflicts')) {
            return [];
        }

        return DB::table('import_conflicts')
            ->selectRaw("COALESCE(NULLIF(conflict_type, ''), 'Unspecified') as conflict_label")
            ->selectRaw("COALESCE(NULLIF(status, ''), 'Unspecified') as status_label")
            ->selectRaw('COUNT(*) as aggregate_count')
            ->groupBy('conflict_label', 'status_label')
            ->orderBy('conflict_label')
            ->orderBy('status_label')
            ->get()
            ->mapWithKeys(function ($row) {
                return [$row->conflict_label . ' / ' . $row->status_label => (int) $row->aggregate_count];
            })
            ->all();
    }

    private function invoiceDateRange(): array
    {
        if (! Schema::hasTable('sales_transactions')) {
            return ['min' => null, 'max' => null];
        }

        $range = DB::table('sales_transactions')
            ->selectRaw('MIN(invoice_date) as min_date, MAX(invoice_date) as max_date')
            ->first();

        return [
            'min' => $range?->min_date,
            'max' => $range?->max_date,
        ];
    }

    private function salesByInvoiceMonth(): array
    {
        if (! Schema::hasTable('sales_transactions')) {
            return [];
        }

        $driver = config('database.connections.' . config('database.default') . '.driver');
        $monthExpression = $driver === 'sqlite'
            ? "strftime('%Y-%m', invoice_date)"
            : "DATE_FORMAT(invoice_date, '%Y-%m')";

        return DB::table('sales_transactions')
            ->whereNotNull('invoice_date')
            ->selectRaw("{$monthExpression} as invoice_month, COUNT(*) as aggregate_count")
            ->groupBy('invoice_month')
            ->orderBy('invoice_month')
            ->pluck('aggregate_count', 'invoice_month')
            ->map(fn ($count) => (int) $count)
            ->all();
    }

    private function salesSums(): array
    {
        $fields = [
            'amount',
            'srp_cod_amount',
            'cash_amount',
            'promissory_note_amount',
            'gross_sales_amount',
        ];

        if (! Schema::hasTable('sales_transactions')) {
            return array_fill_keys($fields, 0.0);
        }

        $selects = collect($fields)
            ->map(fn ($field) => "COALESCE(SUM({$field}), 0) as {$field}")
            ->implode(', ');

        $row = DB::table('sales_transactions')
            ->selectRaw($selects)
            ->first();

        $sums = [];

        foreach ($fields as $field) {
            $sums[$field] = (float) ($row->{$field} ?? 0);
        }

        return $sums;
    }

    private function pendingImportJobCount(): int
    {
        if (! Schema::hasTable('jobs')) {
            return 0;
        }

        return DB::table('jobs')
            ->where('payload', 'like', '%ParseImportBatchSheets%')
            ->count();
    }

    private function failedImportJobCount(): int
    {
        if (! Schema::hasTable('failed_jobs')) {
            return 0;
        }

        return DB::table('failed_jobs')
            ->where(function ($query) {
                $query->where('payload', 'like', '%ParseImportBatchSheets%')
                    ->orWhere('exception', 'like', '%ParseImportBatchSheets%');
            })
            ->count();
    }

    private function queueWarning(): ?string
    {
        $connection = config('queue.default');
        $connections = config('queue.connections', []);
        $driver = $connections[$connection]['driver'] ?? $connection;

        if (in_array($driver, ['database', 'failover'], true) && ! Schema::hasTable('jobs')) {
            return 'Database queue is configured, but the jobs table is unavailable.';
        }

        if (! in_array($driver, ['sync', 'database', 'failover'], true) && ! Schema::hasTable('jobs')) {
            return 'Queue driver "' . $driver . '" is not database-backed, so pending import jobs could not be inspected.';
        }

        return null;
    }

    private function storedWorkbookPathCounts(): array
    {
        if (! Schema::hasTable('import_batches')) {
            return ['found' => 0, 'missing' => 0];
        }

        $paths = DB::table('import_batches')
            ->whereNotNull('stored_filename')
            ->where('stored_filename', '!=', '')
            ->distinct()
            ->pluck('stored_filename');

        $missing = 0;

        foreach ($paths as $path) {
            try {
                if (! Storage::disk('local')->exists($path)) {
                    $missing++;
                }
            } catch (Throwable) {
                $missing++;
            }
        }

        return [
            'found' => $paths->count(),
            'missing' => $missing,
        ];
    }

    private function verifiedBackupFile(?string $backupFile): ?array
    {
        if (! $backupFile) {
            $this->error('Reset refused. Destructive mode requires --backup-file pointing to a readable database backup.');

            return null;
        }

        if (! file_exists($backupFile)) {
            $this->error('Reset refused. Backup file does not exist: ' . $backupFile);

            return null;
        }

        if (! is_file($backupFile)) {
            $this->error('Reset refused. Backup path is not a regular file: ' . $backupFile);

            return null;
        }

        if (! is_readable($backupFile)) {
            $this->error('Reset refused. Backup file is not readable: ' . $backupFile);

            return null;
        }

        $size = filesize($backupFile);

        if ($size === false || $size <= 0) {
            $this->error('Reset refused. Backup file is empty: ' . $backupFile);

            return null;
        }

        return [
            'path' => $backupFile,
            'size' => $size,
        ];
    }
}
