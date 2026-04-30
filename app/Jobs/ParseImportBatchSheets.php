<?php

namespace App\Jobs;

use App\Models\ImportBatch;
use App\Services\Import\TransactionSheetParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseImportBatchSheets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 1200; // 20 minutes
    public int $tries = 1;

    public function __construct(public int $importBatchId)
    {
    }

    public function handle(TransactionSheetParser $parser): void
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $importBatch = ImportBatch::with('sheets')->findOrFail($this->importBatchId);

        $importBatch->update([
            'status' => 'processing',
        ]);

        $parsedSheets = 0;
        $totalImportedRows = 0;

        $transactionSheets = $importBatch->sheets
            ->where('sheet_type', 'transaction');

        foreach ($transactionSheets as $sheet) {
            if ($sheet->status === 'imported' && (int) $sheet->imported_rows > 0) {
                continue;
            }

            $imported = (int) $parser->parse($importBatch, $sheet);

            $totalImportedRows += $imported;
            $parsedSheets++;
        }

        $importBatch->refresh();

        $importBatch->update([
            'valid_rows'     => $importBatch->sheets()->sum('valid_rows'),
            'invalid_rows'   => $importBatch->sheets()->sum('invalid_rows'),
            'duplicate_rows' => $importBatch->sheets()->sum('duplicate_rows'),
            'conflict_rows'  => $importBatch->sheets()->sum('conflict_rows'),
            'imported_rows'  => $importBatch->sheets()->sum('imported_rows'),
            'skipped_rows'   => $importBatch->sheets()->sum('skipped_rows'),
            'status'         => 'imported',
        ]);
    }

    public function failed(\Throwable $exception): void
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