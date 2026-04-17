<?php

namespace App\Services\Import;

use App\Models\Branch;
use App\Models\ImportBatch;
use App\Models\ImportBatchSheet;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportBatchProcessor
{
    public function handle(ImportBatch $batch): void
    {
        $filePath = Storage::disk('local')->path($batch->stored_filename);

        if (!Storage::disk('local')->exists($batch->stored_filename)) {
            $batch->update([
                'status' => 'failed',
                'notes' => 'Uploaded file could not be found in local storage.',
            ]);

            throw new \RuntimeException('Stored import file was not found: ' . $batch->stored_filename);
        }

        $reader = IOFactory::createReaderForFile($filePath);

        // IMPORTANT: do not fully load the workbook here
        $sheetNames = $reader->listWorksheetNames($filePath);
        $worksheetInfo = $reader->listWorksheetInfo($filePath);

        $infoByName = [];
        foreach ($worksheetInfo as $info) {
            $infoByName[$info['worksheetName']] = $info;
        }

        $batch->update([
            'total_sheets' => count($sheetNames),
            'status' => 'processing',
        ]);

        $supportedSheets = 0;
        $batchTotalRows = 0;

        foreach ($sheetNames as $sheetName) {
            $sheetType = $this->detectSheetType($sheetName);
            $branch = $this->matchBranchFromSheetName($sheetName);

            if ($sheetType !== 'unsupported') {
                $supportedSheets++;
            }

            $totalRows = 0;

            if ($sheetType === 'transaction' && isset($infoByName[$sheetName])) {
                // worksheetInfo includes totalRows including header rows
                $rawRows = (int) ($infoByName[$sheetName]['totalRows'] ?? 0);

                // Keep this simple for now: assume first row is header
                $totalRows = max(0, $rawRows - 1);
                $batchTotalRows += $totalRows;
            }

            ImportBatchSheet::create([
                'import_batch_id' => $batch->id,
                'branch_id' => $branch?->id,
                'sheet_name' => $sheetName,
                'sheet_type' => $sheetType,
                'total_rows' => $totalRows,
                'status' => 'pending',
                'notes' => $branch
                    ? 'Matched to branch: ' . $branch->display_name
                    : null,
            ]);
        }

        $batch->update([
            'supported_sheets' => $supportedSheets,
            'total_rows' => $batchTotalRows,
            'status' => 'processed',
        ]);
    }

    private function detectSheetType(string $sheetName): string
    {
        $normalized = strtoupper(trim($sheetName));

        if (preg_match('/^(L4|M8)\s+[A-Z0-9]+$/', $normalized)) {
            return 'transaction';
        }

        if ($normalized === 'SUMMARY') {
            return 'report';
        }

        return 'unsupported';
    }

    private function matchBranchFromSheetName(string $sheetName): ?Branch
    {
        $normalized = strtoupper(trim($sheetName));

        return Branch::whereRaw('UPPER(spreadsheet_sheet_name) = ?', [$normalized])->first();
    }
}