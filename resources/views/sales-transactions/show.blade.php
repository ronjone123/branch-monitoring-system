<x-app-layout>
    <style>
        .transaction-show-page {
            max-width: 1600px;
            margin: 0 auto;
            padding-top: 6.5rem;
            color: #0f172a;
        }

        .transaction-profile-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
        }

        .transaction-page-kicker {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .35rem;
        }

        .transaction-page-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 900;
            line-height: 1.15;
        }

        .transaction-page-subtitle {
            margin: .4rem 0 0;
            color: #64748b;
            font-size: .9rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .transaction-page-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: .55rem;
        }

        .transaction-btn {
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

        .transaction-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .transaction-btn-primary:hover,
        .transaction-btn-primary:focus {
            color: #ffffff;
            background: #1d4ed8;
            border-color: #1d4ed8;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .transaction-btn-secondary {
            color: #334155;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.14);
        }

        .transaction-btn-secondary:hover,
        .transaction-btn-secondary:focus {
            color: #0f172a;
            background: #f8fafc;
            border-color: rgba(15, 23, 42, 0.22);
            text-decoration: none;
        }

        .transaction-btn:active {
            transform: translateY(0);
        }

        .transaction-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .transaction-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .8rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .transaction-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
        }

        .transaction-card-subtitle {
            margin: .25rem 0 0;
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .transaction-hero-card {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: center;
            padding: 1.15rem;
            margin-bottom: 1.15rem;
        }

        .transaction-avatar {
            width: 64px;
            height: 64px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            color: #1d4ed8;
            background: rgba(37, 99, 235, 0.10);
            border: 1px solid rgba(37, 99, 235, 0.18);
            font-size: 1.35rem;
            font-weight: 900;
            line-height: 1;
        }

        .transaction-customer-name {
            margin: 0;
            color: #0f172a;
            font-size: 1.45rem;
            font-weight: 900;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .transaction-hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem .85rem;
            margin-top: .55rem;
            color: #64748b;
            font-size: .84rem;
            font-weight: 700;
            line-height: 1.35;
        }

        .transaction-hero-meta strong {
            color: #334155;
            font-weight: 900;
        }

        .transaction-badge-stack {
            display: flex;
            align-items: flex-end;
            flex-direction: column;
            gap: .4rem;
        }

        .transaction-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: .32rem .65rem;
            font-size: .7rem;
            font-weight: 900;
            line-height: 1;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .transaction-badge-blue {
            color: #1d4ed8;
            background: rgba(37, 99, 235, 0.10);
            border: 1px solid rgba(37, 99, 235, 0.20);
        }

        .transaction-badge-green {
            color: #166534;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.22);
        }

        .transaction-badge-amber {
            color: #92400e;
            background: rgba(245, 158, 11, 0.14);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .transaction-badge-slate {
            color: #475569;
            background: rgba(100, 116, 139, 0.10);
            border: 1px solid rgba(100, 116, 139, 0.18);
        }

        .transaction-kpi-strip {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: .85rem;
            margin-bottom: 1.15rem;
        }

        .transaction-kpi-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.055);
            padding: .95rem;
            min-width: 0;
            border-left: 4px solid #e2e8f0;
        }

        .transaction-kpi-card.blue {
            border-left-color: #6366f1;
        }

        .transaction-kpi-card.green {
            border-left-color: #22c55e;
        }

        .transaction-kpi-card.sky {
            border-left-color: #0ea5e9;
        }

        .transaction-kpi-card.purple {
            border-left-color: #8b5cf6;
        }

        .transaction-kpi-card.cyan {
            border-left-color: #06b6d4;
        }

        .transaction-kpi-card.orange {
            border-left-color: #f97316;
        }

        .transaction-kpi-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .transaction-kpi-value {
            color: #0f172a;
            font-size: 1.08rem;
            font-weight: 900;
            line-height: 1.2;
            margin-top: .45rem;
            word-break: break-word;
        }

        .transaction-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .transaction-info-card {
            min-width: 0;
        }

        .transaction-field-list {
            display: grid;
            gap: .65rem;
            padding: 1rem 1.1rem 1.1rem;
        }

        .transaction-field-row {
            display: grid;
            grid-template-columns: minmax(130px, .55fr) minmax(0, 1fr);
            gap: .85rem;
            align-items: start;
            padding-bottom: .65rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        .transaction-field-row:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .transaction-field-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .transaction-field-value {
            color: #0f172a;
            font-size: .9rem;
            font-weight: 800;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .transaction-money {
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .transaction-related-card {
            margin-top: 1rem;
        }

        .transaction-history-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .transaction-history-table {
            width: 100%;
            min-width: 980px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .transaction-history-table thead th {
            background: #f3f4f6;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            padding: .78rem .75rem;
            font-size: .7rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            white-space: nowrap;
            vertical-align: middle;
        }

        .transaction-history-table tbody td {
            padding: .78rem .75rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: .84rem;
            vertical-align: middle;
        }

        .transaction-history-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .transaction-history-table tbody tr.current td {
            background: rgba(37, 99, 235, 0.06);
        }

        .transaction-history-product {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 900;
        }

        .transaction-history-actions {
            text-align: right;
            white-space: nowrap;
        }

        .transaction-conflict-list {
            display: grid;
            gap: .55rem;
            padding: .8rem .95rem .95rem;
        }

        .transaction-conflict-item {
            display: grid;
            grid-template-columns: minmax(80px, auto) minmax(0, 1fr) auto;
            gap: .75rem;
            align-items: center;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.07);
            border-radius: .75rem;
            padding: .7rem .8rem;
        }

        .transaction-conflict-title {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: .65rem;
            color: #0f172a;
            font-size: .85rem;
            font-weight: 900;
        }

        .transaction-conflict-meta {
            color: #64748b;
            font-size: .78rem;
            font-weight: 700;
        }

        .transaction-empty-state {
            padding: 2rem 1.1rem;
            text-align: center;
            color: #64748b;
            font-size: .9rem;
            font-weight: 700;
        }

        .transaction-audit-card {
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.045);
        }

        .transaction-audit-card .transaction-card-header {
            padding: .85rem .95rem;
        }

        .transaction-audit-panel {
            display: none;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
            background: #f8fafc;
        }

        .transaction-audit-panel.is-open {
            display: block;
        }

        .transaction-audit-toggle {
            min-height: 36px;
            padding: .45rem .8rem;
            font-size: .76rem;
        }

        @media (max-width: 1199.98px) {
            .transaction-kpi-strip {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .transaction-info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .transaction-show-page {
                padding-top: 5.75rem;
            }

            .transaction-profile-header,
            .transaction-hero-card,
            .transaction-card-header {
                align-items: stretch;
                grid-template-columns: 1fr;
                flex-direction: column;
            }

            .transaction-page-actions,
            .transaction-badge-stack {
                align-items: stretch;
                width: 100%;
            }

            .transaction-page-actions .transaction-btn {
                width: 100%;
            }

            .transaction-kpi-strip,
            .transaction-conflict-list {
                grid-template-columns: 1fr;
            }

            .transaction-conflict-item {
                grid-template-columns: 1fr;
                align-items: stretch;
            }

            .transaction-field-row {
                grid-template-columns: 1fr;
                gap: .25rem;
            }
        }
    </style>

    @php
        $dash = '—';
        $money = fn ($value) => $value !== null ? '&#8369;' . number_format((float) $value, 2) : $dash;
        $date = fn ($value, $format = 'M d, Y') => $value ? \Carbon\Carbon::parse($value)->format($format) : $dash;
        $value = fn ($value) => filled($value) ? $value : $dash;
        $unitType = strtoupper(trim((string) ($salesTransaction->unit_type ?? '')));
        $isRepo = in_array($unitType, ['REPO', 'REPOSSESSED', 'REPOSSESSION'], true);
        $unitTypeLabel = $isRepo ? 'Repo' : ($salesTransaction->unit_type ?: 'Brand New');
        $unitTypeBadgeClass = $isRepo ? 'transaction-badge-amber' : 'transaction-badge-green';
        $initials = collect(explode(' ', trim((string) ($salesTransaction->customer_name ?: 'Customer'))))
            ->filter()
            ->take(2)
            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
            ->implode('');
        $productTitle = $salesTransaction->model
            ?: ($salesTransaction->product
                ?: ($salesTransaction->product_description
                    ?: ($salesTransaction->parts_number ?: $dash)));
        $branchLabel = $salesTransaction->branch?->display_name
            ?: ($salesTransaction->branch_name_from_sheet ?: $dash);
        $importedAt = $salesTransaction->created_at
            ? $salesTransaction->created_at->format('M d, Y h:i A')
            : $dash;

        $customerFields = [
            ['Customer Name', $salesTransaction->customer_name],
            ['Account Number', $salesTransaction->account_number],
            ['Receipt Number', $salesTransaction->receipt_number],
            ['Contact Number', $salesTransaction->contact_number],
            ['Birth Date', $date($salesTransaction->birth_date)],
            ['Sales Source', $salesTransaction->sales_source],
            ['Agent / Referral', $salesTransaction->agent_referral_name],
            ['Transaction Type', $salesTransaction->transaction_type],
        ];

        $addressFields = [
            ['Street / Zone / Purok', $salesTransaction->street_address],
            ['Municipality / City', $salesTransaction->city_municipality],
            ['Branch', $branchLabel],
        ];

        $productFields = [
            ['Product Line', $salesTransaction->product_line_name],
            ['Category', $salesTransaction->category_name_raw],
            ['Brand', $salesTransaction->brand_name_raw],
            ['Model', $salesTransaction->model],
            ['Product', $salesTransaction->product],
            ['Capacity', $salesTransaction->capacity],
            ['Description', $salesTransaction->product_description],
            ['Serial Number', $salesTransaction->serial_number],
            ['Engine Number', $salesTransaction->engine_number],
            ['Chassis Number', $salesTransaction->chassis_number],
            ['Parts Number', $salesTransaction->parts_number],
            ['Color', $salesTransaction->color],
            ['Stock Code', $salesTransaction->stock_code],
            ['Product Remarks', $salesTransaction->product_remarks],
        ];

        $financialFields = [
            ['Promissory Note', $money($salesTransaction->promissory_note_amount), true],
            ['SRP / COD', $money($salesTransaction->srp_cod_amount), true],
            ['Cash Amount', $money($salesTransaction->cash_amount), true],
            ['Gross Sales', $money($salesTransaction->gross_sales_amount), true],
            ['Downpayment', $money($salesTransaction->downpayment_amount), true],
            ['Monthly Amortization', $money($salesTransaction->monthly_amortization), true],
            ['Commission', $money($salesTransaction->commission_amount), true],
            ['Terms', $salesTransaction->terms],
        ];

        $importFields = [
            ['Import Batch', $salesTransaction->import_batch_id ? '#' . $salesTransaction->import_batch_id : null],
            ['Sheet', $salesTransaction->importBatchSheet?->sheet_name],
            ['Encoded By / Uploaded By', $salesTransaction->encoded_by],
            ['Source Row Number', $salesTransaction->source_row_number],
            ['Date Last Updated', $date($salesTransaction->date_last_updated)],
            ['Imported At', $importedAt],
        ];
    @endphp

    <div class="transaction-show-page px-3 px-md-4 py-4">
        <div class="transaction-profile-header">
            <div>
                <div class="transaction-page-kicker">Sales Transactions</div>
                <h1 class="transaction-page-title">Sales Transaction Record</h1>
                <p class="transaction-page-subtitle">
                    Complete customer profile, transaction details, and financial summary.
                </p>
            </div>

            <div class="transaction-page-actions">
                <a href="{{ route('sales-transactions.index') }}" class="transaction-btn transaction-btn-secondary">
                    Back to Transactions
                </a>
            </div>
        </div>

        <section class="transaction-card transaction-hero-card">
            <div class="transaction-avatar">{{ $initials ?: 'C' }}</div>

            <div>
                <h2 class="transaction-customer-name">{{ $value($salesTransaction->customer_name) }}</h2>
                <div class="transaction-hero-meta">
                    <span><strong>Account:</strong> {{ $value($salesTransaction->account_number) }}</span>
                    <span><strong>Receipt:</strong> {{ $value($salesTransaction->receipt_number) }}</span>
                    <span><strong>Contact:</strong> {{ $value($salesTransaction->contact_number) }}</span>
                    <span><strong>Date:</strong> {{ $date($salesTransaction->invoice_date) }}</span>
                    <span><strong>Branch:</strong> {{ $branchLabel }}</span>
                </div>
            </div>

            <div class="transaction-badge-stack">
                <span class="transaction-badge {{ $unitTypeBadgeClass }}">{{ $unitTypeLabel }}</span>
                <span class="transaction-badge transaction-badge-blue">{{ $value($salesTransaction->transaction_type) }}</span>
                <span class="transaction-badge transaction-badge-slate">{{ $value($salesTransaction->sales_type) }}</span>
            </div>
        </section>

        <section class="transaction-kpi-strip" aria-label="Financial summary">
            <article class="transaction-kpi-card blue">
                <div class="transaction-kpi-label">Promissory Note</div>
                <div class="transaction-kpi-value">{!! $money($salesTransaction->promissory_note_amount) !!}</div>
            </article>

            <article class="transaction-kpi-card green">
                <div class="transaction-kpi-label">Cash Amount</div>
                <div class="transaction-kpi-value">{!! $money($salesTransaction->cash_amount) !!}</div>
            </article>

            <article class="transaction-kpi-card sky">
                <div class="transaction-kpi-label">Gross Sales</div>
                <div class="transaction-kpi-value">{!! $money($salesTransaction->gross_sales_amount ?? $salesTransaction->srp_cod_amount) !!}</div>
            </article>

            <article class="transaction-kpi-card purple">
                <div class="transaction-kpi-label">Terms</div>
                <div class="transaction-kpi-value">{{ $value($salesTransaction->terms) }}</div>
            </article>

            <article class="transaction-kpi-card cyan">
                <div class="transaction-kpi-label">Downpayment</div>
                <div class="transaction-kpi-value">{!! $money($salesTransaction->downpayment_amount) !!}</div>
            </article>

            <article class="transaction-kpi-card orange">
                <div class="transaction-kpi-label">Monthly Amortization</div>
                <div class="transaction-kpi-value">{!! $money($salesTransaction->monthly_amortization) !!}</div>
            </article>
        </section>

        <div class="transaction-info-grid">
            <section class="transaction-card transaction-info-card">
                <div class="transaction-card-header">
                    <div>
                        <h2 class="transaction-card-title">Customer Information</h2>
                        <p class="transaction-card-subtitle">Primary customer and transaction identity details.</p>
                    </div>
                </div>

                <div class="transaction-field-list">
                    @foreach($customerFields as [$label, $fieldValue])
                        <div class="transaction-field-row">
                            <div class="transaction-field-label">{{ $label }}</div>
                            <div class="transaction-field-value">{{ $value($fieldValue) }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="transaction-card transaction-info-card">
                <div class="transaction-card-header">
                    <div>
                        <h2 class="transaction-card-title">Address Information</h2>
                        <p class="transaction-card-subtitle">Customer location and assigned branch details.</p>
                    </div>
                </div>

                <div class="transaction-field-list">
                    @foreach($addressFields as [$label, $fieldValue])
                        <div class="transaction-field-row">
                            <div class="transaction-field-label">{{ $label }}</div>
                            <div class="transaction-field-value">{{ $value($fieldValue) }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="transaction-card transaction-info-card">
                <div class="transaction-card-header">
                    <div>
                        <h2 class="transaction-card-title">Product Information</h2>
                        <p class="transaction-card-subtitle">Product line, identifiers, and unit reference details.</p>
                    </div>
                    <span class="transaction-badge {{ $unitTypeBadgeClass }}">{{ $unitTypeLabel }}</span>
                </div>

                <div class="transaction-field-list">
                    <div class="transaction-field-row">
                        <div class="transaction-field-label">Primary Product / Model</div>
                        <div class="transaction-field-value">{{ $productTitle }}</div>
                    </div>

                    @foreach($productFields as [$label, $fieldValue])
                        <div class="transaction-field-row">
                            <div class="transaction-field-label">{{ $label }}</div>
                            <div class="transaction-field-value">{{ $value($fieldValue) }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="transaction-card transaction-info-card">
                <div class="transaction-card-header">
                    <div>
                        <h2 class="transaction-card-title">Financial Summary</h2>
                        <p class="transaction-card-subtitle">Main financial values linked to this transaction.</p>
                    </div>
                </div>

                <div class="transaction-field-list">
                    @foreach($financialFields as $field)
                        <div class="transaction-field-row">
                            <div class="transaction-field-label">{{ $field[0] }}</div>
                            <div class="transaction-field-value {{ ($field[2] ?? false) ? 'transaction-money' : '' }}">
                                {!! ($field[2] ?? false) ? $field[1] : e($value($field[1])) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>

        <section class="transaction-card transaction-related-card">
            <div class="transaction-card-header">
                <div>
                    <h2 class="transaction-card-title">Customer Purchase History</h2>
                    <p class="transaction-card-subtitle">Previous and related purchases linked to this customer/account.</p>
                </div>
                <span class="transaction-badge transaction-badge-blue">{{ number_format($customerPurchaseHistory->count()) }}</span>
            </div>

            @if($customerPurchaseHistory->isNotEmpty())
                <div class="transaction-history-table-wrap">
                    <table class="transaction-history-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Receipt No.</th>
                                <th>Product / Model</th>
                                <th>Unit Type</th>
                                <th>Branch</th>
                                <th class="text-end">Cash Amount</th>
                                <th class="text-end">Promissory Note</th>
                                <th class="text-end">Gross Sales / SRP-COD</th>
                                <th>Terms</th>
                                <th class="transaction-history-actions">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customerPurchaseHistory as $purchase)
                                @php
                                    $purchaseUnitType = strtoupper(trim((string) ($purchase->unit_type ?? '')));
                                    $purchaseIsRepo = in_array($purchaseUnitType, ['REPO', 'REPOSSESSED', 'REPOSSESSION'], true);
                                    $purchaseUnitLabel = $purchaseIsRepo ? 'Repo' : ($purchase->unit_type ?: 'Brand New');
                                    $purchaseBadgeClass = $purchaseIsRepo ? 'transaction-badge-amber' : 'transaction-badge-green';
                                    $purchaseProduct = $purchase->model
                                        ?: ($purchase->product
                                            ?: ($purchase->product_description
                                                ?: ($purchase->parts_number ?: $dash)));
                                    $purchaseGrossOrSrp = $purchase->gross_sales_amount ?? $purchase->srp_cod_amount;
                                @endphp
                                <tr>
                                    <td>{{ $date($purchase->invoice_date) }}</td>
                                    <td>{{ $value($purchase->receipt_number) }}</td>
                                    <td>
                                        <div class="transaction-history-product" title="{{ $purchaseProduct }}">
                                            {{ $purchaseProduct }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="transaction-badge {{ $purchaseBadgeClass }}">{{ $purchaseUnitLabel }}</span>
                                    </td>
                                    <td>{{ $value($purchase->branch?->display_name ?: $purchase->branch_name_from_sheet) }}</td>
                                    <td class="text-end transaction-money">{!! $money($purchase->cash_amount) !!}</td>
                                    <td class="text-end transaction-money">{!! $money($purchase->promissory_note_amount) !!}</td>
                                    <td class="text-end transaction-money">{!! $money($purchaseGrossOrSrp) !!}</td>
                                    <td>{{ $value($purchase->terms) }}</td>
                                    <td class="transaction-history-actions">
                                        <a href="{{ route('sales-transactions.show', $purchase) }}" class="transaction-btn transaction-btn-secondary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="transaction-empty-state">
                    No other purchases found for this customer.
                </div>
            @endif
        </section>

        <section class="transaction-card transaction-related-card">
            <div class="transaction-card-header">
                <div>
                    <h2 class="transaction-card-title">Import Information</h2>
                    <p class="transaction-card-subtitle">Source import details and update history from the sheet.</p>
                </div>
            </div>

            <div class="transaction-field-list">
                @foreach($importFields as [$label, $fieldValue])
                    <div class="transaction-field-row">
                        <div class="transaction-field-label">{{ $label }}</div>
                        <div class="transaction-field-value">{{ $value($fieldValue) }}</div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="transaction-card transaction-related-card transaction-audit-card">
            <div class="transaction-card-header">
                <div>
                    <h2 class="transaction-card-title">Conflict History / Audit Trail</h2>
                    <p class="transaction-card-subtitle">Related import conflicts already linked to this transaction.</p>
                </div>
                <div class="transaction-page-actions">
                    <span class="transaction-badge transaction-badge-slate">{{ number_format($relatedConflicts->count()) }}</span>
                    <button type="button"
                            class="transaction-btn transaction-btn-secondary transaction-audit-toggle"
                            data-conflict-history-toggle
                            aria-expanded="false">
                        Show Conflict History
                    </button>
                </div>
            </div>

            <div class="transaction-audit-panel" data-conflict-history-panel>
                @forelse($relatedConflicts as $conflict)
                    @if($loop->first)
                        <div class="transaction-conflict-list">
                    @endif

                    <article class="transaction-conflict-item">
                        <div class="transaction-conflict-title">
                            <span>#{{ $conflict->id }}</span>
                            <span class="transaction-badge transaction-badge-slate">{{ ucfirst($conflict->status) }}</span>
                        </div>
                        <div class="transaction-conflict-meta">
                            {{ $conflict->created_at?->format('M d, Y h:i A') ?? $dash }}
                        </div>
                        <a href="{{ route('import-conflicts.show', $conflict) }}" class="transaction-btn transaction-btn-secondary">
                            View Conflict
                        </a>
                    </article>

                    @if($loop->last)
                        </div>
                    @endif
                @empty
                    <div class="transaction-empty-state">
                        No conflict history recorded.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.querySelector('[data-conflict-history-toggle]');
            const panel = document.querySelector('[data-conflict-history-panel]');

            if (!toggle || !panel) {
                return;
            }

            toggle.addEventListener('click', function () {
                const isOpen = panel.classList.toggle('is-open');

                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                toggle.textContent = isOpen ? 'Hide Conflict History' : 'Show Conflict History';
            });
        });
    </script>
</x-app-layout>
