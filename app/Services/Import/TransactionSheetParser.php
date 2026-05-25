<?php

namespace App\Services\Import;

use App\Models\ImportBatch;
use App\Models\ImportBatchSheet;
use App\Models\ImportConflict;
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

        $sheet->update([
            'status' => 'processing',
            'notes' => null,
        ]);

        $filePath = Storage::disk('local')->path($batch->stored_filename);

        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly([$sheet->sheet_name]);

        $spreadsheet = $reader->load($filePath);
        $worksheet = $spreadsheet->getSheetByName($sheet->sheet_name);

        if (! $worksheet) {
            throw new \RuntimeException('Worksheet not found: ' . $sheet->sheet_name);
        }

        $startRow = 4; // row 2 = grouped header, row 3 = subheaders, row 4 onward = data
        $highestRow = $worksheet->getHighestDataRow();

        $imported = 0;
        $duplicates = 0;
        $conflicts = 0;

        $validProductLines = config('import.valid_product_lines', []);
        $knownBrands = config('import.known_brands', []);
        $existingTransactions = SalesTransaction::query()
            ->where('branch_id', $sheet->branch_id)
            ->get([
                'id',
                'branch_id',
                'account_number',
                'match_key',
                'row_hash',
                'raw_row_data',
                'invoice_date',
                'customer_name',
                'contact_number',
                'transaction_type',
                'receipt_number',
                'product_line_name',
                'category_name_raw',
                'brand_name_raw',
                'model',
                'capacity',
                'product_description',
                'serial_number',
                'engine_number',
                'chassis_number',
                'color',
                'stock_code',
                'cash_amount',
                'downpayment_amount',
                'promissory_note_amount',
                'gross_sales_amount',
                'monthly_amortization',
            ]);

        $existingByMatchKey = $existingTransactions
            ->whereNotNull('match_key')
            ->keyBy('match_key');

        $existingByAccount = $existingTransactions
            ->whereNotNull('account_number')
            ->groupBy(function ($transaction) {
                return $this->normalizeIdentityValue($transaction->account_number);
            });

        for ($row = $startRow; $row <= $highestRow; $row++) {
            $cells = $worksheet->rangeToArray(
                "A{$row}:AL{$row}",
                null,
                true,
                true,
                false
            )[0];

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
            | Used to identify the same real-world sale record.
            | Do not include product line, brand, model, amount, or terms here because
            | those are fields we want to detect when changed or encoded wrong.
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
                $sheet->branch_id ?? '',
                $this->normalizeIdentityValue($accountNumber),
                $unitIdentifier,
            ]));

            /*
            |--------------------------------------------------------------------------
            | Row Hash
            |--------------------------------------------------------------------------
            | Used to detect whether the same matched sale record has changed.
            |--------------------------------------------------------------------------
            */
            $rowHash = hash('sha256', implode('|', [
                $sheet->branch_id ?? '',
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

            /*
            |--------------------------------------------------------------------------
            | Data Quality Checks
            |--------------------------------------------------------------------------
            | Stop obvious encoding mistakes before duplicate/conflict matching.
            |--------------------------------------------------------------------------
            */
            $dataQualityIssues = $this->checkDataQuality(
                $productLineName,
                $brandName,
                $validProductLines,
                $knownBrands
            );

            if (! empty($dataQualityIssues)) {
                ImportConflict::updateOrCreate(
                    [
                        'import_batch_sheet_id' => $sheet->id,
                        'source_row_number' => $row,
                        'match_key' => $matchKey,
                    ],
                    [
                        'import_batch_id' => $batch->id,
                        'existing_sales_transaction_id' => null,
                        'branch_id' => $sheet->branch_id,
                        'conflict_type' => 'data_quality_conflict',
                        'new_row_hash' => $rowHash,
                        'existing_row_data' => null,
                        'incoming_row_data' => $cells,
                        'status' => 'pending',
                        'notes' => 'Data quality: ' . implode(' ', $dataQualityIssues),
                    ]
                );

                $conflicts++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Incoming Completeness Score Data
            |--------------------------------------------------------------------------
            | Used for conflict notes when incoming row has more complete details.
            |--------------------------------------------------------------------------
            */
            $incomingDataForScore = [
                'invoice_date' => $invoiceDate,
                'account_number' => $accountNumber,
                'customer_name' => $customerName,
                'contact_number' => $contactNumber,
                'transaction_type' => $transactionType,
                'receipt_number' => $receiptNumber,
                'product_line_name' => $productLineName,
                'category_name_raw' => $categoryName,
                'brand_name_raw' => $brandName,
                'model' => $model,
                'capacity' => $capacity,
                'product_description' => $productDescription,
                'serial_number' => $serialNumber,
                'engine_number' => $engineNumber,
                'chassis_number' => $chassisNumber,
                'color' => $color,
                'stock_code' => $stockCode,
                'cash_amount' => $cashAmount,
                'downpayment_amount' => $downpaymentAmount,
                'promissory_note_amount' => $promissoryNoteAmount,
                'gross_sales_amount' => $grossSalesAmount,
                'monthly_amortization' => $monthlyAmortization,
            ];

            /*
            |--------------------------------------------------------------------------
            | Strict Match Key Lookup
            |--------------------------------------------------------------------------
            | If exact identity exists:
            | - same row_hash = duplicate
            | - different row_hash = strict identity conflict
            |--------------------------------------------------------------------------
            */
            $existingTransaction = $existingByMatchKey->get($matchKey);

            if ($existingTransaction) {
                if ($existingTransaction->row_hash === $rowHash) {
                    $duplicates++;
                    continue;
                }

                $existingCompletenessScore = $this->completenessScore($existingTransaction->toArray());
                $incomingCompletenessScore = $this->completenessScore($incomingDataForScore);

                $conflictNotes = 'Potential changed sales row detected during import.';

                if ($incomingCompletenessScore > $existingCompletenessScore) {
                    $conflictNotes .= ' Incoming row appears more complete than the existing transaction.';
                }

                ImportConflict::updateOrCreate(
                    [
                        'import_batch_sheet_id' => $sheet->id,
                        'source_row_number' => $row,
                        'match_key' => $matchKey,
                    ],
                    [
                        'import_batch_id' => $batch->id,
                        'existing_sales_transaction_id' => $existingTransaction->id,
                        'branch_id' => $sheet->branch_id,
                        'conflict_type' => 'strict_identity_conflict',
                        'new_row_hash' => $rowHash,
                        'existing_row_data' => $existingTransaction->raw_row_data,
                        'incoming_row_data' => $cells,
                        'status' => 'pending',
                        'notes' => $conflictNotes,
                    ]
                );

                $conflicts++;
                continue;
            }

          /*
            |--------------------------------------------------------------------------
            | Related Account Lookup
            |--------------------------------------------------------------------------
            | Account number alone is not enough to identify a sale because some valid
            | rows can share the same account number with different customers.
            |
            | Rules:
            | - same account + same row_hash = duplicate
            | - same account + same customer/contact/receipt = conflict/manual review
            | - same account only, but different customer/contact/receipt = allow as new
            |--------------------------------------------------------------------------
            */
            if ($accountNumber) {
                $normalizedAccount = $this->normalizeIdentityValue($accountNumber);
                $accountMatches = $existingByAccount->get($normalizedAccount, collect());

                if ($accountMatches->isNotEmpty()) {
                    $hashMatch = $accountMatches->first(function ($transaction) use ($rowHash) {
                        return $transaction->row_hash === $rowHash;
                    });

                    if ($hashMatch) {
                        $duplicates++;
                        continue;
                    }

                    $normalizedCustomer = $this->normalizeIdentityValue($customerName);
                    $normalizedContact = $this->normalizeIdentityValue($contactNumber);
                    $normalizedReceipt = $this->normalizeIdentityValue($receiptNumber);

                    $relatedAccountMatches = $accountMatches->filter(function ($transaction) use (
                        $normalizedCustomer,
                        $normalizedContact,
                        $normalizedReceipt
                    ) {
                        $sameCustomer = $normalizedCustomer !== ''
                            && $this->normalizeIdentityValue($transaction->customer_name) === $normalizedCustomer;

                        $sameContact = $normalizedContact !== ''
                            && $this->normalizeIdentityValue($transaction->contact_number) === $normalizedContact;

                        $sameReceipt = $normalizedReceipt !== ''
                            && $this->normalizeIdentityValue($transaction->receipt_number) === $normalizedReceipt;

                        return $sameCustomer || $sameContact || $sameReceipt;
                    });

                    if ($relatedAccountMatches->isNotEmpty()) {
                        $incomingCompletenessScore = $this->completenessScore($incomingDataForScore);

                        $bestExistingTransaction = $relatedAccountMatches
                            ->sortByDesc(function ($transaction) {
                                return $this->completenessScore($transaction->toArray());
                            })
                            ->first();

                        $bestExistingScore = $bestExistingTransaction
                            ? $this->completenessScore($bestExistingTransaction->toArray())
                            : 0;

                        $conflictType = $incomingCompletenessScore > $bestExistingScore
                            ? 'completeness_conflict'
                            : 'related_account_conflict';

                        $conflictNotes = $incomingCompletenessScore > $bestExistingScore
                            ? 'Incoming row appears more complete than related existing transaction.'
                            : 'Related account transaction detected. Same account number with matching customer, contact, or receipt. Manual review required.';

                        if ($relatedAccountMatches->count() > 1) {
                            $conflictNotes .= ' Multiple related transactions were found for this account number.';
                        }

                        ImportConflict::updateOrCreate(
                            [
                                'import_batch_sheet_id' => $sheet->id,
                                'source_row_number' => $row,
                                'match_key' => $matchKey,
                            ],
                            [
                                'import_batch_id' => $batch->id,
                                'existing_sales_transaction_id' => $bestExistingTransaction?->id,
                                'branch_id' => $sheet->branch_id,
                                'conflict_type' => $conflictType,
                                'new_row_hash' => $rowHash,
                                'existing_row_data' => $bestExistingTransaction?->raw_row_data,
                                'incoming_row_data' => $cells,
                                'status' => 'pending',
                                'notes' => $conflictNotes,
                            ]
                        );

                        $conflicts++;
                        continue;
                    }
                }
            }

            $createdTransaction = SalesTransaction::create([
                'import_batch_id' => $batch->id,
                'import_batch_sheet_id' => $sheet->id,
                'branch_id' => $sheet->branch_id,

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

                'source_row_number' => $row,
                'raw_row_data' => $cells,
                'row_hash' => $rowHash,
                'match_key' => $matchKey,
            ]);
            $existingByMatchKey->put($matchKey, $createdTransaction);

            if ($accountNumber) {
                $normalizedAccount = $this->normalizeIdentityValue($accountNumber);

                $accountTransactions = $existingByAccount->get($normalizedAccount, collect());
                $accountTransactions->push($createdTransaction);

                $existingByAccount->put($normalizedAccount, $accountTransactions);
            }
            $imported++;
        }
        $sheet->update([
            'imported_rows' => $imported,
            'valid_rows' => $imported,
            'duplicate_rows' => $duplicates,
            'conflict_rows' => $conflicts,
            'status' => 'imported',
            'notes' => null,
        ]);

       $batch->update([
            'imported_rows' => $batch->sheets()->sum('imported_rows'),
            'valid_rows' => $batch->sheets()->sum('valid_rows'),
            'duplicate_rows' => $batch->sheets()->sum('duplicate_rows'),
            'conflict_rows' => $batch->sheets()->sum('conflict_rows'),
            'invalid_rows' => $batch->errors()->count(),
            'imported_at' => now(),
        ]);

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        return $imported;
    }

    private function toString($value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function normalizeIdentityValue(?string $value): string
    {
        return strtoupper(trim(preg_replace('/\s+/', ' ', (string) $value)));
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

    private function checkDataQuality(
        ?string $productLineName,
        ?string $brandName,
        array $validProductLines,
        array $knownBrands
    ): array {
        $issues = [];

        $productLineValue = $this->normalizeIdentityValue($productLineName);
        $brandValue = $this->normalizeIdentityValue($brandName);

        if ($productLineValue !== '' && in_array($productLineValue, $knownBrands, true)) {
            $issues[] = "Brand name '{$productLineValue}' found in product line field.";
        } elseif ($productLineValue !== '' && ! in_array($productLineValue, $validProductLines, true)) {
            $issues[] = "Invalid product line: '{$productLineValue}'.";
        }

        if ($brandValue === '' && $productLineValue !== '' && in_array($productLineValue, $knownBrands, true)) {
            $issues[] = 'Brand is missing but product line contains a known brand.';
        }

        return $issues;
    }

    private function completenessScore(array $data): int
    {
        $importantFields = [
            'invoice_date',
            'account_number',
            'customer_name',
            'contact_number',
            'transaction_type',
            'receipt_number',
            'product_line_name',
            'category_name_raw',
            'brand_name_raw',
            'model',
            'capacity',
            'product_description',
            'serial_number',
            'engine_number',
            'chassis_number',
            'color',
            'stock_code',
            'cash_amount',
            'downpayment_amount',
            'promissory_note_amount',
            'gross_sales_amount',
            'monthly_amortization',
        ];

        $score = 0;

        foreach ($importantFields as $field) {
            if (! empty($data[$field])) {
                $score++;
            }
        }

        return $score;
    }
}
