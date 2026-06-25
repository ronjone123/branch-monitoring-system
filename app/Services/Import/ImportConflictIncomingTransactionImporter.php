<?php

namespace App\Services\Import;

use App\Models\ImportConflict;
use App\Models\SalesTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use RuntimeException;
use Throwable;

class ImportConflictIncomingTransactionImporter
{
    public function hasImportedIncomingTransaction(ImportConflict $conflict): bool
    {
        try {
            $data = $this->mapIncomingRow($conflict);
        } catch (RuntimeException) {
            return false;
        }

        return $this->findImportedIncomingTransaction($data) !== null;
    }

    public function importAsSeparateTransaction(ImportConflict $conflict, ?int $reviewedBy = null): SalesTransaction
    {
        if ($conflict->conflict_type !== 'related_account_conflict') {
            throw new RuntimeException('Only related account conflicts can be imported as separate transactions.');
        }

        if ($conflict->status !== 'pending') {
            throw new RuntimeException('Only pending related account conflicts can be imported as separate transactions.');
        }

        $data = $this->mapIncomingRow($conflict);

        return DB::transaction(function () use ($conflict, $data, $reviewedBy): SalesTransaction {
            $existingImported = $this->findImportedIncomingTransaction($data);

            if ($existingImported) {
                $this->markConflictResolved($conflict, 'Incoming row was already imported as a separate sales transaction.', $reviewedBy);

                return $existingImported;
            }

            $strictMatch = SalesTransaction::query()
                ->where('match_key', $data['match_key'])
                ->first();

            if ($strictMatch) {
                if ($strictMatch->row_hash === $data['row_hash']) {
                    $this->markConflictResolved($conflict, 'Incoming row was already imported as a separate sales transaction.', $reviewedBy);

                    return $strictMatch;
                }

                throw new RuntimeException('Incoming row matches an existing transaction identity and cannot be imported as separate.');
            }

            $transaction = SalesTransaction::create($data);

            $this->markConflictResolved($conflict, 'Incoming row confirmed as a separate customer and imported as a new sales transaction.', $reviewedBy);

            return $transaction;
        });
    }

    private function findImportedIncomingTransaction(array $data): ?SalesTransaction
    {
        $transaction = SalesTransaction::query()
            ->where('import_batch_id', $data['import_batch_id'])
            ->where('import_batch_sheet_id', $data['import_batch_sheet_id'])
            ->where('source_row_number', $data['source_row_number'])
            ->where('row_hash', $data['row_hash'])
            ->first();

        if ($transaction) {
            return $transaction;
        }

        return SalesTransaction::query()
            ->where('match_key', $data['match_key'])
            ->where('row_hash', $data['row_hash'])
            ->first();
    }

    private function markConflictResolved(ImportConflict $conflict, string $notes, ?int $reviewedBy = null): void
    {
        $conflict->update([
            'status' => 'resolved',
            'reviewed_by' => $reviewedBy,
            'reviewed_at' => now(),
            'notes' => $notes,
        ]);
    }

