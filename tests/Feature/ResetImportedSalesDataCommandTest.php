<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResetImportedSalesDataCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        $this->prepareDatabase();
        $this->seedResetFixture();
    }

    public function test_default_run_is_dry_run_and_deletes_nothing(): void
    {
        $this->artisan('imports:reset')
            ->expectsOutputToContain('DRY RUN ONLY')
            ->expectsOutputToContain('import_batches: 1')
            ->expectsOutputToContain('sales_transactions: 1')
            ->assertExitCode(0);

        $this->assertImportRecordsRemain();
    }

    public function test_explicit_dry_run_deletes_nothing(): void
    {
        $this->artisan('imports:reset --dry-run')
            ->expectsOutputToContain('DRY RUN ONLY')
            ->assertExitCode(0);

        $this->assertImportRecordsRemain();
    }

    public function test_missing_confirmation_refuses_destructive_reset(): void
    {
        $backup = $this->backupFileWithContent();

        $this->artisan('imports:reset', [
            '--backup-file' => $backup,
        ])
            ->expectsOutputToContain('Reset refused. Destructive mode requires --confirm=RESET-IMPORTED-DATA.')
            ->assertExitCode(1);

        $this->assertImportRecordsRemain();
    }

    public function test_incorrect_confirmation_refuses_destructive_reset(): void
    {
        $backup = $this->backupFileWithContent();

        $this->artisan('imports:reset', [
            '--confirm' => 'WRONG',
            '--backup-file' => $backup,
        ])
            ->expectsOutputToContain('Reset refused. Destructive mode requires --confirm=RESET-IMPORTED-DATA.')
            ->assertExitCode(1);

        $this->assertImportRecordsRemain();
    }

    public function test_missing_backup_file_refuses_destructive_reset(): void
    {
        $this->artisan('imports:reset', [
            '--confirm' => 'RESET-IMPORTED-DATA',
            '--backup-file' => storage_path('framework/testing/missing-backup.sql'),
        ])
            ->expectsOutputToContain('Reset refused. Backup file does not exist')
            ->assertExitCode(1);

        $this->assertImportRecordsRemain();
    }

    public function test_empty_backup_file_refuses_destructive_reset(): void
    {
        $backup = $this->backupFileWithContent('');

        $this->artisan('imports:reset', [
            '--confirm' => 'RESET-IMPORTED-DATA',
            '--backup-file' => $backup,
        ])
            ->expectsOutputToContain('Reset refused. Backup file is empty')
            ->assertExitCode(1);

        $this->assertImportRecordsRemain();
    }

    public function test_valid_confirmed_reset_deletes_only_import_generated_records(): void
    {
        $backup = $this->backupFileWithContent();

        $this->artisan('imports:reset', [
            '--confirm' => 'RESET-IMPORTED-DATA',
            '--backup-file' => $backup,
        ])
            ->expectsConfirmation('Final confirmation: delete all imported sales history?', 'yes')
            ->expectsOutputToContain('THIS WILL DELETE ALL IMPORTED SALES HISTORY.')
            ->expectsOutputToContain('Database transaction committed successfully.')
            ->assertExitCode(0);

        $this->assertSame(0, DB::table('import_conflicts')->count());
        $this->assertSame(0, DB::table('import_errors')->count());
        $this->assertSame(0, DB::table('sales_transactions')->count());
        $this->assertSame(0, DB::table('import_batch_sheets')->count());
        $this->assertSame(0, DB::table('import_batches')->count());

        $this->assertMasterRecordsRemain();
    }

    public function test_non_interactive_destructive_reset_is_refused(): void
    {
        $backup = $this->backupFileWithContent();

        $this->artisan('imports:reset', [
            '--confirm' => 'RESET-IMPORTED-DATA',
            '--backup-file' => $backup,
            '--no-interaction' => true,
        ])
            ->expectsOutputToContain('Destructive reset requires an interactive confirmation prompt.')
            ->assertExitCode(1);

        $this->assertImportRecordsRemain();
        $this->assertMasterRecordsRemain();
        $this->assertTrue(Storage::disk('local')->exists('imports/final-january.xlsx'));
    }

    public function test_pending_import_job_refuses_destructive_reset(): void
    {
        DB::table('jobs')->insert([
            'queue' => 'default',
            'payload' => json_encode(['displayName' => 'App\\Jobs\\ParseImportBatchSheets']),
            'attempts' => 0,
            'reserved_at' => null,
            'available_at' => time(),
            'created_at' => time(),
        ]);

        $backup = $this->backupFileWithContent();

        $this->artisan('imports:reset', [
            '--confirm' => 'RESET-IMPORTED-DATA',
            '--backup-file' => $backup,
        ])
            ->expectsOutputToContain('Reset refused. Pending import-processing queue jobs were detected.')
            ->assertExitCode(1);

        $this->assertImportRecordsRemain();
    }

    public function test_uploaded_workbook_files_are_not_deleted(): void
    {
        $backup = $this->backupFileWithContent();

        $this->assertTrue(Storage::disk('local')->exists('imports/final-january.xlsx'));

        $this->artisan('imports:reset', [
            '--confirm' => 'RESET-IMPORTED-DATA',
            '--backup-file' => $backup,
        ])
            ->expectsConfirmation('Final confirmation: delete all imported sales history?', 'yes')
            ->assertExitCode(0);

        $this->assertTrue(Storage::disk('local')->exists('imports/final-january.xlsx'));
    }

    public function test_delete_failure_rolls_back_the_complete_reset(): void
    {
        DB::unprepared("
            CREATE TRIGGER fail_import_errors_delete
            BEFORE DELETE ON import_errors
            BEGIN
                SELECT RAISE(ABORT, 'forced import error delete failure');
            END
        ");

        $backup = $this->backupFileWithContent();

        $this->artisan('imports:reset', [
            '--confirm' => 'RESET-IMPORTED-DATA',
            '--backup-file' => $backup,
        ])
            ->expectsConfirmation('Final confirmation: delete all imported sales history?', 'yes')
            ->expectsOutputToContain('Reset failed and was rolled back')
            ->assertExitCode(1);

        DB::unprepared('DROP TRIGGER fail_import_errors_delete');

        $this->assertImportRecordsRemain();
    }

    private function prepareDatabase(): void
    {
        foreach ([
            'job_batches',
            'failed_jobs',
            'jobs',
            'import_conflicts',
            'import_errors',
            'sales_transactions',
            'import_batch_sheets',
            'import_batches',
            'branch_allowed_product_lines',
            'brands',
            'categories',
            'product_lines',
            'branches',
            'locations',
            'business_units',
            'roles',
            'users',
        ] as $table) {
            Schema::dropIfExists($table);
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('business_units', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_unit_id');
            $table->foreignId('location_id');
            $table->string('code');
            $table->string('display_name');
            $table->timestamps();
        });

        Schema::create('product_lines', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_line_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_line_id')->nullable();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('branch_allowed_product_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id');
            $table->foreignId('product_line_id');
            $table->timestamps();
        });

        Schema::create('import_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by');
            $table->string('original_filename');
            $table->string('stored_filename')->nullable();
            $table->string('source_type')->nullable();
            $table->unsignedInteger('total_sheets')->default(0);
            $table->unsignedInteger('supported_sheets')->default(0);
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('valid_rows')->default(0);
            $table->unsignedInteger('invalid_rows')->default(0);
            $table->unsignedInteger('duplicate_rows')->default(0);
            $table->unsignedInteger('conflict_rows')->default(0);
            $table->unsignedInteger('imported_rows')->default(0);
            $table->unsignedInteger('skipped_rows')->default(0);
            $table->string('status')->default('uploaded');
            $table->text('notes')->nullable();
            $table->timestamp('imported_at')->nullable();
            $table->timestamps();
        });

        Schema::create('import_batch_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('branch_id')->nullable();
            $table->string('sheet_name');
            $table->string('sheet_type')->default('transaction');
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('valid_rows')->default(0);
            $table->unsignedInteger('invalid_rows')->default(0);
            $table->unsignedInteger('duplicate_rows')->default(0);
            $table->unsignedInteger('conflict_rows')->default(0);
            $table->unsignedInteger('imported_rows')->default(0);
            $table->unsignedInteger('skipped_rows')->default(0);
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('import_batch_sheet_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('srp_cod_amount', 15, 2)->nullable();
            $table->decimal('cash_amount', 15, 2)->nullable();
            $table->decimal('promissory_note_amount', 15, 2)->nullable();
            $table->decimal('gross_sales_amount', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('import_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('import_batch_sheet_id')->nullable();
            $table->string('sheet_name');
            $table->unsignedInteger('row_number');
            $table->string('field_name')->nullable();
            $table->text('error_message');
            $table->longText('raw_payload')->nullable();
            $table->timestamps();
        });

        Schema::create('import_conflicts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('import_batch_sheet_id')->nullable();
            $table->foreignId('existing_sales_transaction_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->string('conflict_type')->nullable();
            $table->unsignedInteger('source_row_number')->nullable();
            $table->string('match_key', 64)->nullable();
            $table->string('new_row_hash', 64)->nullable();
            $table->json('existing_row_data')->nullable();
            $table->json('incoming_row_data')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->nullable();
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });
    }

    private function seedResetFixture(): void
    {
        Storage::disk('local')->put('imports/final-january.xlsx', 'workbook');

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => 'secret',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert(['id' => 1, 'name' => 'admin', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('business_units')->insert(['id' => 1, 'code' => 'L4', 'name' => 'Lucky 4', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('locations')->insert(['id' => 1, 'code' => 'GSC', 'name' => 'Gensan', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('branches')->insert(['id' => 1, 'business_unit_id' => 1, 'location_id' => 1, 'code' => 'L4GSC', 'display_name' => 'Lucky 4 Gensan', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('product_lines')->insert(['id' => 1, 'code' => 'MC', 'name' => 'Motorcycle', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('categories')->insert(['id' => 1, 'product_line_id' => 1, 'name' => 'Motorcycle', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('brands')->insert(['id' => 1, 'product_line_id' => 1, 'name' => 'Honda', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('branch_allowed_product_lines')->insert(['id' => 1, 'branch_id' => 1, 'product_line_id' => 1, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('import_batches')->insert([
            'id' => 1,
            'uploaded_by' => 1,
            'original_filename' => 'final-january.xlsx',
            'stored_filename' => 'imports/final-january.xlsx',
            'source_type' => 'manual_upload',
            'total_sheets' => 1,
            'supported_sheets' => 1,
            'total_rows' => 1,
            'valid_rows' => 1,
            'invalid_rows' => 1,
            'duplicate_rows' => 0,
            'conflict_rows' => 1,
            'imported_rows' => 1,
            'skipped_rows' => 0,
            'status' => 'imported',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('import_batch_sheets')->insert([
            'id' => 1,
            'import_batch_id' => 1,
            'branch_id' => 1,
            'sheet_name' => 'L4 GSC',
            'sheet_type' => 'transaction',
            'total_rows' => 1,
            'valid_rows' => 1,
            'invalid_rows' => 1,
            'duplicate_rows' => 0,
            'conflict_rows' => 1,
            'imported_rows' => 1,
            'skipped_rows' => 0,
            'status' => 'imported',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sales_transactions')->insert([
            'id' => 1,
            'import_batch_id' => 1,
            'import_batch_sheet_id' => 1,
            'branch_id' => 1,
            'invoice_date' => '2026-01-15',
            'amount' => 100000,
            'srp_cod_amount' => 100000,
            'cash_amount' => 100000,
            'promissory_note_amount' => 0,
            'gross_sales_amount' => 100000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('import_errors')->insert([
            'id' => 1,
            'import_batch_id' => 1,
            'import_batch_sheet_id' => 1,
            'sheet_name' => 'L4 GSC',
            'row_number' => 4,
            'field_name' => 'amount',
            'error_message' => 'Example error',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('import_conflicts')->insert([
            'id' => 1,
            'import_batch_id' => 1,
            'import_batch_sheet_id' => 1,
            'existing_sales_transaction_id' => 1,
            'branch_id' => 1,
            'conflict_type' => 'completeness_conflict',
            'source_row_number' => 4,
            'match_key' => 'abc',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function backupFileWithContent(string $content = 'backup'): string
    {
        $path = storage_path('framework/testing/reset-backup-' . uniqid('', true) . '.sql');
        $directory = dirname($path);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, $content);

        return $path;
    }

    private function assertImportRecordsRemain(): void
    {
        $this->assertSame(1, DB::table('import_batches')->count());
        $this->assertSame(1, DB::table('import_batch_sheets')->count());
        $this->assertSame(1, DB::table('sales_transactions')->count());
        $this->assertSame(1, DB::table('import_errors')->count());
        $this->assertSame(1, DB::table('import_conflicts')->count());
    }

    private function assertMasterRecordsRemain(): void
    {
        $this->assertSame(1, DB::table('users')->count());
        $this->assertSame(1, DB::table('roles')->count());
        $this->assertSame(1, DB::table('business_units')->count());
        $this->assertSame(1, DB::table('locations')->count());
        $this->assertSame(1, DB::table('branches')->count());
        $this->assertSame(1, DB::table('product_lines')->count());
        $this->assertSame(1, DB::table('categories')->count());
        $this->assertSame(1, DB::table('brands')->count());
        $this->assertSame(1, DB::table('branch_allowed_product_lines')->count());
    }
}
