<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ImportBatch;
use App\Models\SalesTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesTransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = SalesTransaction::with(['branch', 'importBatch'])
            ->latest();

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('import_batch_id')) {
            $query->where('import_batch_id', $request->import_batch_id);
        }

        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }

        if ($request->filled('account_number')) {
            $query->where('account_number', 'like', '%' . $request->account_number . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        $transactions = $query->paginate(20)->withQueryString();

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
        $salesTransaction->load(['branch', 'importBatch', 'importBatchSheet']);

        return view('sales-transactions.show', compact('salesTransaction'));
    }
}