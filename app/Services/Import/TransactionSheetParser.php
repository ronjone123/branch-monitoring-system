<?php

namespace App\Services\Import;

use App\Models\ImportBatch;
use App\Models\ImportBatchSheet;
use App\Models\SalesTransaction;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TransactionSheetParser
{
    public function parse(ImportBatch $batch, ImportBatchSheet $sheet): int
    {
        if ($sheet->sheet_type !== 'transaction') {
            throw new \RuntimeException('Only transaction sheets can be parsed.');
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

        $startRow = 4; // row 2 = grouped header, row 3 = product subheaders, row 4 onward = data
        $highestRow = $worksheet->getHighestDataRow();
        $imported = 0;

        for ($row = $startRow; $row <= $highestRow; $row++) {
            $cells = $worksheet->rangeToArray(
                "A{$row}:AL{$row}",
                null,
                true,
                true,
                false
            )[0];

            /*
            |--------------------------------------------------------------------------
            | Strict row detection
            |--------------------------------------------------------------------------
            | Only import rows that look like real transaction rows.
            | We require:
            | 1. At least 2 meaningful values among important columns
            | 2. At least 1 identity-like field (account/customer/product)
            |--------------------------------------------------------------------------
            */
            $importantCells = [
                'invoice_date'   => $cells[0] ?? null,   // A
                'account_number' => $cells[1] ?? null,   // B
                'customer_name'  => $cells[2] ?? null,   // C
                'product'        => $cells[12] ?? null,  // M
                'amount'         => $cells[26] ?? null,  // AA
            ];

            $meaningfulCount = collect($importantCells)->filter(function ($value) {
                if ($value === null) {
                    return false;
                }

                $stringValue = trim((string) $value);

                if ($stringValue === '') {
                    return false;
                }

                if ($stringValue === '0' || $stringValue === '0.00') {
                    return false;
                }

                return true;
            })->count();

            if ($meaningfulCount < 2) {
                continue;
            }

            $hasIdentityField = collect([
                $cells[1] ?? null,   // account number
                $cells[2] ?? null,   // customer name
                $cells[12] ?? null,  // product
            ])->contains(function ($value) {
                $value = trim((string) $value);

                return $value !== '' && $value !== '0' && $value !== '0.00';
            });

            if (! $hasIdentityField) {
                continue;
            }
            $headerLikeValues = [
                'UNIT TYPE',
                'MODEL',
                'BRAND',
                'AMOUNT',
                'TERMS',
                'PRODUCT',
                'CUSTOMER',
                'CUSTOMER NAME',
                'ACCOUNT NUMBER',
                'INVOICE DATE',
                'CONTACT NUMBER',
                'SALES TYPE',
                'TRANSACTION TYPE',
                'SALES SOURCE',
                'RECEIPT NO.',
                'RECEIPT NUMBER',
                'ENCODED BY',
                'DATE LAST UPDATED',
            ];

            $rowText = collect($cells)
                ->map(fn ($value) => strtoupper(trim((string) $value)))
                ->filter()
                ->values();

            $containsHeaderLikeRow = $rowText->contains(function ($value) use ($headerLikeValues) {
                foreach ($headerLikeValues as $headerLikeValue) {
                    if (str_contains($value, $headerLikeValue)) {
                        return true;
                    }
                }

                return false;
            });

            if (
                $containsHeaderLikeRow &&
                $this->toString($cells[1] ?? null) === null &&
                $this->toString($cells[2] ?? null) === null
            ) {
                continue;
            }

            SalesTransaction::create([
                'import_batch_id' => $batch->id,
                'import_batch_sheet_id' => $sheet->id,
                'branch_id' => $sheet->branch_id,

                'invoice_date' => $this->normalizeDate($cells[0] ?? null),
                'account_number' => $this->toString($cells[1] ?? null),
                'customer_name' => $this->toString($cells[2] ?? null),
                'contact_number' => $this->toString($cells[3] ?? null),
                'birth_date' => $this->normalizeDate($cells[4] ?? null),
                'address' => $this->toString($cells[5] ?? null),
                'street_address' => $this->toString($cells[5] ?? null), // F
                'city_municipality' => $this->toString($cells[6] ?? null), // G

                'sales_type' => $this->toString($cells[7] ?? null),
                'agent_referral_name' => $this->toString($cells[8] ?? null),
                'transaction_type' => $this->toString($cells[9] ?? null),
                'receipt_number' => $this->toString($cells[10] ?? null),
                'sales_source' => $this->toString($cells[11] ?? null),
                'product' => $this->toString($cells[12] ?? null),
                'unit_type' => $this->toString($cells[12] ?? null), // M
                'product_line_name' => $this->toString($cells[13] ?? null), // N
                'category_name_raw' => $this->toString($cells[14] ?? null), // O
                'brand_name_raw' => $this->toString($cells[15] ?? null), // P
                'model' => $this->toString($cells[16] ?? null), // Q
                'capacity' => $this->toString($cells[17] ?? null), // R
                'product_description' => $this->toString($cells[18] ?? null), // S
                'serial_number' => $this->toString($cells[19] ?? null), // T
                'engine_number' => $this->toString($cells[20] ?? null), // U
                'chassis_number' => $this->toString($cells[21] ?? null), // V
                'parts_number' => $this->toString($cells[22] ?? null), // W
                'color' => $this->toString($cells[23] ?? null), // X
                'stock_code' => $this->toString($cells[24] ?? null), // Y
                'product_remarks' => $this->toString($cells[25] ?? null), // Z

                'amount' => $this->normalizeNumber($cells[26] ?? null), // AA
                'srp_cod_amount' => $this->normalizeNumber($cells[26] ?? null), // AA
                'cash_amount' => $this->normalizeNumber($cells[27] ?? null), // AB
                'downpayment_amount' => $this->normalizeNumber($cells[28] ?? null), // AC
                'promissory_note_amount' => $this->normalizeNumber($cells[29] ?? null), // AD
                'gross_sales_amount' => $this->normalizeNumber($cells[30] ?? null), // AE
                'commission_amount' => $this->normalizeNumber($cells[31] ?? null), // AF
                'monthly_amortization' => $this->normalizeNumber($cells[32] ?? null), // AG
                'terms' => $this->toString($cells[33] ?? null), // AH
                'branch_name_from_sheet' => $this->toString($cells[34] ?? null), // AI
                'pouching_date' => $this->normalizeDate($cells[35] ?? null), // AJ
                'encoded_by' => $this->toString($cells[36] ?? null), // AK
                'date_last_updated' => $this->normalizeDate($cells[37] ?? null), // AL

                'source_row_number' => $row,
                'raw_row_data' => $cells,
            ]);

            $imported++;
        }

        $sheet->update([
            'imported_rows' => $imported,
            'valid_rows' => $imported,
            'status' => 'imported',
        ]);

        $batch->update([
            'imported_rows' => $batch->sheets()->sum('imported_rows'),
            'valid_rows' => $batch->sheets()->sum('valid_rows'),
            'invalid_rows' => $batch->errors()->count(),
            'imported_at' => now(),
        ]);

        return $imported;
    }

    private function toString($value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function normalizeNumber($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $clean = str_replace([',', '₱', ' '], '', (string) $value);

        return is_numeric($clean) ? (float) $clean : null;
    }

    private function normalizeDate($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}