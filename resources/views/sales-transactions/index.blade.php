<x-app-layout>
    <style>
        :root {
            --summary-blue: #0f3b78;
            --summary-blue-dark: #0b2f60;
            --summary-border: #cfd9ea;
            --summary-bg: #f4f7fb;
            --summary-card-bg: #ffffff;
            --summary-text: #162033;
            --summary-muted: #6b7280;

            --summary-success-bg: #eaf7ee;
            --summary-success-text: #1f7a3d;

            --summary-warning-bg: #fff8e6;
            --summary-warning-text: #b7791f;

            --summary-danger-bg: #fdecec;
            --summary-danger-text: #b42318;

            --summary-info-bg: #eaf4ff;
            --summary-info-text: #175cd3;

            --summary-secondary-bg: #eef2f7;
            --summary-secondary-text: #475467;
        }

        body {
            background: var(--summary-bg);
        }

        .summary-shell {
            max-width: 1700px;
            margin: 0 auto;
        }

        .page-with-fixed-nav {
            padding-top: 6.5rem;
        }

        .summary-hero {
            background: linear-gradient(135deg, var(--summary-blue-dark), var(--summary-blue));
            border-radius: 1.25rem;
            overflow: hidden;
            color: #fff;
            box-shadow: 0 18px 40px rgba(15, 59, 120, 0.12);
        }

        .summary-hero-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .summary-date-box {
            min-width: 240px;
            background: rgba(255, 255, 255, 0.10);
            border-left: 1px solid rgba(255, 255, 255, 0.15);
        }

        .summary-date-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.85;
            letter-spacing: 0.04em;
        }

        .summary-date-value {
            font-size: 1.1rem;
            font-weight: 800;
            margin-top: 0.35rem;
            text-align: center;
        }

        .summary-card {
            background: var(--summary-card-bg);
            border: 1px solid var(--summary-border);
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(15, 59, 120, 0.06);
            overflow: hidden;
        }

        .summary-section-header {
            background: var(--summary-blue);
            color: #fff;
            padding: 1rem 1.25rem;
        }

        .summary-section-header h5 {
            margin: 0;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 1rem;
            letter-spacing: 0.02em;
        }

        .summary-section-subtitle {
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.88rem;
            margin-top: 0.25rem;
        }

        .summary-toolbar {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--summary-border);
            background: #fbfdff;
        }

        .summary-stat {
            background: #fff;
            border: 1px solid var(--summary-border);
            border-radius: 0.9rem;
            padding: 1rem 1.1rem;
            height: 100%;
        }

        .summary-stat-label {
            color: var(--summary-muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.03em;
            margin-bottom: 0.35rem;
        }

        .summary-stat-value {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--summary-text);
            line-height: 1.1;
        }

        .summary-stat-sub {
            color: var(--summary-muted);
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .form-label {
            font-weight: 700;
            color: var(--summary-text);
            margin-bottom: 0.45rem;
        }

        .form-control,
        .form-select {
            border-radius: 0.85rem;
            border: 1px solid var(--summary-border);
            padding: 0.8rem 0.95rem;
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #7aa7e8;
            box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
        }

        .report-table {
            width: 100%;
            margin-bottom: 0;
        }

        .report-table thead th {
            background: var(--summary-blue);
            color: #fff;
            border-color: #43689f;
            font-size: 0.84rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            vertical-align: middle;
        }

        .report-table td,
        .report-table th {
            padding: 0.9rem 1rem;
            vertical-align: middle;
        }

        .report-table tbody tr:nth-child(even) {
            background: #fafcff;
        }

        .report-table tbody td {
            border-color: #dde6f3;
            color: var(--summary-text);
        }

        .soft-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.42rem 0.75rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .soft-badge.success {
            background: var(--summary-success-bg);
            color: var(--summary-success-text);
        }

        .soft-badge.warning {
            background: var(--summary-warning-bg);
            color: var(--summary-warning-text);
        }

        .soft-badge.danger {
            background: var(--summary-danger-bg);
            color: var(--summary-danger-text);
        }

        .soft-badge.info {
            background: var(--summary-info-bg);
            color: var(--summary-info-text);
        }

        .soft-badge.secondary {
            background: var(--summary-secondary-bg);
            color: var(--summary-secondary-text);
        }

        .btn-summary-primary {
            background: var(--summary-blue);
            border-color: var(--summary-blue);
            color: #fff;
            border-radius: 999px;
            font-weight: 700;
            padding: 0.7rem 1.2rem;
        }

        .btn-summary-primary:hover {
            background: var(--summary-blue-dark);
            border-color: var(--summary-blue-dark);
            color: #fff;
        }

        .btn-summary-success {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.7rem 1.2rem;
        }

        .btn-summary-outline {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.7rem 1.2rem;
        }

        .btn-summary-outline-sm {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.4rem 0.85rem;
        }

        .truncate-cell {
            max-width: 240px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .amount-col {
            text-align: right;
            white-space: nowrap;
        }

        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            color: var(--summary-muted);
        }

        .empty-state-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--summary-text);
            margin-bottom: 0.4rem;
        }

        @media (max-width: 991.98px) {
            .summary-hero-title {
                font-size: 1.55rem;
            }

            .summary-date-box {
                min-width: 100%;
                border-left: 0;
                border-top: 1px solid rgba(255, 255, 255, 0.15);
            }
        }
    </style>

    <div class="summary-shell page-with-fixed-nav px-3 px-md-4 py-4">
        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Sales Transactions</div>
                    <div class="mt-2 text-white-50">
                        Browse imported sales transaction records, apply filters, and export result sets for reporting.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Date</div>
                    <div class="summary-date-value">{{ now()->format('F d, Y') }}</div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div class="text-muted small">
                Reviewing <strong>{{ $transactions->total() }}</strong> transaction record(s)
            </div>

            <div>
                <a href="{{ route('sales-transactions.export', request()->query()) }}" class="btn btn-success btn-summary-success">
                    Export CSV
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Total Records</div>
                    <div class="summary-stat-value">{{ $transactions->total() }}</div>
                    <div class="summary-stat-sub">Transactions matching the current filter set</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Current Page</div>
                    <div class="summary-stat-value">{{ $transactions->currentPage() }}</div>
                    <div class="summary-stat-sub">Page currently being viewed in the list</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Per Page</div>
                    <div class="summary-stat-value">{{ $transactions->perPage() }}</div>
                    <div class="summary-stat-sub">Number of records displayed per page</div>
                </div>
            </div>
        </div>

        <div class="summary-card mb-4">
            <div class="summary-section-header">
                <h5>Transaction Filters</h5>
                <div class="summary-section-subtitle">
                    Narrow results by branch, import batch, customer, account number, and date range.
                </div>
            </div>

            <div class="p-4">
                <form method="GET" action="{{ route('sales-transactions.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-select">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="import_batch_id" class="form-label">Import Batch</label>
                            <select name="import_batch_id" id="import_batch_id" class="form-select">
                                <option value="">All Batches</option>
                                @foreach($importBatches as $batch)
                                    <option value="{{ $batch->id }}" {{ request('import_batch_id') == $batch->id ? 'selected' : '' }}>
                                        #{{ $batch->id }} - {{ $batch->original_filename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input
                                type="text"
                                name="customer_name"
                                id="customer_name"
                                class="form-control"
                                value="{{ request('customer_name') }}"
                            >
                        </div>

                        <div class="col-md-3">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input
                                type="text"
                                name="account_number"
                                id="account_number"
                                class="form-control"
                                value="{{ request('account_number') }}"
                            >
                        </div>

                        <div class="col-md-3">
                            <label for="date_from" class="form-label">Date From</label>
                            <input
                                type="date"
                                name="date_from"
                                id="date_from"
                                class="form-control"
                                value="{{ request('date_from') }}"
                            >
                        </div>

                        <div class="col-md-3">
                            <label for="date_to" class="form-label">Date To</label>
                            <input
                                type="date"
                                name="date_to"
                                id="date_to"
                                class="form-control"
                                value="{{ request('date_to') }}"
                            >
                        </div>

                        <div class="col-md-3">
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select name="sort_by" id="sort_by" class="form-select">
                                <option value="newest" {{ request('sort_by', 'newest') === 'newest' ? 'selected' : '' }}>
                                    Newest to Oldest
                                </option>
                                <option value="oldest" {{ request('sort_by') === 'oldest' ? 'selected' : '' }}>
                                    Oldest to Newest
                                </option>
                                <option value="customer_asc" {{ request('sort_by') === 'customer_asc' ? 'selected' : '' }}>
                                    Customer Name A-Z
                                </option>
                                <option value="customer_desc" {{ request('sort_by') === 'customer_desc' ? 'selected' : '' }}>
                                    Customer Name Z-A
                                </option>
                                <option value="pn_high" {{ request('sort_by') === 'pn_high' ? 'selected' : '' }}>
                                    Highest Promissory Note
                                </option>
                                <option value="pn_low" {{ request('sort_by') === 'pn_low' ? 'selected' : '' }}>
                                    Lowest Promissory Note
                                </option>
                                <option value="cash_high" {{ request('sort_by') === 'cash_high' ? 'selected' : '' }}>
                                    Highest Cash
                                </option>
                                <option value="cash_low" {{ request('sort_by') === 'cash_low' ? 'selected' : '' }}>
                                    Lowest Cash
                                </option>
                                <option value="srp_high" {{ request('sort_by') === 'srp_high' ? 'selected' : '' }}>
                                    Highest SRP / COD
                                </option>
                                <option value="srp_low" {{ request('sort_by') === 'srp_low' ? 'selected' : '' }}>
                                    Lowest SRP / COD
                                </option>
                            </select>
                        </div>

                    <div class="col-md-3">
                        <label for="sales_type" class="form-label">Sales Type</label>
                        <select name="sales_type" id="sales_type" class="form-select">
                            <option value="">All Sales Types</option>
                            <option value="CASH" {{ request('sales_type') === 'CASH' ? 'selected' : '' }}>Cash</option>
                            <option value="INSTALLMENT" {{ request('sales_type') === 'INSTALLMENT' ? 'selected' : '' }}>Installment</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="transaction_type" class="form-label">Transaction Type</label>
                        <select name="transaction_type" id="transaction_type" class="form-select">
                            <option value="">All Transaction Types</option>
                            <option value="MOTORCYCLE" {{ request('transaction_type') === 'MOTORCYCLE' ? 'selected' : '' }}>Motorcycle</option>
                            <option value="APPLIANCE" {{ request('transaction_type') === 'APPLIANCE' ? 'selected' : '' }}>Appliance</option>
                        </select>
                    </div>

                        <div class="col-12 d-flex gap-2 flex-wrap mt-3">
                            <button type="submit" class="btn btn-summary-primary">Apply Filters</button>
                            <a href="{{ route('sales-transactions.index') }}" class="btn btn-outline-secondary btn-summary-outline">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-section-header">
                <h5>Transaction Records</h5>
                <div class="summary-section-subtitle">
                    Imported sales transaction records with financial values and source references.
                </div>
            </div>

            <div class="summary-toolbar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="text-muted small">
                    Showing <strong>{{ $transactions->count() }}</strong> record(s) on this page out of
                    <strong>{{ $transactions->total() }}</strong> total
                </div>

                <div class="text-muted small">
                    Export respects the current filter set
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th>Invoice Date</th>
                                <th>Account Number</th>
                                <th>Customer Name</th>
                                <th>Product</th>
                                <th class="amount-col">SRP / COD</th>
                                <th class="amount-col">Cash</th>
                                <th class="amount-col">Promissory Note</th>
                                <th>Terms</th>
                                <th>Branch</th>
                                <th>Import Batch</th>
                                <th>Row #</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ optional($transaction->invoice_date)->format('Y-m-d') ?? '-' }}</td>
                                    <td>{{ $transaction->account_number ?? '-' }}</td>
                                    <td class="truncate-cell" title="{{ $transaction->customer_name ?? '-' }}">
                                        {{ $transaction->customer_name ?? '-' }}
                                    </td>
                                    <td class="truncate-cell" title="{{ $transaction->product ?? '-' }}">
                                        {{ $transaction->product ?? '-' }}
                                    </td>
                                    <td class="amount-col">
                                        {{ $transaction->srp_cod_amount !== null ? number_format((float) $transaction->srp_cod_amount, 2) : '-' }}
                                    </td>
                                    <td class="amount-col">
                                        {{ $transaction->cash_amount !== null ? number_format((float) $transaction->cash_amount, 2) : '-' }}
                                    </td>
                                    <td class="amount-col fw-semibold">
                                        {{ $transaction->promissory_note_amount !== null ? number_format((float) $transaction->promissory_note_amount, 2) : '-' }}
                                    </td>
                                    <td>{{ $transaction->terms ?? '-' }}</td>
                                    <td>{{ $transaction->branch->display_name ?? '-' }}</td>
                                    <td>#{{ $transaction->import_batch_id }}</td>
                                    <td>{{ $transaction->source_row_number ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('sales-transactions.show', $transaction) }}"
                                           class="btn btn-sm btn-outline-primary btn-summary-outline-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="p-0">
                                        <div class="empty-state">
                                            <div class="empty-state-title">No sales transactions found</div>
                                            <div>No transaction records matched the current filters.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($transactions->hasPages())
                <div class="card-footer bg-white border-0 px-4 py-3">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>