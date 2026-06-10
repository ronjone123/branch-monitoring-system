<x-app-layout>
    <style>
        .sales-page {
            max-width: 1700px;
            margin: 0 auto;
            padding-top: 6.5rem;
            color: #0f172a;
        }

        .sales-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
        }

        .sales-page-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 900;
            line-height: 1.15;
        }

        .sales-page-subtitle {
            margin: .4rem 0 0;
            color: #64748b;
            font-size: .9rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .sales-page-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: .55rem;
        }

        .sales-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            border-radius: 999px;
            padding: .58rem 1rem;
            font-size: .84rem;
            font-weight: 900;
            line-height: 1;
            text-decoration: none;
            white-space: nowrap;
            transition: background .15s ease, border-color .15s ease, color .15s ease, box-shadow .15s ease, transform .15s ease;
        }

        .sales-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .sales-btn-primary:hover,
        .sales-btn-primary:focus {
            color: #ffffff;
            background: #1d4ed8;
            border-color: #1d4ed8;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .sales-btn-secondary {
            color: #334155;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.14);
        }

        .sales-btn-secondary:hover,
        .sales-btn-secondary:focus {
            color: #0f172a;
            background: #f8fafc;
            border-color: rgba(15, 23, 42, 0.22);
            text-decoration: none;
        }

        .sales-btn:active {
            transform: translateY(0);
        }

        .sales-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .sales-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .8rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .sales-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
        }

        .sales-card-subtitle {
            margin: .25rem 0 0;
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .sales-filter-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .8rem;
            padding: 1rem 1.1rem;
        }

        .sales-filter-summary-label {
            display: block;
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .2rem;
        }

        .sales-filter-summary strong {
            color: #0f172a;
            font-size: .95rem;
            font-weight: 900;
        }

        .sales-filter-summary p {
            margin: .2rem 0 0;
            color: #64748b;
            font-size: .82rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .sales-filter-panel {
            display: none;
            padding: 0 1.1rem 1.1rem;
        }

        .sales-filter-panel.is-open {
            display: block;
        }

        .sales-filter-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: .85rem;
            align-items: end;
            padding-top: 1rem;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .sales-filter-field label {
            display: block;
            color: #475569;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .35rem;
        }

        .sales-filter-field input,
        .sales-filter-field select {
            width: 100%;
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: .75rem;
            padding: .58rem .72rem;
            color: #0f172a;
            background: #ffffff;
            font-size: .86rem;
            box-shadow: none;
        }

        .sales-filter-field input:focus,
        .sales-filter-field select:focus {
            border-color: rgba(37, 99, 235, 0.55);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, 0.10);
        }

        .sales-filter-actions {
            display: flex;
            align-items: center;
            gap: .55rem;
            flex-wrap: wrap;
        }

        .sales-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: .9rem;
            margin: 1.15rem 0;
        }

        .sales-summary-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.055);
            padding: 1rem;
            min-width: 0;
        }

        .sales-summary-label {
            color: #64748b;
            font-size: .74rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .sales-summary-value {
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 900;
            line-height: 1.1;
            margin-top: .45rem;
            word-break: break-word;
        }

        .sales-summary-meta {
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
            margin-top: .35rem;
        }

        .sales-table-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .8rem;
            padding: .9rem 1.1rem;
            color: #64748b;
            font-size: .84rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: #ffffff;
        }

        .sales-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .sales-transactions-table {
            width: 100%;
            min-width: 1180px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .sales-transactions-table thead th {
            background: #f3f4f6;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            padding: .82rem .78rem;
            font-size: .71rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            white-space: nowrap;
            vertical-align: middle;
        }

        .sales-transactions-table tbody td {
            padding: .82rem .78rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: .84rem;
            vertical-align: middle;
        }

        .sales-transactions-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .sales-transactions-table tbody tr:hover td {
            background: #f3f4f6;
        }

        .sales-text-strong {
            font-weight: 900;
            color: #0f172a;
        }

        .sales-muted {
            color: #64748b;
            font-size: .76rem;
            font-weight: 700;
            margin-top: .1rem;
        }

        .sales-truncate {
            max-width: 240px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sales-numeric {
            text-align: right;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        .sales-amount-cash {
            color: #166534;
            font-weight: 900;
        }

        .sales-amount-pn {
            color: #92400e;
            font-weight: 900;
        }

        .sales-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: .26rem .55rem;
            font-size: .68rem;
            font-weight: 900;
            line-height: 1;
            white-space: nowrap;
        }

        .sales-badge-brand-new {
            color: #166534;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.22);
        }

        .sales-badge-repo {
            color: #92400e;
            background: rgba(245, 158, 11, 0.14);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .sales-empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            color: #64748b;
        }

        .sales-empty-title {
            color: #0f172a;
            font-size: 1.05rem;
            font-weight: 900;
            margin-bottom: .35rem;
        }

        .sales-pagination {
            padding: 1rem 1.1rem;
            background: #ffffff;
        }

        @media (max-width: 1199.98px) {
            .sales-filter-grid,
            .sales-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .sales-page {
                padding-top: 5.75rem;
            }

            .sales-page-header,
            .sales-filter-summary,
            .sales-card-header,
            .sales-table-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .sales-page-actions,
            .sales-filter-actions {
                width: 100%;
            }

            .sales-page-actions .sales-btn,
            .sales-filter-actions .sales-btn,
            .sales-filter-summary .sales-btn {
                width: 100%;
            }

            .sales-filter-grid,
            .sales-summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $canExportSalesTransactions = auth()->user()?->hasAnyRole(['super_admin', 'admin', 'importer']);
        $selectedBranch = $branches->first(fn ($branch) => (string) $branch->id === (string) request('branch_id'));
        $selectedBatch = $importBatches->first(fn ($batch) => (string) $batch->id === (string) request('import_batch_id'));
        $sortLabels = [
            'newest' => 'Newest to Oldest',
            'oldest' => 'Oldest to Newest',
            'customer_asc' => 'Customer Name A-Z',
            'customer_desc' => 'Customer Name Z-A',
            'pn_high' => 'Highest Promissory Note',
            'pn_low' => 'Lowest Promissory Note',
            'cash_high' => 'Highest Cash',
            'cash_low' => 'Lowest Cash',
            'srp_high' => 'Highest SRP / COD',
            'srp_low' => 'Lowest SRP / COD',
        ];
        $filterSummary = [
            $selectedBranch?->display_name ?? 'All Branches',
            $selectedBatch ? '#' . $selectedBatch->id : 'All Batches',
            $sortLabels[request('sort_by', 'newest')] ?? 'Newest to Oldest',
        ];
        $latestBatch = $importBatches->first();
        $firstItem = $transactions->firstItem() ?? 0;
        $lastItem = $transactions->lastItem() ?? 0;
    @endphp

    <div class="sales-page px-3 px-md-4 py-4">
        <div class="sales-page-header">
            <div>
                <h1 class="sales-page-title">Sales Transactions</h1>
                <p class="sales-page-subtitle">
                    Review imported sales records, apply filters, and export transaction data for reporting.
                </p>
            </div>

            <div class="sales-page-actions">
                @if($canExportSalesTransactions)
                    <a href="{{ route('sales-transactions.export', request()->query()) }}" class="sales-btn sales-btn-primary">
                        Export CSV
                    </a>
                @else
                    <button type="button"
                            class="sales-btn sales-btn-secondary opacity-50"
                            disabled
                            title="Export is only available for Super Admin, Admin, and Importer.">
                        Export CSV
                    </button>
                @endif
            </div>
        </div>

        <section class="sales-card sales-filter-card mb-3">
            <div class="sales-filter-summary">
                <div>
                    <span class="sales-filter-summary-label">Filters</span>
                    <strong>
                        Showing:
                        @foreach($filterSummary as $summaryItem)
                            {{ $summaryItem }}@if(! $loop->last) &bull; @endif
                        @endforeach
                    </strong>
                    <p>
                        Add branch, batch, customer, account, date, product, transaction, and unit filters.
                    </p>
                </div>

                <button type="button"
                        class="sales-btn sales-btn-primary"
                        data-sales-filter-toggle
                        aria-expanded="false">
                    Show Filters
                </button>
            </div>

            <div class="sales-filter-panel" data-sales-filter-panel>
                <form method="GET" action="{{ route('sales-transactions.index') }}">
                    <div class="sales-filter-grid">
                        <div class="sales-filter-field">
                            <label for="branch_id">Branch</label>
                            <select name="branch_id" id="branch_id">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sales-filter-field">
                            <label for="import_batch_id">Import Batch</label>
                            <select name="import_batch_id" id="import_batch_id">
                                <option value="">All Batches</option>
                                @foreach($importBatches as $batch)
                                    <option value="{{ $batch->id }}" {{ request('import_batch_id') == $batch->id ? 'selected' : '' }}>
                                        #{{ $batch->id }} - {{ $batch->original_filename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sales-filter-field">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ request('customer_name') }}">
                        </div>

                        <div class="sales-filter-field">
                            <label for="account_number">Account Number</label>
                            <input type="text" name="account_number" id="account_number" value="{{ request('account_number') }}">
                        </div>

                        <div class="sales-filter-field">
                            <label for="date_from">Date From</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
                        </div>

                        <div class="sales-filter-field">
                            <label for="date_to">Date To</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
                        </div>

                        <div class="sales-filter-field">
                            <label for="sort_by">Sort By</label>
                            <select name="sort_by" id="sort_by">
                                @foreach($sortLabels as $sortValue => $sortLabel)
                                    <option value="{{ $sortValue }}" {{ request('sort_by', 'newest') === $sortValue ? 'selected' : '' }}>
                                        {{ $sortLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sales-filter-field">
                            <label for="product_group">Product Group</label>
                            <select name="product_group" id="product_group">
                                <option value="">All Product Groups</option>
                                <option value="motorcycle" {{ request('product_group') === 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                <option value="appliance" {{ request('product_group') === 'appliance' ? 'selected' : '' }}>Appliance</option>
                                <option value="furniture" {{ request('product_group') === 'furniture' ? 'selected' : '' }}>Furniture</option>
                                <option value="bed_foam" {{ request('product_group') === 'bed_foam' ? 'selected' : '' }}>Bed / Foam</option>
                                <option value="non_motorcycle" {{ request('product_group') === 'non_motorcycle' ? 'selected' : '' }}>Appliance / Furniture / Foam</option>
                                <option value="spare_parts" {{ request('product_group') === 'spare_parts' ? 'selected' : '' }}>Spare Parts</option>
                            </select>
                        </div>

                        <div class="sales-filter-field">
                            <label for="transaction_type">Transaction Type</label>
                            <select name="transaction_type" id="transaction_type">
                                <option value="">All Transaction Types</option>
                                <option value="cash_sales" {{ request('transaction_type') === 'cash_sales' ? 'selected' : '' }}>Cash Sales</option>
                                <option value="installment_sales" {{ request('transaction_type') === 'installment_sales' ? 'selected' : '' }}>Installment Sales</option>
                            </select>
                        </div>

                        <div class="sales-filter-field">
                            <label for="unit_type">Unit Type</label>
                            <select name="unit_type" id="unit_type">
                                <option value="">All Unit Types</option>
                                <option value="brand_new" {{ request('unit_type') === 'brand_new' ? 'selected' : '' }}>Brand New</option>
                                <option value="repo" {{ request('unit_type') === 'repo' ? 'selected' : '' }}>Repo</option>
                            </select>
                        </div>

                        <div class="sales-filter-actions">
                            <button type="submit" class="sales-btn sales-btn-primary">Apply Filters</button>
                            <a href="{{ route('sales-transactions.index') }}" class="sales-btn sales-btn-secondary">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <div class="sales-summary-grid">
            <article class="sales-summary-card">
                <div class="sales-summary-label">Total Records</div>
                <div class="sales-summary-value">{{ number_format($transactions->total()) }}</div>
                <div class="sales-summary-meta">Transactions matching the current filters</div>
            </article>

            <article class="sales-summary-card">
                <div class="sales-summary-label">Showing Records</div>
                <div class="sales-summary-value">{{ number_format($transactions->count()) }}</div>
                <div class="sales-summary-meta">Records visible on this page</div>
            </article>

            <article class="sales-summary-card">
                <div class="sales-summary-label">Current Page</div>
                <div class="sales-summary-value">{{ number_format($transactions->currentPage()) }}</div>
                <div class="sales-summary-meta">{{ number_format($transactions->perPage()) }} records per page</div>
            </article>

            <article class="sales-summary-card">
                <div class="sales-summary-label">Latest Import Batch</div>
                <div class="sales-summary-value">{{ $latestBatch ? '#' . $latestBatch->id : '-' }}</div>
                <div class="sales-summary-meta">{{ $latestBatch?->original_filename ?? 'No import batch available' }}</div>
            </article>
        </div>

        <section class="sales-card sales-table-card">
            <div class="sales-card-header">
                <div>
                    <h2 class="sales-card-title">Transaction Records</h2>
                    <p class="sales-card-subtitle">
                        Imported sales transaction records with financial values and source references.
                    </p>
                </div>
            </div>

            <div class="sales-table-toolbar">
                <div>
                    Showing <strong>{{ number_format($firstItem) }}</strong>-<strong>{{ number_format($lastItem) }}</strong>
                    of <strong>{{ number_format($transactions->total()) }}</strong> record(s)
                </div>
                <div>Export respects the current filter set</div>
            </div>

            <div class="sales-table-wrap">
                <table class="sales-transactions-table">
                    <thead>
                        <tr>
                            <th>Invoice Date</th>
                            <th>Account Number</th>
                            <th>Customer Name</th>
                            <th>Product / Model</th>
                            <th class="sales-numeric">SRP / COD</th>
                            <th class="sales-numeric">Cash</th>
                            <th class="sales-numeric">Promissory Note</th>
                            <th>Terms</th>
                            <th>Branch</th>
                            <th>Import Batch</th>
                            <th class="sales-numeric">Quantity</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            @php
                                $unitType = strtoupper(trim((string) ($transaction->unit_type ?? '')));
                                $isRepo = in_array($unitType, ['REPO', 'REPOSSESSED', 'REPOSSESSION'], true);
                                $unitTypeLabel = $isRepo ? 'Repo' : 'Brand New';
                                $unitTypeClass = $isRepo ? 'sales-badge-repo' : 'sales-badge-brand-new';
                                $productLabel = $transaction->model
                                    ?: ($transaction->product
                                        ?: ($transaction->product_description
                                            ?: ($transaction->parts_number ?: '-')));
                            @endphp
                            <tr>
                                <td>{{ optional($transaction->invoice_date)->format('Y-m-d') ?? '-' }}</td>
                                <td class="sales-text-strong">{{ $transaction->account_number ?? '-' }}</td>
                                <td>
                                    <div class="sales-truncate sales-text-strong" title="{{ $transaction->customer_name ?? '-' }}">
                                        {{ $transaction->customer_name ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="sales-truncate sales-text-strong" title="{{ $productLabel }}">
                                        {{ $productLabel }}
                                    </div>
                                    <div class="sales-muted">
                                        {{ $transaction->brand_name_raw ?? 'No brand' }}
                                        <span class="sales-badge {{ $unitTypeClass }} ms-1">{{ $unitTypeLabel }}</span>
                                    </div>
                                </td>
                                <td class="sales-numeric">
                                    {{ $transaction->srp_cod_amount !== null ? number_format((float) $transaction->srp_cod_amount, 2) : '-' }}
                                </td>
                                <td class="sales-numeric sales-amount-cash">
                                    {{ $transaction->cash_amount !== null ? number_format((float) $transaction->cash_amount, 2) : '-' }}
                                </td>
                                <td class="sales-numeric sales-amount-pn">
                                    {{ $transaction->promissory_note_amount !== null ? number_format((float) $transaction->promissory_note_amount, 2) : '-' }}
                                </td>
                                <td>{{ $transaction->terms ?? '-' }}</td>
                                <td>
                                    <div class="sales-truncate" title="{{ $transaction->branch->display_name ?? '-' }}">
                                        {{ $transaction->branch->display_name ?? '-' }}
                                    </div>
                                </td>
                                <td>#{{ $transaction->import_batch_id }}</td>
                                <td class="sales-numeric">{{ $transaction->quantity ?? '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('sales-transactions.show', $transaction) }}" class="sales-btn sales-btn-secondary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="p-0">
                                    <div class="sales-empty-state">
                                        <div class="sales-empty-title">No sales transactions found</div>
                                        <div>No transaction records matched the current filters.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="sales-pagination">
                    {{ $transactions->links() }}
                </div>
            @endif
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.querySelector('[data-sales-filter-toggle]');
            const panel = document.querySelector('[data-sales-filter-panel]');

            if (!toggle || !panel) {
                return;
            }

            toggle.addEventListener('click', function () {
                const isOpen = panel.classList.toggle('is-open');

                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                toggle.textContent = isOpen ? 'Hide Filters' : 'Show Filters';
            });
        });
    </script>
</x-app-layout>
