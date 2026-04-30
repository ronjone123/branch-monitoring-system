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
            max-width: 1600px;
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
            font-size: 1.05rem;
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

        .detail-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem 1rem;
        }

        .detail-item {
            border: 1px solid var(--summary-border);
            border-radius: 0.85rem;
            padding: 0.85rem 0.95rem;
            background: #fff;
        }

        .detail-label {
            font-size: 0.76rem;
            font-weight: 800;
            color: var(--summary-muted);
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 0.3rem;
        }

        .detail-value {
            font-size: 0.96rem;
            font-weight: 700;
            color: var(--summary-text);
            word-break: break-word;
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

        .btn-summary-outline {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.7rem 1.2rem;
        }

        .conflict-item {
            border: 1px solid var(--summary-border);
            border-radius: 0.95rem;
            padding: 1rem;
            background: #fff;
        }

        .money-highlight {
            background: #f8fbff;
            border: 1px solid #dce8fa;
            border-radius: 1rem;
            padding: 1rem;
        }

        .money-highlight-label {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--summary-muted);
            margin-bottom: 0.3rem;
        }

        .money-highlight-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--summary-text);
            line-height: 1.1;
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

            .detail-list {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="summary-shell page-with-fixed-nav px-3 px-md-4 py-4">
        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Sales Transaction Record</div>
                    <div class="mt-2 text-white-50">
                        Review customer, product, financial, import, and conflict details for this transaction.
                    </div>

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <span class="soft-badge success">{{ $salesTransaction->sales_type ?? 'N/A' }}</span>
                        <span class="soft-badge info">{{ $salesTransaction->transaction_type ?? '-' }}</span>
                        <span class="soft-badge secondary">{{ $salesTransaction->branch?->display_name ?? '-' }}</span>
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Invoice Date</div>
                    <div class="summary-date-value">
                        {{ $salesTransaction->invoice_date ? \Carbon\Carbon::parse($salesTransaction->invoice_date)->format('M d, Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div class="text-muted small">
                Customer <strong>{{ $salesTransaction->customer_name ?? '-' }}</strong>
                · Account <strong>{{ $salesTransaction->account_number ?? '-' }}</strong>
                · Receipt <strong>{{ $salesTransaction->receipt_number ?? '-' }}</strong>
            </div>

            <div>
                <a href="{{ route('sales-transactions.index') }}" class="btn btn-outline-secondary btn-summary-outline">
                    Back to Transactions
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Promissory Note</div>
                    <div class="summary-stat-value">
                        ₱{{ number_format((float) ($salesTransaction->promissory_note_amount ?? 0), 2) }}
                    </div>
                    <div class="summary-stat-sub">Recorded PN amount for the transaction</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Cash Amount</div>
                    <div class="summary-stat-value">
                        ₱{{ number_format((float) ($salesTransaction->cash_amount ?? 0), 2) }}
                    </div>
                    <div class="summary-stat-sub">Cash portion associated with the sale</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Gross Sales</div>
                    <div class="summary-stat-value">
                        ₱{{ number_format((float) ($salesTransaction->gross_sales_amount ?? 0), 2) }}
                    </div>
                    <div class="summary-stat-sub">Gross sales amount reflected in the record</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Terms</div>
                    <div class="summary-stat-value">{{ $salesTransaction->terms ?? '-' }}</div>
                    <div class="summary-stat-sub">Terms linked to this transaction</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="summary-card h-100">
                            <div class="summary-section-header">
                                <h5>Customer Information</h5>
                                <div class="summary-section-subtitle">
                                    Primary customer and transaction identity details.
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="detail-list">
                                    <div class="detail-item">
                                        <div class="detail-label">Customer Name</div>
                                        <div class="detail-value">{{ $salesTransaction->customer_name ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Account Number</div>
                                        <div class="detail-value">{{ $salesTransaction->account_number ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Receipt Number</div>
                                        <div class="detail-value">{{ $salesTransaction->receipt_number ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Contact Number</div>
                                        <div class="detail-value">{{ $salesTransaction->contact_number ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Birth Date</div>
                                        <div class="detail-value">{{ $salesTransaction->birth_date ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Sales Source</div>
                                        <div class="detail-value">{{ $salesTransaction->sales_source ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item" style="grid-column: 1 / -1;">
                                        <div class="detail-label">Transaction Type</div>
                                        <div class="detail-value">{{ $salesTransaction->transaction_type ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="summary-card h-100">
                            <div class="summary-section-header">
                                <h5>Address Information</h5>
                                <div class="summary-section-subtitle">
                                    Customer location and assigned branch details.
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="detail-list">
                                    <div class="detail-item">
                                        <div class="detail-label">Street / Sitio / Purok</div>
                                        <div class="detail-value">{{ $salesTransaction->street_address ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Municipality / City</div>
                                        <div class="detail-value">{{ $salesTransaction->city_municipality ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item" style="grid-column: 1 / -1;">
                                        <div class="detail-label">Branch</div>
                                        <div class="detail-value">{{ $salesTransaction->branch?->display_name ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="summary-card">
                            <div class="summary-section-header">
                                <h5>Product Information</h5>
                                <div class="summary-section-subtitle">
                                    Product line, identifiers, and unit reference details.
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="mb-4">
                                    <span class="soft-badge info">{{ $salesTransaction->unit_type ?? '-' }}</span>
                                </div>

                                <div class="detail-list">
                                    <div class="detail-item">
                                        <div class="detail-label">Line</div>
                                        <div class="detail-value">{{ $salesTransaction->product_line_name ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Category</div>
                                        <div class="detail-value">{{ $salesTransaction->category_name_raw ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Brand</div>
                                        <div class="detail-value">{{ $salesTransaction->brand_name_raw ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Model</div>
                                        <div class="detail-value">{{ $salesTransaction->model ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Serial Number</div>
                                        <div class="detail-value">{{ $salesTransaction->serial_number ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Engine Number</div>
                                        <div class="detail-value">{{ $salesTransaction->engine_number ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Chassis Number</div>
                                        <div class="detail-value">{{ $salesTransaction->chassis_number ?? '-' }}</div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">Stock Code</div>
                                        <div class="detail-value">{{ $salesTransaction->stock_code ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="summary-card mb-4">
                    <div class="summary-section-header">
                        <h5>Financial Summary</h5>
                        <div class="summary-section-subtitle">
                            Main financial values linked to this transaction.
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="money-highlight mb-4">
                            <div class="money-highlight-label">Promissory Note</div>
                            <div class="money-highlight-value">
                                ₱{{ number_format((float) ($salesTransaction->promissory_note_amount ?? 0), 2) }}
                            </div>
                        </div>

                        <div class="detail-list">
                            <div class="detail-item">
                                <div class="detail-label">SRP / COD</div>
                                <div class="detail-value">₱{{ number_format((float) ($salesTransaction->srp_cod_amount ?? 0), 2) }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Cash</div>
                                <div class="detail-value">₱{{ number_format((float) ($salesTransaction->cash_amount ?? 0), 2) }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Gross Sales</div>
                                <div class="detail-value">₱{{ number_format((float) ($salesTransaction->gross_sales_amount ?? 0), 2) }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Downpayment</div>
                                <div class="detail-value">₱{{ number_format((float) ($salesTransaction->downpayment_amount ?? 0), 2) }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Monthly Amortization</div>
                                <div class="detail-value">₱{{ number_format((float) ($salesTransaction->monthly_amortization ?? 0), 2) }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Commission</div>
                                <div class="detail-value">₱{{ number_format((float) ($salesTransaction->commission_amount ?? 0), 2) }}</div>
                            </div>

                            <div class="detail-item" style="grid-column: 1 / -1;">
                                <div class="detail-label">Terms</div>
                                <div class="detail-value">{{ $salesTransaction->terms ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-card mb-4">
                    <div class="summary-section-header">
                        <h5>Import Information</h5>
                        <div class="summary-section-subtitle">
                            Source import details and update history from the sheet.
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="detail-list">
                            <div class="detail-item">
                                <div class="detail-label">Import Batch</div>
                                <div class="detail-value">#{{ $salesTransaction->import_batch_id ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Sheet</div>
                                <div class="detail-value">{{ $salesTransaction->importBatchSheet?->sheet_name ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Encoded By</div>
                                <div class="detail-value">{{ $salesTransaction->encoded_by ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Last Updated From Sheet</div>
                                <div class="detail-value">{{ $salesTransaction->date_last_updated ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>Conflict History</h5>
                        <div class="summary-section-subtitle">
                            Related import conflicts linked to this transaction.
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted small">Related records</div>
                            <span class="soft-badge secondary">{{ $relatedConflicts->count() }}</span>
                        </div>

                        @forelse($relatedConflicts as $conflict)
                            <div class="conflict-item mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>#{{ $conflict->id }}</strong>
                                    <span class="soft-badge secondary">
                                        {{ ucfirst($conflict->status) }}
                                    </span>
                                </div>

                                <div class="small text-muted mb-3">
                                    {{ $conflict->created_at?->format('M d, Y h:i A') }}
                                </div>

                                <a href="{{ route('import-conflicts.show', $conflict) }}"
                                   class="btn btn-sm btn-outline-primary btn-summary-outline w-100">
                                    View Conflict
                                </a>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3">
                                No related conflicts found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>