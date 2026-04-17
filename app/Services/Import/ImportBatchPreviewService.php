<?php

namespace App\Services\Import;

use App\Models\ImportBatch;
use App\Models\ImportBatchSheet;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportBatchPreviewService
{
    public function previewTransactionSheet(ImportBatch $batch, ImportBatchSheet $sheet): array
    {
        if ($sheet->sheet_type !== 'transaction') {
            throw new \RuntimeException('Only transaction sheets can be previewed.');
        }

        if (! Storage::disk('local')->exists($batch->stored_filename)) {
            throw new \RuntimeException('Stored import file was not found.');
        }

        $filePath = Storage::disk('local')->path($batch->stored_filename);

        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly([$sheet->sheet_name]);

        $spreadsheet = $reader->load($filePath);
        $worksheet = $spreadsheet->getSheetByName($sheet->sheet_name);

        if (! $worksheet) {
            throw new \RuntimeException('Worksheet not found: ' . $sheet->sheet_name);
        }

        $highestRow = $worksheet->getHighestDataRow();
        $highestColumn = $worksheet->getHighestDataColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        $rawRows = [];
        $maxPreviewRows = min($highestRow, 20);

        for ($row = 1; $row <= $maxPreviewRows; $row++) {
            $rowData = $worksheet->rangeToArray(
                "A{$row}:{$highestColumn}{$row}",
                null,
                true,
                true,
                false
            )[0];

            $rawRows[$row] = $rowData;
        }

        $headerRowNumber = $this->detectHeaderRow($rawRows);
        $headers = $headerRowNumber ? ($rawRows[$headerRowNumber] ?? []) : [];

        $headerMap = [];
        $lastUsefulColumnIndex = 0;

        for ($colIndex = 1; $colIndex <= $highestColumnIndex; $colIndex++) {
            $columnLetter = Coordinate::stringFromColumnIndex($colIndex);
            $rawHeader = $headers[$colIndex - 1] ?? null;
            $rawHeader = is_string($rawHeader) ? trim($rawHeader) : $rawHeader;

            $cleanHeader = $this->cleanHeader($rawHeader);
            $isUseful = $this->isUsefulHeader($cleanHeader);

            if ($isUseful) {
                $lastUsefulColumnIndex = $colIndex;
            }

            $headerMap[] = [
                'column_letter' => $columnLetter,
                'column_index' => $colIndex,
                'raw_header' => $rawHeader,
                'clean_header' => $cleanHeader,
                'is_useful' => $isUseful,
            ];
        }

        $usableHeaderMap = array_values(array_filter($headerMap, function ($item) {
            return $item['is_useful'];
        }));

        return [
            'sheet_name' => $sheet->sheet_name,
            'highest_row' => $highestRow,
            'highest_column' => $highestColumn,
            'preview_rows' => $rawRows,
            'header_row_number' => $headerRowNumber,
            'headers' => $headers,
            'header_map' => $headerMap,
            'usable_header_map' => $usableHeaderMap,
            'last_useful_column_letter' => $lastUsefulColumnIndex > 0
                ? Coordinate::stringFromColumnIndex($lastUsefulColumnIndex)
                : null,
        ];
    }

    private function detectHeaderRow(array $rows): ?int
    {
        foreach ($rows as $rowNumber => $cells) {
            $normalized = array_map(function ($value) {
                return strtoupper(trim((string) $value));
            }, $cells);

            $joined = implode(' | ', $normalized);

            if (
                str_contains($joined, 'DATE') ||
                str_contains($joined, 'CUSTOMER') ||
                str_contains($joined, 'MODEL') ||
                str_contains($joined, 'BRAND') ||
                str_contains($joined, 'AMOUNT') ||
                str_contains($joined, 'UNIT')
            ) {
                return $rowNumber;
            }
        }

        return null;
    }

    private function cleanHeader($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = strtoupper(trim((string) $value));

        if ($value === '') {
            return null;
        }

        $value = preg_replace('/\s+/', ' ', $value);

        return $value;
    }

    private function isUsefulHeader(?string $header): bool
    {
        if (! $header) {
            return false;
        }

        if ($header === 'SUMMARY') {
            return false;
        }

        return true;
    }
}