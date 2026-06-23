<?php

namespace App\Services\Import;

use App\Models\ImportBatch;
use App\Models\ImportConflict;
use App\Models\SalesTransaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class MissingFromLatestImportDetector
{
    public function scan(ImportBatch $latestBatch): array
    {
        $summary = [
            'created' => 0,
            'existing' => 0,
            'skipped_groups' => 0,
            'warnings' => [],
        ];

        if (strtolower((string) $latestBatch->status) !== 'imported') {
            $summary['warnings'][] = 'Missing-from-latest review can only run for imported batches.';

            return $summary;
        }

        $latestTransactions = $latestBatch->transactions()
            ->whereNotNull('branch_id')
            ->whereNotNull('invoice_date')
            ->get();

        if ($latestTransactions->isEmpty()) {
            $summary['warnings'][] = 'No imported transactions are linked to this batch.';

            return $summary;
        }

        $latestGroups = $latestTransactions->groupBy(function (SalesTransaction $transaction): string {
            return $this->groupKey((int) $transaction->branch_id, $this->invoiceMonth($transaction));
        });

        foreach ($latestGroups as $groupKey => $latestGroupTransactions) {
            [$branchId, $invoiceMonth] = explode('|', $groupKey, 2);
            $branchId = (int) $branchId;

            $previousBatch = $this->previousComparableBatch($latestBatch, $branchId, $invoiceMonth);

            if (! $previousBatch) {
                $summary['warnings'][] = "No previous comparable import was found for branch {$branchId} / {$invoiceMonth}.";

                continue;
            }

            $previousTransactions = $this->transactionsForGroup($previousBatch, $branchId, $invoiceMonth);
            $previousCount = $previousTransactions->count();
            $latestCount = $latestGroupTransactions->count();

            if ($previousCount > 0 && $latestCount < ($previousCount * 0.5)) {
                $summary['skipped_groups']++;
                $summary['warnings'][] = "Skipped branch {$branchId} / {$invoiceMonth}: latest batch has {$latestCount} transaction(s), below 50% of previous comparable count {$previousCount}.";

                continue;
            }

            $latestKeys = $this->matchingKeys($latestGroupTransactions);
            $latestSheetId = $latestGroupTransactions->first()?->import_batch_sheet_id;

            foreach ($previousTransactions as $previousTransaction) {
                if ($this->hasMatchingLatestTransaction($previousTransaction, $latestKeys)) {
                    continue;
                }

                $conflict = $this->createMissingConflict(
                    $latestBatch,
                    $previousBatch,
                    $previousTransaction,
                    $invoiceMonth,
                    $latestSheetId
                );

                $conflict->wasRecentlyCreated
                    ? $summary['created']++
                    : $summary['existing']++;
            }
        }

        if ($summary['created'] === 0 && $summary['existing'] === 0 && $summary['warnings'] === []) {
            $summary['warnings'][] = 'No missing previous transactions were found for this batch.';
        }

        return $summary;
    }

    private function previousComparableBatch(ImportBatch $latestBatch, int $branchId, string $invoiceMonth): ?ImportBatch
    {
        [$monthStart, $monthEnd] = $this->monthRange($invoiceMonth);
        $latestImportedAt = $latestBatch->imported_at ?? $latestBatch->created_at;

        return ImportBatch::query()
            ->where('id', '!=', $latestBatch->id)
            ->where('status', 'imported')
            ->when(
                $latestBatch->source_type === null,
                fn ($query) => $query->whereNull('source_type'),
                fn ($query) => $query->where('source_type', $latestBatch->source_type)
            )
            ->when($latestImportedAt, function ($query) use ($latestImportedAt, $latestBatch) {
                $query->where(function ($older) use ($latestImportedAt, $latestBatch) {
                    $older->where('imported_at', '<', $latestImportedAt)
                        ->orWhere(function ($sameTimestamp) use ($latestImportedAt, $latestBatch) {
                            $sameTimestamp->where('imported_at', $latestImportedAt)
                                ->where('id', '<', $latestBatch->id);
                        });
                });
            }, fn ($query) => $query->where('id', '<', $latestBatch->id))
            ->whereHas('transactions', function ($query) use ($branchId, $monthStart, $monthEnd) {
                $query->where('branch_id', $branchId)
                    ->whereBetween('invoice_date', [$monthStart, $monthEnd]);
            })
            ->orderByDesc('imported_at')
            ->orderByDesc('id')
            ->first();
    }

    private function transactionsForGroup(ImportBatch $batch, int $branchId, string $invoiceMonth): EloquentCollection
    {
        [$monthStart, $monthEnd] = $this->monthRange($invoiceMonth);

        return $batch->transactions()
            ->where('branch_id', $branchId)
            ->whereBetween('invoice_date', [$monthStart, $monthEnd])
            ->get();
    }

    private function matchingKeys(Collection $transactions): array
    {
        $keys = [
            'receipt' => [],
            'account_date' => [],
            'account_date_amount' => [],
        ];

        foreach ($transactions as $transaction) {
            $receipt = $this->normalizeIdentityValue($transaction->receipt_number);
            if ($receipt !== '') {
                $keys['receipt'][$this->receiptKey((int) $transaction->branch_id, $receipt)] = true;
            }

            $account = $this->normalizeIdentityValue($transaction->account_number);
            $date = $this->invoiceDate($transaction);

            if ($account !== '' && $date !== null) {
                $keys['account_date'][$this->accountDateKey((int) $transaction->branch_id, $account, $date)] = true;

                $amountCents = $this->effectiveAmountCents($transaction);
                if ($amountCents !== null) {
                    $keys['account_date_amount'][$this->accountDateAmountKey((int) $transaction->branch_id, $account, $date, $amountCents)] = true;
                }
            }
        }

        return $keys;
    }

    private function hasMatchingLatestTransaction(SalesTransaction $previousTransaction, array $latestKeys): bool
    {
        $branchId = (int) $previousTransaction->branch_id;
        $receipt = $this->normalizeIdentityValue($previousTransaction->receipt_number);

        if ($receipt !== '' && isset($latestKeys['receipt'][$this->receiptKey($branchId, $receipt)])) {
            return true;
        }

        $account = $this->normalizeIdentityValue($previousTransaction->account_number);
        $date = $this->invoiceDate($previousTransaction);

        if ($account === '' || $date === null) {
            return false;
        }

        if (isset($latestKeys['account_date'][$this->accountDateKey($branchId, $account, $date)])) {
            return true;
        }

        $amountCents = $this->effectiveAmountCents($previousTransaction);

        return $amountCents !== null
            && isset($latestKeys['account_date_amount'][$this->accountDateAmountKey($branchId, $account, $date, $amountCents)]);
    }

    private function createMissingConflict(
        ImportBatch $latestBatch,
        ImportBatch $previousBatch,
        SalesTransaction $previousTransaction,
        string $invoiceMonth,
        ?int $latestSheetId
    ): ImportConflict {
        $matchKey = hash('sha256', implode('|', [
            'missing_from_latest_import',
            $latestBatch->id,
            $previousTransaction->id,
        ]));

        $conflict = ImportConflict::firstOrNew([
            'import_batch_id' => $latestBatch->id,
            'conflict_type' => 'missing_from_latest_import',
            'existing_sales_transaction_id' => $previousTransaction->id,
        ]);

        $conflict->fill([
            'import_batch_sheet_id' => $latestSheetId,
            'branch_id' => $previousTransaction->branch_id,
            'source_row_number' => $previousTransaction->source_row_number,
            'match_key' => $matchKey,
            'new_row_hash' => null,
            'existing_row_data' => $previousTransaction->raw_row_data ?: $previousTransaction->toArray(),
            'incoming_row_data' => [
                'latest_import_batch_id' => $latestBatch->id,
                'previous_import_batch_id' => $previousBatch->id,
                'invoice_month' => $invoiceMonth,
                'review_type' => 'missing_from_latest_import',
            ],
            'notes' => 'Previous transaction was not found in the latest comparable import. Audit-only flag; sales totals are unchanged.',
        ]);

        if (! $conflict->exists) {
            $conflict->status = 'pending';
        }

        $conflict->save();

        return $conflict;
    }

    private function effectiveAmountCents(SalesTransaction $transaction): ?int
    {
        foreach (['promissory_note_amount', 'cash_amount', 'gross_sales_amount', 'srp_cod_amount', 'amount'] as $field) {
            $cents = $this->decimalToCents($transaction->{$field});

            if ($cents !== null && $cents !== 0) {
                return $cents;
            }
        }

        return $this->decimalToCents($transaction->amount);
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

    private function invoiceDate(SalesTransaction $transaction): ?string
    {
        return $transaction->invoice_date
            ? Carbon::parse($transaction->invoice_date)->format('Y-m-d')
            : null;
    }

    private function invoiceMonth(SalesTransaction $transaction): string
    {
        return Carbon::parse($transaction->invoice_date)->format('Y-m');
    }

    private function monthRange(string $invoiceMonth): array
    {
        $start = Carbon::createFromFormat('Y-m-d', "{$invoiceMonth}-01")->startOfMonth();

        return [
            $start->toDateString(),
            $start->copy()->endOfMonth()->toDateString(),
        ];
    }

    private function groupKey(int $branchId, string $invoiceMonth): string
    {
        return "{$branchId}|{$invoiceMonth}";
    }

    private function receiptKey(int $branchId, string $receipt): string
    {
        return "{$branchId}|{$receipt}";
    }

    private function accountDateKey(int $branchId, string $account, string $date): string
    {
        return "{$branchId}|{$account}|{$date}";
    }

    private function accountDateAmountKey(int $branchId, string $account, string $date, int $amountCents): string
    {
        return "{$branchId}|{$account}|{$date}|{$amountCents}";
    }

    private function normalizeIdentityValue(?string $value): string
    {
        return strtoupper(trim(preg_replace('/\s+/', ' ', (string) $value)));
    }
}
