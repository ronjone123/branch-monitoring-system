<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ImportBatch;
use App\Models\SalesTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\ImportConflict;
use Illuminate\Support\Facades\DB;

class SalesTransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = $this->filteredQuery($request);

        $transactions = $this->applySorting(
                $query->with(['branch', 'importBatch']),
                $request
            )
            ->paginate(20)
            ->withQueryString();

        $branches = Branch::orderBy('display_name')->get();
        $importBatches = ImportBatch::latest()->get();

        return view('sales-transactions.index', compact(
            'transactions',
            'branches',
            'importBatches'
        ));
    }

    public function show(SalesTransaction $salesTransaction): View
    {
        $salesTransaction->load([
            'branch',
            'importBatch',
            'importBatchSheet',
        ]);

        $relatedConflicts = ImportConflict::where('existing_sales_transaction_id', $salesTransaction->id)
            ->latest()
            ->get();

        $customerPurchaseHistory = SalesTransaction::query()
            ->with('branch')
            ->whereKeyNot($salesTransaction->id)
            ->when(filled($salesTransaction->account_number), function ($query) use ($salesTransaction) {
                $query->where('account_number', $salesTransaction->account_number);
            }, function ($query) use ($salesTransaction) {
                $query->when(filled($salesTransaction->customer_name), function ($customerQuery) use ($salesTransaction) {
                    $customerQuery->where('customer_name', $salesTransaction->customer_name);
                }, function ($customerQuery) {
                    $customerQuery->whereRaw('1 = 0');
                });
            })
            ->orderByDesc('invoice_date')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return view('sales-transactions.show', [
            'salesTransaction' => $salesTransaction,
            'relatedConflicts' => $relatedConflicts,
            'customerPurchaseHistory' => $customerPurchaseHistory,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'sales_transactions_' . now()->format('Ymd_His') . '.csv';

        $transactions = $this->applySorting(
                $this->filteredQuery($request)->with(['branch', 'importBatch', 'importBatchSheet']),
                $request
            )
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        return response()->stream(function () use ($transactions) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'Invoice Date',
                'Account Number',
                'Customer Name',
                'Contact Number',
                'Birth Date',
                'Street Address',
                'Municipality / City',
                'Sales Type',
                'Agent / Referral Name',
                'Transaction Type',
                'Receipt Number',
                'Sales Source',
                'Unit Type',
                'Line',
                'Category',
                'Brand',
                'Model',
                'Capacity',
                'Description',
                'Serial Number',
                'Engine Number',
                'Chassis Number',
                'Parts Number',
                'Color',
                'Stock Code',
                'Product Remarks',
                'SRP / COD Amount',
                'Cash Amount',
                'Downpayment Amount',
                'Promissory Note Amount',
                'Gross Sales Amount',
                'Commission Amount',
                'Monthly Amortization',
                'Terms',
                'Branch',
                'Import Batch',
                'Import Sheet',
                'Source Row Number',
                'Encoded By',
                'Date Last Updated',
                'Created At',
            ]);

            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    optional($transaction->invoice_date)->format('Y-m-d'),
                    $transaction->account_number,
                    $transaction->customer_name,
                    $transaction->contact_number,
                    optional($transaction->birth_date)->format('Y-m-d'),
                    $transaction->street_address,
                    $transaction->city_municipality,
                    $transaction->sales_type,
                    $transaction->agent_referral_name,
                    $transaction->transaction_type,
                    $transaction->receipt_number,
                    $transaction->sales_source,
                    $transaction->unit_type,
                    $transaction->product_line_name,
                    $transaction->category_name_raw,
                    $transaction->brand_name_raw,
                    $transaction->model,
                    $transaction->capacity,
                    $transaction->product_description,
                    $transaction->serial_number,
                    $transaction->engine_number,
                    $transaction->chassis_number,
                    $transaction->parts_number,
                    $transaction->color,
                    $transaction->stock_code,
                    $transaction->product_remarks,
                    $transaction->srp_cod_amount,
                    $transaction->cash_amount,
                    $transaction->downpayment_amount,
                    $transaction->promissory_note_amount,
                    $transaction->gross_sales_amount,
                    $transaction->commission_amount,
                    $transaction->monthly_amortization,
                    $transaction->terms,
                    $transaction->branch->display_name ?? null,
                    $transaction->import_batch_id,
                    $transaction->importBatchSheet->sheet_name ?? null,
                    $transaction->source_row_number,
                    $transaction->encoded_by,
                    optional($transaction->date_last_updated)->format('Y-m-d'),
                    optional($transaction->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    private function filteredQuery(Request $request)
    {
        return SalesTransaction::query()
            ->when($request->filled('branch_id'), function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            })
            ->when($request->filled('import_batch_id'), function ($query) use ($request) {
                $query->where('import_batch_id', $request->import_batch_id);
            })
            ->when($request->filled('product_group'), function ($query) use ($request) {
                $productGroup = strtolower((string) $request->product_group);

                if ($productGroup === 'motorcycle') {
                    $query->whereRaw('UPPER(TRIM(product_line_name)) = ?', [
                        'MOTORCYCLE',
                    ]);
                }

                if ($productGroup === 'appliance') {
                    $query->whereIn(DB::raw('UPPER(TRIM(product_line_name))'), [
                        'APPLIANCE',
                        'APPLIANCES',
                    ]);
                }

                if ($productGroup === 'furniture') {
                    $query->whereIn(DB::raw('UPPER(TRIM(product_line_name))'), [
                        'FURNITURE',
                    ]);
                }

                if ($productGroup === 'bed_foam') {
                    $query->whereIn(DB::raw('UPPER(TRIM(product_line_name))'), [
                        'BED OR FOAM',
                        'BED FOAM',
                        'FOAM',
                    ]);
                }

                if ($productGroup === 'non_motorcycle') {
                    $query->whereIn(DB::raw('UPPER(TRIM(product_line_name))'), [
                        'APPLIANCE',
                        'APPLIANCES',
                        'FURNITURE',
                        'BED OR FOAM',
                        'BED FOAM',
                        'FOAM',
                    ]);
                }

                if ($productGroup === 'spare_parts') {
                    $query->whereIn(DB::raw('UPPER(TRIM(product_line_name))'), [
                        'SPARE PARTS',
                        'SPARE PART',
                        'PARTS',
                    ]);
                }
            })
            ->when($request->filled('transaction_type'), function ($query) use ($request) {
                $transactionType = strtolower((string) $request->transaction_type);

                if ($transactionType === 'cash_sales') {
                    $query->whereIn(DB::raw('UPPER(TRIM(transaction_type))'), [
                        'CASH',
                        'CASH SALES',
                    ]);
                }

                if ($transactionType === 'installment_sales') {
                    $query->whereIn(DB::raw('UPPER(TRIM(transaction_type))'), [
                        'INSTALLMENT',
                        'INSTALLMENT SALES',
                    ]);
                }
            })

            ->when($request->filled('unit_type'), function ($query) use ($request) {
                $unitType = strtolower((string) $request->unit_type);

                if ($unitType === 'repo') {
                    $query->whereIn(DB::raw('UPPER(TRIM(unit_type))'), [
                        'REPO',
                        'REPOSSESSED',
                        'REPOSSESSION',
                    ]);
                }

                if ($unitType === 'brand_new') {
                    $query->where(function ($unitQuery) {
                        $unitQuery->whereNull('unit_type')
                            ->orWhere('unit_type', '')
                            ->orWhereNotIn(DB::raw('UPPER(TRIM(unit_type))'), [
                                'REPO',
                                'REPOSSESSED',
                                'REPOSSESSION',
                            ]);
                    });
                }
            })
            ->when($request->filled('customer_name'), function ($query) use ($request) {
                $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
            })
            ->when($request->filled('account_number'), function ($query) use ($request) {
                $query->where('account_number', 'like', '%' . $request->account_number . '%');
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate('invoice_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate('invoice_date', '<=', $request->date_to);
            });
    }

    private function applySorting($query, Request $request)
    {
        $sortBy = $request->get('sort_by', 'newest');

        return match ($sortBy) {
            'oldest' => $query->orderBy('invoice_date', 'asc')
                ->orderBy('id', 'asc'),

            'customer_asc' => $query->orderBy('customer_name', 'asc')
                ->orderBy('id', 'asc'),

            'customer_desc' => $query->orderBy('customer_name', 'desc')
                ->orderBy('id', 'desc'),

            'pn_high' => $query->orderBy('promissory_note_amount', 'desc')
                ->orderBy('id', 'desc'),

            'pn_low' => $query->orderBy('promissory_note_amount', 'asc')
                ->orderBy('id', 'asc'),

            'cash_high' => $query->orderBy('cash_amount', 'desc')
                ->orderBy('id', 'desc'),

            'cash_low' => $query->orderBy('cash_amount', 'asc')
                ->orderBy('id', 'asc'),

            'srp_high' => $query->orderBy('srp_cod_amount', 'desc')
                ->orderBy('id', 'desc'),

            'srp_low' => $query->orderBy('srp_cod_amount', 'asc')
                ->orderBy('id', 'asc'),

            default => $query->orderBy('invoice_date', 'desc')
                ->orderBy('id', 'desc'),
        };
    }
}
