<?php

namespace App\Services\Import;

use App\Models\ImportBatch;
use App\Models\SalesTransaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Throwable;

class LatestImportRowKeyExtractor
{
    public function extract(ImportBatch $batch): Collection
    {
        return $this->fromSalesTransactions($batch)
            ->concat($this->fromWorkbookRows($batch))
            ->filter(fn (array $row) => $row['branch_id'] && $row['invoice_date'])
            ->unique(fn (array $row) => implode('|', [
                $row['branch_id'],
                $row['invoice_date'],
                $row['receipt_number'] ?? '',
                $row['account_number'] ?? '',
                $row['amount_cents'] ?? '',
                $row['source_sheet_id'] ?? '',
                $row['source_row_number'] ?? '',
            ]))
            ->values();
    }

    private function fromSalesTransactions(ImportBatch $batch): Collection
    {
        return $batch->transactions()
            ->with('importBatchSheet')
            ->whereNotNull('branch_id')
            ->whereNotNull('invoice_date')
            ->get()
            ->map(fn (SalesTransaction $transaction): array => [
                'branch_id' => (int) $transaction->branch_id,
                'invoice_month' => $this->invoiceMonth($transaction->invoice_date),
                'invoice_date' => $this->normalizeDate($transaction->invoice_date),
                'receipt_number' => $this->normalizeIdentityValue($transaction->receipt_number),
                'account_number' => $this->normalizeIdentityValue($transaction->account_number),
                'amount_cents' => $this->effectiveAmountCents([
                    'promissory_note_amount' => $transaction->promissory_note_amount,
                    'cash_amount' => $transaction->cash_amount,
                    'gross_sales_amount' => $transaction->gross_sales_amount,
                    'srp_cod_amount' => $transaction->srp_cod_amount,
                    'amount' => $transaction->amount,
                ]),
                'source_sheet_id' => $transaction->import_batch_sheet_id,
                'source_sheet_name' => $transaction->importBatchSheet?->sheet_name,
                'source_row_number' => $transaction->source_row_number,
                'source' => 'sales_transactions',
            ]);
    }

    private function fromWorkbookRows(ImportBatch $batch): Collection
    {
        if (! $batch->stored_filename || ! Storage::disk('local')->exists($batch->stored_filename)) {
            return collect();
        }

        $sheets = $batch->sheets()
            ->where('sheet_type', 'transaction')
            ->whereNotNull('branch_id')
            ->whereIn('status', ['imported', 'processed', 'parsed', 'completed', 'success'])
            ->where(function ($query) {
                $query->where('imported_rows', '>', 0)
                    ->orWhere('duplicate_rows', '>', 0);
            })
            ->get();

        if ($sheets->isEmpty()) {
            return collect();
        }

        $filePath = Storage::disk('local')->path($batch->stored_filename);
        $rows = collect();

        foreach ($sheets as $sheet) {
            $reader = IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $reader->setLoadSheetsOnly([$sheet->sheet_name]);

            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getSheetByName($sheet->sheet_name);

            if (! $worksheet) {
                $spreadsheet->disconnectWorksheets();
                continue;
            }

            $highestRow = $worksheet->getHighestDataRow();

            for ($rowNumber = 4; $rowNumber <= $highestRow; $rowNumber++) {
                $cells = $worksheet->rangeToArray(
                    "A{$rowNumber}:AL{$rowNumber}",
                    null,
                    true,
                    true,
                    false
                )[0];

                if (! $this->looksLikeTransactionRow($cells)) {
                    continue;
                }

                $invoiceDate = $this->normalizeDate($cells[0] ?? null);

                if (! $invoiceDate) {
                    continue;
                }

                $rows->push([
                    'branch_id' => (int) $sheet->branch_id,
                    'invoice_month' => Carbon::parse($invoiceDate)->format('Y-m'),
                    'invoice_date' => $invoiceDate,
                    'receipt_number' => $this->normalizeIdentityValue($cells[10] ?? null),
                    'account_number' => $this->normalizeIdentityValue($cells[1] ?? null),
                    'amount_cents' => $this->effectiveAmountCents([
                        'promissory_note_amount' => $cells[29] ?? null,
                        'cash_amount' => $cells[27] ?? null,
                        'gross_sales_amount' => $cells[30] ?? null,
                        'srp_cod_amount' => $cells[26] ?? null,
                        'amount' => $cells[26] ?? null,
                    ]),
                    'source_sheet_id' => $sheet->id,
                    'source_sheet_name' => $sheet->sheet_name,
                    'source_row_number' => $rowNumber,
                    'source' => 'workbook',
                ]);
            }

            $spreadsheet->disconnectWorksheets();
        }

        return $rows;
    }

    private function looksLikeTransactionRow(array $cells): bool
    {
        $importantCells = [
            $cells[0] ?? null,
            $cells[1] ?? null,
            $cells[2] ?? null,
            $cells[12] ?? null,
            $cells[26] ?? null,
        ];

        $meaningfulCount = collect($importantCells)->filter(function ($value) {
            if ($value === null) {
                return false;
            }

            $value = trim((string) $value);

            return $value !== '' && $value !== '0' && $value !== '0.00';
        })->count();

        if ($meaningfulCount < 2) {
            return false;
        }

        $hasIdentityField = collect([
            $cells[1] ?? null,
            $cells[2] ?? null,
            $cells[12] ?? null,
        ])->contains(function ($value) {
            $value = trim((string) $value);

            return $value !== '' && $value !== '0' && $value !== '0.00';
        });

        if (! $hasIdentityField) {
            return false;
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

        return ! (
            $containsHeaderLikeRow
            && $this->toString($cells[1] ?? null) === null
            && $this->toString($cells[2] ?? null) === null
        );
    }

    private function effectiveAmountCents(array $values): ?int
    {
        foreach (['promissory_note_amount', 'cash_amount', 'gross_sales_amount', 'srp_cod_amount', 'amount'] as $field) {
            $cents = $this->decimalToCents($values[$field] ?? null);

            if ($cents !== null && $cents !== 0) {
                return $cents;
            }
        }

        return $this->decimalToCents($values['amount'] ?? null);
    }

    private function decimalToCents($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $clean = preg_replace('/[^0-9.\-]/', '', (string) $value);

        if ($clean === '' || $clean === '-' || $clean === '.') {
            return null;
        }

        $negative = str_starts_with($clean, '-');
        $clean = ltrim($clean, '-');
        [$whole, $fraction] = array_pad(explode('.', $clean, 2), 2, '');
        $whole = $whole === '' ? '0' : $whole;
        $fraction = substr(str_pad($fraction, 2, '0'), 0, 2);

        if (! ctype_digit($whole) || ! ctype_digit($fraction)) {
            return null;
        }

        $cents = ((int) $whole * 100) + (int) $fraction;

        return $negative ? -$cents : $cents;
    }

    private function normalizeDate($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->format('Y-m-d');
        }

        if (is_numeric($value)) {
            try {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (Throwable) {
                return null;
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (Throwable) {
            return null;
        }
    }

    private function invoiceMonth($value): ?string
    {
        $date = $this->normalizeDate($value);

        return $date ? Carbon::parse($date)->format('Y-m') : null;
    }

    private function toString($value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function normalizeIdentityValue($value): string
    {
        return strtoupper(trim(preg_replace('/\s+/', ' ', (string) $value)));
    }
}
