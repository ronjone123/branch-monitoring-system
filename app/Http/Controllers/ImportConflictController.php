<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ImportBatch;
use App\Models\ImportConflict;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImportConflictController extends Controller
{
    public function index(Request $request): View
    {
        $query = ImportConflict::with([
            'importBatch',
            'importBatchSheet',
            'existingSalesTransaction',
            'branch',
        ])->latest();

        if ($request->filled('import_batch_id')) {
            $query->where('import_batch_id', $request->import_batch_id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $status = $request->input('status', 'pending');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $conflicts = $query->paginate(15)->withQueryString();

        $batches = ImportBatch::latest()->get();
        $branches = Branch::orderBy('display_name')->get();

        return view('import-conflicts.index', compact(
            'conflicts',
            'batches',
            'branches'
        ));
    }

    public function show(ImportConflict $importConflict): View
    {
        $importConflict->load([
            'importBatch',
            'importBatchSheet',
            'existingSalesTransaction.branch',
            'branch',
        ]);

        $existingData = $importConflict->existing_row_data ?? [];
        $incomingData = $importConflict->incoming_row_data ?? [];

        $fieldMap = [
            'A'  => 'Invoice Date',
            'B'  => 'Account Number',
            'C'  => 'Customer Name',
            'D'  => 'Contact Number',
            'E'  => 'Birth Date',
            'F'  => 'Street Address',
            'G'  => 'Municipality / City',
            'H'  => 'Sales Type',
            'I'  => 'Agent / Referral Name',
            'J'  => 'Transaction Type',
            'K'  => 'Receipt Number',
            'L'  => 'Sales Source',
            'M'  => 'Unit Type',
            'N'  => 'Line',
            'O'  => 'Category',
            'P'  => 'Brand',
            'Q'  => 'Model',
            'R'  => 'Capacity',
            'S'  => 'Description',
            'T'  => 'Serial Number',
            'U'  => 'Engine Number',
            'V'  => 'Chassis Number',
            'W'  => 'Parts Number',
            'X'  => 'Color',
            'Y'  => 'Stock Code',
            'Z'  => 'Product Remarks',
            'AA' => 'SRP / COD Amount',
            'AB' => 'Cash Amount',
            'AC' => 'Downpayment Amount',
            'AD' => 'Promissory Note Amount',
            'AE' => 'Gross Sales Amount',
            'AF' => 'Commission Amount',
            'AG' => 'Monthly Amortization',
            'AH' => 'Terms',
            'AI' => 'Branch Name From Sheet',
            'AJ' => 'Pouching Date',
            'AK' => 'Encoded By',
            'AL' => 'Date Last Updated',
        ];

        $columnKeys = array_keys($fieldMap);
        $comparisonRows = [];

        foreach ($columnKeys as $index => $columnKey) {
            $existingValue = $existingData[$index] ?? null;
            $incomingValue = $incomingData[$index] ?? null;

            $existingNormalized = trim((string) ($existingValue ?? ''));
            $incomingNormalized = trim((string) ($incomingValue ?? ''));

            $comparisonRows[] = [
                'column' => $columnKey,
                'label' => $fieldMap[$columnKey],
                'existing' => $existingValue,
                'incoming' => $incomingValue,
                'changed' => $existingNormalized !== $incomingNormalized,
            ];
        }

        return view('import-conflicts.show', compact(
            'importConflict',
            'existingData',
            'incomingData',
            'comparisonRows'
        ));
    }

    public function markReviewed(ImportConflict $importConflict): RedirectResponse
    {
        $importConflict->update([
            'status' => 'reviewed',
            'notes' => 'Conflict marked as reviewed.',
        ]);

        return redirect()
            ->route('import-conflicts.show', $importConflict)
            ->with('success', 'Conflict marked as reviewed.');
    }

    public function markIgnored(ImportConflict $importConflict): RedirectResponse
    {
        $importConflict->update([
            'status' => 'ignored',
            'notes' => 'Conflict marked as ignored.',
        ]);

        return redirect()
            ->route('import-conflicts.show', $importConflict)
            ->with('success', 'Conflict marked as ignored.');
    }

    public function markResolved(ImportConflict $importConflict): RedirectResponse
    {
        $importConflict->update([
            'status' => 'resolved',
            'notes' => 'Conflict resolved after review.',
        ]);

        return redirect()
            ->route('import-conflicts.show', $importConflict)
            ->with('success', 'Conflict marked as resolved.');
    }

    public function destroy(ImportConflict $importConflict): RedirectResponse
    {
        $importConflict->delete();

        return redirect()
            ->route('import-conflicts.index')
            ->with('success', 'Conflict deleted successfully.');
    }

    public function acceptIncomingUpdate(ImportConflict $importConflict): RedirectResponse
    {
        if (in_array($importConflict->conflict_type, ['missing_from_latest_import', 'data_quality_conflict'], true)) {
            return redirect()
                ->route('import-conflicts.show', $importConflict)
                ->with('success', 'This conflict type cannot be accepted as an incoming update. Please review, ignore, or mark it resolved.');
        }
        $transaction = $importConflict->existingSalesTransaction;

        if (! $transaction) {
            return redirect()
                ->route('import-conflicts.show', $importConflict)
                ->with('success', 'No existing sales transaction found for this conflict.');
        }

        $cells = $importConflict->incoming_row_data ?? [];

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

        /*
        |--------------------------------------------------------------------------
        | Match Key
        |--------------------------------------------------------------------------
        | Must match TransactionSheetParser v4 logic.
        |--------------------------------------------------------------------------
        */
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
            $importConflict->branch_id ?? '',
            $this->normalizeIdentityValue($accountNumber),
            $unitIdentifier,
        ]));

        /*
        |--------------------------------------------------------------------------
        | Row Hash
        |--------------------------------------------------------------------------
        | Must match the full parser row_hash field list.
        |--------------------------------------------------------------------------
        */
        $rowHash = hash('sha256', implode('|', [
            $importConflict->branch_id ?? '',
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

        $transaction->update([
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

            'source_row_number' => $importConflict->source_row_number,
            'raw_row_data' => $cells,
            'match_key' => $matchKey,
            'row_hash' => $rowHash,
        ]);

        $importConflict->update([
            'status' => 'resolved',
            'notes' => 'Incoming update applied to existing sales transaction.',
        ]);

        return redirect()
            ->route('import-conflicts.show', $importConflict)
            ->with('success', 'Incoming update successfully applied.');
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

    private function normalizeIdentityValue(?string $value): string
    {
        return strtoupper(trim(preg_replace('/\s+/', ' ', (string) $value)));
    }
}