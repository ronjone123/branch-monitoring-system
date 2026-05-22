<?php

namespace App\Jobs;

use App\Models\ImportBatch;
use App\Services\Import\TransactionSheetParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ParseImportBatchSheets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 1200; // 20 minutes
    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(public int $importBatchId)
    {
    }

    public function handle(TransactionSheetParser $parser): void
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $importBatch = ImportBatch::query()
            ->with('sheets')
            ->findOrFail($this->importBatchId);

        $importBatch->update([
            'status' => 'processing',
        ]);

        $transactionSheets = $importBatch->sheets()
            ->where('sheet_type', 'transaction')
            ->whereIn('status', ['pending', 'queued', 'failed'])
            ->get();

        if ($transactionSheets->isEmpty()) {
            $this->recalculateBatchTotals($importBatch);

            return;
        }

        foreach ($transactionSheets as $sheet) {
            try {
                $parser->parse($importBatch, $sheet);
            } catch (Throwable $exception) {
                $sheet->update([
                    'status' => 'failed',
                    'notes' => 'Sheet parse failed: ' . $exception->getMessage(),
                ]);

                report($exception);

                continue;
            }
        }

        $this->recalculateBatchTotals($importBatch);
    }

    protected function recalculateBatchTotals(ImportBatch $importBatch): void
    {
        $importBatch->refresh();

        $validRows = $importBatch->sheets()->sum('valid_rows');
        $invalidRows = $importBatch->sheets()->sum('invalid_rows');
        $duplicateRows = $importBatch->sheets()->sum('duplicate_rows');
        $conflictRows = $importBatch->sheets()->sum('conflict_rows');
        $importedRows = $importBatch->sheets()->sum('imported_rows');
        $skippedRows = $importBatch->sheets()->sum('skipped_rows');

        $hasFailedSheets = $importBatch->sheets()
            ->where('sheet_type', 'transaction')
            ->where('status', 'failed')
            ->exists();

        $hasPendingSheets = $importBatch->sheets()
            ->where('sheet_type', 'transaction')
            ->whereIn('status', ['pending', 'queued', 'processing'])
            ->exists();

        $hasImportedSheets = $importBatch->sheets()
            ->where('sheet_type', 'transaction')
            ->where('status', 'imported')
            ->exists();

        $status = 'imported';

        if ($hasPendingSheets) {
            $status = 'processing';
        } elseif ($hasFailedSheets && ! $hasImportedSheets) {
            $status = 'failed';
        } elseif ($hasFailedSheets && $hasImportedSheets) {
            $status = 'imported';
        }

        $importBatch->update([
            'valid_rows' => $validRows,
            'invalid_rows' => $invalidRows,
            'duplicate_rows' => $duplicateRows,
            'conflict_rows' => $conflictRows,
            'imported_rows' => $importedRows,
            'skipped_rows' => $skippedRows,
            'status' => $status,
            'notes' => $hasFailedSheets
                ? 'Batch completed with one or more failed sheets. Check sheet statuses for details.'
                : null,
        ]);
    }

    public function failed(Throwable $exception): void
    {
        $importBatch = ImportBatch::find($this->importBatchId);

        if ($importBatch) {
            $importBatch->update([
                'status' => 'failed',
                'notes' => 'Parse all failed: ' . $exception->getMessage(),
            ]);
        }
    }
}