    private function mapIncomingRow(ImportConflict $conflict): array
    {
        $cells = $conflict->incoming_row_data ?? [];

        if (! is_array($cells) || $cells === []) {
            throw new RuntimeException('No incoming row data is available for this conflict.');
        }

        $invoiceDate = $this->normalizeDate($cells[0] ?? null);
        $accountNumber = $this->toString($cells[1] ?? null);
        $customerName = $this->toString($cells[2] ?? null);
        $contactNumber = $this->toString($cells[3] ?? null);
        $birthDate = $this->normalizeDate($cells[4] ?? null);

        $address = $this->toString($cells[5] ?? null);
        $streetAddress = $this->toString($cells[5] ?? null);
        $cityMunicipality = $this->toString($cells[6] ?? null);

        $salesType = $this->toString($cells[7] ?? null);
        $agentReferralName = $this->toString($cells[8] ?? null);
        $transactionType = $this->toString($cells[9] ?? null);
        $receiptNumber = $this->toString($cells[10] ?? null);
        $salesSource = $this->toString($cells[11] ?? null);

        $product = $this->toString($cells[12] ?? null);
        $unitType = $this->toString($cells[12] ?? null);
        $productLineName = $this->toString($cells[13] ?? null);
        $categoryName = $this->toString($cells[14] ?? null);
        $brandName = $this->toString($cells[15] ?? null);
        $model = $this->toString($cells[16] ?? null);
        $capacity = $this->toString($cells[17] ?? null);
        $productDescription = $this->toString($cells[18] ?? null);
        $serialNumber = $this->toString($cells[19] ?? null);
        $engineNumber = $this->toString($cells[20] ?? null);
        $chassisNumber = $this->toString($cells[21] ?? null);
        $partsNumber = $this->toString($cells[22] ?? null);
        $color = $this->toString($cells[23] ?? null);
        $stockCode = $this->toString($cells[24] ?? null);
        $productRemarks = $this->toString($cells[25] ?? null);

        $amount = $this->normalizeNumber($cells[26] ?? null);
        $cashAmount = $this->normalizeNumber($cells[27] ?? null);
        $downpaymentAmount = $this->normalizeNumber($cells[28] ?? null);
        $promissoryNoteAmount = $this->normalizeNumber($cells[29] ?? null);
        $grossSalesAmount = $this->normalizeNumber($cells[30] ?? null);
        $commissionAmount = $this->normalizeNumber($cells[31] ?? null);
        $monthlyAmortization = $this->normalizeNumber($cells[32] ?? null);
        $terms = $this->toString($cells[33] ?? null);

        $branchNameFromSheet = $this->toString($cells[34] ?? null);
        $pouchingDate = $this->normalizeDate($cells[35] ?? null);
        $encodedBy = $this->toString($cells[36] ?? null);
        $dateLastUpdated = $this->normalizeDate($cells[37] ?? null);

        if ($engineNumber || $chassisNumber) {
            $unitIdentifier = implode('|', [
                $this->normalizeIdentityValue($engineNumber),
                $this->normalizeIdentityValue($chassisNumber),
            ]);
        } elseif ($serialNumber) {
            $unitIdentifier = $this->normalizeIdentityValue($serialNumber);
        } elseif ($stockCode) {
            $unitIdentifier = $this->normalizeIdentityValue($stockCode);
        } elseif ($receiptNumber) {
            $unitIdentifier = $this->normalizeIdentityValue($receiptNumber);
        } else {
            $unitIdentifier = 'NO_UNIT_IDENTIFIER';
        }

        $matchKey = hash('sha256', implode('|', [
            'v4',
            $conflict->branch_id ?? '',
            $this->normalizeIdentityValue($accountNumber),
            $unitIdentifier,
        ]));

        $rowHash = hash('sha256', implode('|', [
            $conflict->branch_id ?? '',
            $invoiceDate ?? '',
            $accountNumber ?? '',
            $customerName ?? '',
            $contactNumber ?? '',
            $birthDate ?? '',
            $address ?? '',
            $cityMunicipality ?? '',
            $salesType ?? '',
            $agentReferralName ?? '',
            $transactionType ?? '',
            $receiptNumber ?? '',
            $salesSource ?? '',
            $product ?? '',
            $unitType ?? '',
            $productLineName ?? '',
            $categoryName ?? '',
            $brandName ?? '',
            $model ?? '',
            $capacity ?? '',
            $productDescription ?? '',
            $serialNumber ?? '',
            $engineNumber ?? '',
            $chassisNumber ?? '',
            $partsNumber ?? '',
            $color ?? '',
            $stockCode ?? '',
            $productRemarks ?? '',
            $amount ?? '',
            $cashAmount ?? '',
            $downpaymentAmount ?? '',
            $promissoryNoteAmount ?? '',
            $grossSalesAmount ?? '',
            $commissionAmount ?? '',
            $monthlyAmortization ?? '',
            $terms ?? '',
            $pouchingDate ?? '',
            $encodedBy ?? '',
            $dateLastUpdated ?? '',
        ]));

        return [
            'import_batch_id' => $conflict->import_batch_id,
            'import_batch_sheet_id' => $conflict->import_batch_sheet_id,
            'branch_id' => $conflict->branch_id,
            'invoice_date' => $invoiceDate,
            'account_number' => $accountNumber,
            'customer_name' => $customerName,
            'contact_number' => $contactNumber,
            'birth_date' => $birthDate,
            'address' => $address,
            'street_address' => $streetAddress,
            'city_municipality' => $cityMunicipality,
            'sales_type' => $salesType,
            'agent_referral_name' => $agentReferralName,
            'transaction_type' => $transactionType,
            'receipt_number' => $receiptNumber,
            'sales_source' => $salesSource,
            'product' => $product,
            'unit_type' => $unitType,
            'product_line_name' => $productLineName,
            'category_name_raw' => $categoryName,
            'brand_name_raw' => $brandName,
            'model' => $model,
            'capacity' => $capacity,
            'product_description' => $productDescription,
            'serial_number' => $serialNumber,
            'engine_number' => $engineNumber,
            'chassis_number' => $chassisNumber,
            'parts_number' => $partsNumber,
            'color' => $color,
            'stock_code' => $stockCode,
            'product_remarks' => $productRemarks,
            'amount' => $amount,
            'srp_cod_amount' => $amount,
            'cash_amount' => $cashAmount,
            'downpayment_amount' => $downpaymentAmount,
            'promissory_note_amount' => $promissoryNoteAmount,
            'gross_sales_amount' => $grossSalesAmount,
            'commission_amount' => $commissionAmount,
            'monthly_amortization' => $monthlyAmortization,
            'terms' => $terms,
            'branch_name_from_sheet' => $branchNameFromSheet,
            'pouching_date' => $pouchingDate,
            'encoded_by' => $encodedBy,
            'date_last_updated' => $dateLastUpdated,
            'source_row_number' => $conflict->source_row_number,
            'raw_row_data' => $cells,
            'match_key' => $matchKey,
            'row_hash' => $rowHash,
        ];
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

        $clean = str_replace([',', 'â‚±', ' '], '', (string) $value);

        return is_numeric($clean) ? (float) $clean : null;
    }

    private function normalizeDate($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
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

    private function normalizeIdentityValue(?string $value): string
    {
        return strtoupper(trim(preg_replace('/\s+/', ' ', (string) $value)));
    }
}
