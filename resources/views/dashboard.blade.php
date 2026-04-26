<x-app-layout>
    <style>
        :root {
            --summary-blue: #0f3b78;
            --summary-blue-dark: #0b2f60;
            --summary-border: #cfd9ea;
            --summary-bg: #f4f7fb;
            --summary-card: #ffffff;
            --summary-text: #1f2937;
            --summary-muted: #6b7280;

            --good-bg: #dff3e2;
            --good-text: #1f7a35;

            --warn-bg: #fff2c7;
            --warn-text: #a36a00;

            --danger-bg: #f9d6d6;
            --danger-text: #b42318;

            --info-bg: #d9ebff;
            --info-text: #0f3b78;
        }

        body {
            background: var(--summary-bg);
        }

        .summary-shell {
            max-width: 1600px;
            margin: 0 auto;
        }

        .summary-hero {
            background: linear-gradient(135deg, var(--summary-blue), var(--summary-blue-dark));
            color: #fff;
            border-radius: 1rem;
            border: 1px solid #244f92;
            overflow: hidden;
        }

        .summary-hero-title {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .summary-date-box {
            background: rgba(255, 255, 255, 0.08);
            border-left: 1px solid rgba(255, 255, 255, 0.18);
            min-width: 240px;
        }

        .summary-date-label {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .summary-date-value {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .summary-card {
            background: var(--summary-card);
            border: 1px solid var(--summary-border);
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(15, 59, 120, 0.06);
        }

        .summary-section-header {
            background: var(--summary-blue);
            color: #fff;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            padding: 1rem 1.25rem;
        }

        .summary-section-header h5 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .summary-section-header p {
            margin: 0.25rem 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.88rem;
        }

        .kpi-card {
            border-radius: 1rem;
            border: 2px solid transparent;
            height: 100%;
            box-shadow: 0 8px 24px rgba(15, 59, 120, 0.05);
        }

        .kpi-card.blue {
            background: #eef5ff;
            border-color: #99c2ff;
        }

        .kpi-card.green {
            background: #eefaf1;
            border-color: #9fd6ad;
        }

        .kpi-card.yellow {
            background: #fff8e7;
            border-color: #f1cf7a;
        }

        .kpi-card.purple {
            background: #f4efff;
            border-color: #b9a3f7;
        }

        .kpi-card.teal {
            background: #edf9fb;
            border-color: #8ed3e2;
        }

        .kpi-label {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--summary-blue);
            letter-spacing: 0.02em;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--summary-text);
            line-height: 1.1;
        }

        .kpi-sub {
            font-size: 0.95rem;
            color: var(--summary-muted);
        }

        .trend-up {
            color: var(--good-text);
            font-weight: 700;
        }

        .trend-down {
            color: var(--danger-text);
            font-weight: 700;
        }

        .report-table {
            margin-bottom: 0;
        }

        .report-table thead tr:first-child th {
            background: var(--summary-blue);
            color: #fff;
            border-color: #43689f;
            font-size: 0.86rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }

        .report-table thead tr:nth-child(2) th {
            background: #e9f0fb;
            color: var(--summary-blue-dark);
            border-color: #c7d6ee;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            text-align: center;
        }

        .report-table td,
        .report-table th {
            padding: 0.8rem 0.9rem;
            vertical-align: middle;
        }

        .report-table tbody tr:nth-child(even) {
            background: #fafcff;
        }

        .report-table tbody td {
            border-color: #dde6f3;
        }

        .report-table tfoot th,
        .report-table tfoot td {
            background: #eef4ff;
            font-weight: 800;
            border-color: #c7d6ee;
        }

        .branch-cell {
            min-width: 190px;
        }

        .branch-name {
            font-weight: 700;
            color: var(--summary-text);
        }

        .branch-code {
            font-size: 0.78rem;
            color: var(--summary-muted);
        }

        .amount-col,
        .count-col {
            text-align: right;
            white-space: nowrap;
        }

        .summary-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .summary-chip.good {
            background: var(--good-bg);
            color: var(--good-text);
        }

        .summary-chip.warn {
            background: var(--warn-bg);
            color: var(--warn-text);
        }

        .summary-chip.danger {
            background: var(--danger-bg);
            color: var(--danger-text);
        }

        .summary-chip.info {
            background: var(--info-bg);
            color: var(--info-text);
        }

        .dashboard-table th {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            white-space: nowrap;
            padding: 0.9rem 1rem;
        }

        .dashboard-table td {
            padding: 0.95rem 1rem;
            vertical-align: middle;
        }

        .dashboard-table .amount-col,
        .dashboard-table .count-col {
            text-align: right;
            white-space: nowrap;
        }

        .truncate-cell {
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .report-table {
            width: 100%;
            table-layout: fixed;
            margin-bottom: 0;
        }

        .report-table th,
        .report-table td {
            overflow-wrap: anywhere;
        }

        .branch-cell {
            width: 160px;
            min-width: 160px;
        }

        html {
            scroll-behavior: smooth;
        }

        .report-fab {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 1050;
        }

        .report-fab .btn {
            border-radius: 999px;
            box-shadow: 0 10px 24px rgba(15, 59, 120, 0.18);
            padding: 0.8rem 1.1rem;
            font-weight: 700;
        }

        .report-menu {
        position: absolute;
        right: 0;
        bottom: 58px;
        width: 300px;
        max-height: 70vh;
        background: #fff;
        border: 1px solid var(--summary-border);
        border-radius: 1rem;
        box-shadow: 0 16px 32px rgba(15, 59, 120, 0.14);
        overflow: hidden;
        display: none;
    }

        .report-menu.show {
            display: block;
        }

        .report-menu-header {
            background: var(--summary-blue);
            color: #fff;
            padding: 0.9rem 1rem;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.03em;
        }

        .report-menu-body {
            padding: 0.6rem;
            max-height: calc(70vh - 48px);
            overflow-y: auto;
        }

        .report-menu-group {
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--summary-muted);
            text-transform: uppercase;
            margin: 0.5rem 0 0.35rem;
            padding: 0 0.5rem;
        }

        .report-menu a {
            display: block;
            text-decoration: none;
            color: var(--summary-text);
            padding: 0.7rem 0.8rem;
            border-radius: 0.7rem;
            font-weight: 600;
        }

        .report-menu a:hover {
            background: #eef4ff;
            color: var(--summary-blue);
        }

        @media (max-width: 768px) {
            .summary-hero-title {
                font-size: 1.7rem;
            }

            .summary-date-box {
                min-width: 100%;
                border-left: 0;
                border-top: 1px solid rgba(255, 255, 255, 0.18);
            }

            .kpi-value {
                font-size: 1.6rem;
            }
        }
    </style>

    <div class="summary-shell px-3 px-md-4 py-4">
        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5 d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <div class="summary-hero-title">Summary Dashboard</div>
                        <div class="mt-2 text-white-50">
                            Branch reporting, transaction summaries, and business performance overview
                        </div>
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Date</div>
                    <div class="summary-date-value">
                        {{ now()->format('F d, Y') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 dashboard-card-title">Dashboard Filters</h5>
            </div>
            <div class="card-body px-4 pb-4">
                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="business_unit_id" class="form-label fw-semibold">Business Unit</label>
                            <select name="business_unit_id" id="business_unit_id" class="form-select rounded-3">
                                <option value="">All Business Units</option>
                                @foreach($businessUnits as $businessUnit)
                                    <option value="{{ $businessUnit->id }}"
                                        {{ (string) $selectedBusinessUnitId === (string) $businessUnit->id ? 'selected' : '' }}>
                                        {{ $businessUnit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="branch_id" class="form-label fw-semibold">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-select rounded-3">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ (string) $selectedBranchId === (string) $branch->id ? 'selected' : '' }}>
                                        {{ $branch->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="date_from" class="form-label fw-semibold">Date From</label>
                            <input
                                type="date"
                                name="date_from"
                                id="date_from"
                                class="form-control rounded-3"
                                value="{{ $dateFrom }}"
                            >
                        </div>

                        <div class="col-md-2">
                            <label for="date_to" class="form-label fw-semibold">Date To</label>
                            <input
                                type="date"
                                name="date_to"
                                id="date_to"
                                class="form-control rounded-3"
                                value="{{ $dateTo }}"
                            >
                        </div>

                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-dark rounded-pill px-4">Apply</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

            <div id="appliance-cash" class="summary-card mb-4">
                <div class="summary-section-header">
                    <div>
                        <h5 class="mb-1 dashboard-card-title">Appliance Cash Transactions</h5>
                        <p class="text-muted small mb-0">
                            Lucky 4 appliance cash sales summary by branch.
                        </p>
                    </div>
                </div>

                <div class="p-3 p-md-4">
                    <div class="table-responsive">
                        <table class="table report-table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th rowspan="2">Branch</th>
                                    <th colspan="4" class="text-center">Sales Today</th>
                                    <th colspan="4" class="text-center">Sales To Date</th>
                                    <th colspan="2" class="text-center">Total</th>
                                </tr>
                                <tr>
                                    <th class="count-col">BN Unit</th>
                                    <th class="amount-col">BN COD</th>
                                    <th class="count-col">Repo Unit</th>
                                    <th class="amount-col">Repo COD</th>

                                    <th class="count-col">BN Unit</th>
                                    <th class="amount-col">BN COD</th>
                                    <th class="count-col">Repo Unit</th>
                                    <th class="amount-col">Repo COD</th>

                                    <th class="count-col">Unit</th>
                                    <th class="amount-col">COD</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applianceCashSummary as $row)
                                    <tr>
                                        <td class="branch-cell">
                                            <div class="branch-name">{{ $row->branch_name }}</div>
                                            <div class="branch-code">{{ $row->branch_code }}</div>
                                        </td>

                                        <td class="count-col">{{ $row->today_brand_new_units }}</td>
                                        <td class="amount-col">{{ number_format((float) $row->today_brand_new_cod, 2) }}</td>
                                        <td class="count-col">{{ $row->today_repo_units }}</td>
                                        <td class="amount-col">{{ number_format((float) $row->today_repo_cod, 2) }}</td>

                                        <td class="count-col">{{ $row->todate_brand_new_units }}</td>
                                        <td class="amount-col">{{ number_format((float) $row->todate_brand_new_cod, 2) }}</td>
                                        <td class="count-col">{{ $row->todate_repo_units }}</td>
                                        <td class="amount-col">{{ number_format((float) $row->todate_repo_cod, 2) }}</td>

                                        <td class="count-col fw-semibold">{{ $row->total_units }}</td>
                                        <td class="amount-col fw-semibold">{{ number_format((float) $row->total_cod, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4 text-muted">
                                            No appliance cash transaction data found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>TOTAL</th>
                                    <th class="count-col">{{ $applianceCashTotals->today_brand_new_units }}</th>
                                    <th class="amount-col">{{ number_format((float) $applianceCashTotals->today_brand_new_cod, 2) }}</th>
                                    <th class="count-col">{{ $applianceCashTotals->today_repo_units }}</th>
                                    <th class="amount-col">{{ number_format((float) $applianceCashTotals->today_repo_cod, 2) }}</th>

                                    <th class="count-col">{{ $applianceCashTotals->todate_brand_new_units }}</th>
                                    <th class="amount-col">{{ number_format((float) $applianceCashTotals->todate_brand_new_cod, 2) }}</th>
                                    <th class="count-col">{{ $applianceCashTotals->todate_repo_units }}</th>
                                    <th class="amount-col">{{ number_format((float) $applianceCashTotals->todate_repo_cod, 2) }}</th>

                                    <th class="count-col">{{ $applianceCashTotals->total_units }}</th>
                                    <th class="amount-col">{{ number_format((float) $applianceCashTotals->total_cod, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
                <div id="motorcycle-cash" class="summary-card mb-4">
                    <div class="summary-section-header">
                        <div>
                            <h5 class="mb-1 dashboard-card-title">Motorcycle Cash Transactions</h5>
                            <p class="text-muted small mb-0">
                                Lucky 4 and Motor 8 motorcycle cash sales summary by branch.
                            </p>
                        </div>
                    </div>

                    <div class="p-3 p-md-4">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th rowspan="2">Branch</th>
                                        <th colspan="4" class="text-center">Sales Today</th>
                                        <th colspan="4" class="text-center">Sales To Date</th>
                                        <th colspan="2" class="text-center">Total</th>
                                    </tr>
                                    <tr>
                                        <th class="count-col">BN Unit</th>
                                        <th class="amount-col">BN COD</th>
                                        <th class="count-col">Repo Unit</th>
                                        <th class="amount-col">Repo COD</th>
                                        <th class="count-col">BN Unit</th>
                                        <th class="amount-col">BN COD</th>
                                        <th class="count-col">Repo Unit</th>
                                        <th class="amount-col">Repo COD</th>
                                        <th class="count-col">Unit</th>
                                        <th class="amount-col">COD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($motorcycleCashSummary as $row)
                                        <tr>
                                            <td class="branch-cell">
                                                <div class="branch-name">{{ $row->branch_name }}</div>
                                                <div class="branch-code">{{ $row->branch_code }}</div>
                                            </td>

                                            <td class="count-col">{{ $row->today_brand_new_units }}</td>
                                            <td class="amount-col">{{ number_format((float) $row->today_brand_new_cod, 2) }}</td>
                                            <td class="count-col">{{ $row->today_repo_units }}</td>
                                            <td class="amount-col">{{ number_format((float) $row->today_repo_cod, 2) }}</td>

                                            <td class="count-col">{{ $row->todate_brand_new_units }}</td>
                                            <td class="amount-col">{{ number_format((float) $row->todate_brand_new_cod, 2) }}</td>
                                            <td class="count-col">{{ $row->todate_repo_units }}</td>
                                            <td class="amount-col">{{ number_format((float) $row->todate_repo_cod, 2) }}</td>

                                            <td class="count-col fw-semibold">{{ $row->total_units }}</td>
                                            <td class="amount-col fw-semibold">{{ number_format((float) $row->total_cod, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-4 text-muted">
                                                No motorcycle cash transaction data found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th>TOTAL</th>
                                        <th class="count-col">{{ $motorcycleCashTotals->today_brand_new_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $motorcycleCashTotals->today_brand_new_cod, 2) }}</th>
                                        <th class="count-col">{{ $motorcycleCashTotals->today_repo_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $motorcycleCashTotals->today_repo_cod, 2) }}</th>

                                        <th class="count-col">{{ $motorcycleCashTotals->todate_brand_new_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $motorcycleCashTotals->todate_brand_new_cod, 2) }}</th>
                                        <th class="count-col">{{ $motorcycleCashTotals->todate_repo_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $motorcycleCashTotals->todate_repo_cod, 2) }}</th>

                                        <th class="count-col">{{ $motorcycleCashTotals->total_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $motorcycleCashTotals->total_cod, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="combined-cash" class="summary-card mb-4">
                    <div class="summary-section-header">
                        <div>
                            <h5 class="mb-1 dashboard-card-title">Combined Motorcycle and Appliances Cash Transactions</h5>
                            <p class="text-muted small mb-0">
                                Lucky 4 and Motor 8 combined cash sales summary by branch.
                            </p>
                        </div>
                    </div>

                    <div class="p-3 p-md-4">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th rowspan="2">Branch</th>
                                        <th colspan="4" class="text-center">Sales Today</th>
                                        <th colspan="4" class="text-center">Sales To Date</th>
                                        <th colspan="2" class="text-center">Total</th>
                                    </tr>
                                    <tr>
                                        <th class="count-col">BN Unit</th>
                                        <th class="amount-col">BN COD</th>
                                        <th class="count-col">Repo Unit</th>
                                        <th class="amount-col">Repo COD</th>

                                        <th class="count-col">BN Unit</th>
                                        <th class="amount-col">BN COD</th>
                                        <th class="count-col">Repo Unit</th>
                                        <th class="amount-col">Repo COD</th>

                                        <th class="count-col">Unit</th>
                                        <th class="amount-col">COD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($combinedCashSummary as $row)
                                        <tr>
                                            <td class="branch-cell">
                                                <div class="branch-name">{{ $row->branch_name }}</div>
                                                <div class="branch-code">{{ $row->branch_code }}</div>
                                            </td>

                                            <td class="count-col">{{ $row->today_brand_new_units }}</td>
                                            <td class="amount-col">{{ number_format((float) $row->today_brand_new_cod, 2) }}</td>
                                            <td class="count-col">{{ $row->today_repo_units }}</td>
                                            <td class="amount-col">{{ number_format((float) $row->today_repo_cod, 2) }}</td>

                                            <td class="count-col">{{ $row->todate_brand_new_units }}</td>
                                            <td class="amount-col">{{ number_format((float) $row->todate_brand_new_cod, 2) }}</td>
                                            <td class="count-col">{{ $row->todate_repo_units }}</td>
                                            <td class="amount-col">{{ number_format((float) $row->todate_repo_cod, 2) }}</td>

                                            <td class="count-col fw-semibold">{{ $row->total_units }}</td>
                                            <td class="amount-col fw-semibold">{{ number_format((float) $row->total_cod, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-4 text-muted">
                                                No combined cash transaction data found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th>TOTAL</th>
                                        <th class="count-col">{{ $combinedCashTotals->today_brand_new_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $combinedCashTotals->today_brand_new_cod, 2) }}</th>
                                        <th class="count-col">{{ $combinedCashTotals->today_repo_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $combinedCashTotals->today_repo_cod, 2) }}</th>

                                        <th class="count-col">{{ $combinedCashTotals->todate_brand_new_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $combinedCashTotals->todate_brand_new_cod, 2) }}</th>
                                        <th class="count-col">{{ $combinedCashTotals->todate_repo_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $combinedCashTotals->todate_repo_cod, 2) }}</th>

                                        <th class="count-col">{{ $combinedCashTotals->total_units }}</th>
                                        <th class="amount-col">{{ number_format((float) $combinedCashTotals->total_cod, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

        <div id="appliance-installment" class="summary-card mb-4">
            <div class="summary-section-header">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Appliance Installment Transactions</h5>
                    <p class="text-muted small mb-0">
                        Lucky 4 appliance installment sales summary by branch.
                    </p>
                </div>
            </div>

            <div class="p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">Branch</th>
                                <th colspan="4" class="text-center">Sales Today</th>
                                <th colspan="4" class="text-center">Sales To Date</th>
                                <th colspan="2" class="text-center">Total</th>
                            </tr>
                            <tr>
                                <th class="count-col">BN Unit</th>
                                <th class="amount-col">BN PN</th>
                                <th class="count-col">Repo Unit</th>
                                <th class="amount-col">Repo PN</th>

                                <th class="count-col">BN Unit</th>
                                <th class="amount-col">BN PN</th>
                                <th class="count-col">Repo Unit</th>
                                <th class="amount-col">Repo PN</th>

                                <th class="count-col">Unit</th>
                                <th class="amount-col">PN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applianceInstallmentSummary as $row)
                                <tr>
                                    <td class="branch-cell">
                                        <div class="branch-name">{{ $row->branch_name }}</div>
                                        <div class="branch-code">{{ $row->branch_code }}</div>
                                    </td>

                                    <td class="count-col">{{ $row->today_brand_new_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->today_brand_new_amount, 2) }}</td>
                                    <td class="count-col">{{ $row->today_repo_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->today_repo_amount, 2) }}</td>

                                    <td class="count-col">{{ $row->todate_brand_new_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->todate_brand_new_amount, 2) }}</td>
                                    <td class="count-col">{{ $row->todate_repo_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->todate_repo_amount, 2) }}</td>

                                    <td class="count-col fw-semibold">{{ $row->total_units }}</td>
                                    <td class="amount-col fw-semibold">{{ number_format((float) $row->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">
                                        No appliance installment transaction data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th>TOTAL</th>
                                <th class="count-col">{{ $applianceInstallmentTotals->today_brand_new_units }}</th>
                                <th class="amount-col">{{ number_format((float) $applianceInstallmentTotals->today_brand_new_amount, 2) }}</th>
                                <th class="count-col">{{ $applianceInstallmentTotals->today_repo_units }}</th>
                                <th class="amount-col">{{ number_format((float) $applianceInstallmentTotals->today_repo_amount, 2) }}</th>

                                <th class="count-col">{{ $applianceInstallmentTotals->todate_brand_new_units }}</th>
                                <th class="amount-col">{{ number_format((float) $applianceInstallmentTotals->todate_brand_new_amount, 2) }}</th>
                                <th class="count-col">{{ $applianceInstallmentTotals->todate_repo_units }}</th>
                                <th class="amount-col">{{ number_format((float) $applianceInstallmentTotals->todate_repo_amount, 2) }}</th>

                                <th class="count-col">{{ $applianceInstallmentTotals->total_units }}</th>
                                <th class="amount-col">{{ number_format((float) $applianceInstallmentTotals->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div id="motorcycle-installment" class="summary-card mb-4">
            <div class="summary-section-header">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Motorcycle Installment Transactions</h5>
                    <p class="text-muted small mb-0">
                        Lucky 4 and Motor 8 motorcycle installment sales summary by branch.
                    </p>
                </div>
            </div>

            <div class="p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">Branch</th>
                                <th colspan="4" class="text-center">Sales Today</th>
                                <th colspan="4" class="text-center">Sales To Date</th>
                                <th colspan="2" class="text-center">Total</th>
                            </tr>
                            <tr>
                                <th class="count-col">BN Unit</th>
                                <th class="amount-col">BN PN</th>
                                <th class="count-col">Repo Unit</th>
                                <th class="amount-col">Repo PN</th>

                                <th class="count-col">BN Unit</th>
                                <th class="amount-col">BN PN</th>
                                <th class="count-col">Repo Unit</th>
                                <th class="amount-col">Repo PN</th>

                                <th class="count-col">Unit</th>
                                <th class="amount-col">PN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($motorcycleInstallmentSummary as $row)
                                <tr>
                                    <td class="branch-cell">
                                        <div class="branch-name">{{ $row->branch_name }}</div>
                                        <div class="branch-code">{{ $row->branch_code }}</div>
                                    </td>

                                    <td class="count-col">{{ $row->today_brand_new_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->today_brand_new_amount, 2) }}</td>
                                    <td class="count-col">{{ $row->today_repo_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->today_repo_amount, 2) }}</td>

                                    <td class="count-col">{{ $row->todate_brand_new_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->todate_brand_new_amount, 2) }}</td>
                                    <td class="count-col">{{ $row->todate_repo_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->todate_repo_amount, 2) }}</td>

                                    <td class="count-col fw-semibold">{{ $row->total_units }}</td>
                                    <td class="amount-col fw-semibold">{{ number_format((float) $row->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">
                                        No motorcycle installment transaction data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th>TOTAL</th>
                                <th class="count-col">{{ $motorcycleInstallmentTotals->today_brand_new_units }}</th>
                                <th class="amount-col">{{ number_format((float) $motorcycleInstallmentTotals->today_brand_new_amount, 2) }}</th>
                                <th class="count-col">{{ $motorcycleInstallmentTotals->today_repo_units }}</th>
                                <th class="amount-col">{{ number_format((float) $motorcycleInstallmentTotals->today_repo_amount, 2) }}</th>

                                <th class="count-col">{{ $motorcycleInstallmentTotals->todate_brand_new_units }}</th>
                                <th class="amount-col">{{ number_format((float) $motorcycleInstallmentTotals->todate_brand_new_amount, 2) }}</th>
                                <th class="count-col">{{ $motorcycleInstallmentTotals->todate_repo_units }}</th>
                                <th class="amount-col">{{ number_format((float) $motorcycleInstallmentTotals->todate_repo_amount, 2) }}</th>

                                <th class="count-col">{{ $motorcycleInstallmentTotals->total_units }}</th>
                                <th class="amount-col">{{ number_format((float) $motorcycleInstallmentTotals->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div id="combined-installment" class="summary-card mb-4">
            <div class="summary-section-header">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Combined Motorcycle and Appliances Installment Transactions</h5>
                    <p class="text-muted small mb-0">
                        Lucky 4 and Motor 8 combined installment summary by branch.
                    </p>
                </div>
            </div>

            <div class="p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">Branch</th>
                                <th colspan="4" class="text-center">Sales Today</th>
                                <th colspan="4" class="text-center">Sales To Date</th>
                                <th colspan="2" class="text-center">Total</th>
                            </tr>
                            <tr>
                                <th class="count-col">BN Unit</th>
                                <th class="amount-col">BN PN</th>
                                <th class="count-col">Repo Unit</th>
                                <th class="amount-col">Repo PN</th>

                                <th class="count-col">BN Unit</th>
                                <th class="amount-col">BN PN</th>
                                <th class="count-col">Repo Unit</th>
                                <th class="amount-col">Repo PN</th>

                                <th class="count-col">Unit</th>
                                <th class="amount-col">PN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($combinedInstallmentSummary as $row)
                                <tr>
                                    <td class="branch-cell">
                                        <div class="branch-name">{{ $row->branch_name }}</div>
                                        <div class="branch-code">{{ $row->branch_code }}</div>
                                    </td>
                                    <td class="count-col">{{ $row->today_brand_new_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->today_brand_new_amount, 2) }}</td>
                                    <td class="count-col">{{ $row->today_repo_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->today_repo_amount, 2) }}</td>

                                    <td class="count-col">{{ $row->todate_brand_new_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->todate_brand_new_amount, 2) }}</td>
                                    <td class="count-col">{{ $row->todate_repo_units }}</td>
                                    <td class="amount-col">{{ number_format((float) $row->todate_repo_amount, 2) }}</td>

                                    <td class="count-col fw-semibold">{{ $row->total_units }}</td>
                                    <td class="amount-col fw-semibold">{{ number_format((float) $row->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">
                                        No combined installment data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th>TOTAL</th>
                                <th class="count-col">{{ $combinedInstallmentTotals->today_brand_new_units }}</th>
                                <th class="amount-col">{{ number_format((float) $combinedInstallmentTotals->today_brand_new_amount, 2) }}</th>
                                <th class="count-col">{{ $combinedInstallmentTotals->today_repo_units }}</th>
                                <th class="amount-col">{{ number_format((float) $combinedInstallmentTotals->today_repo_amount, 2) }}</th>

                                <th class="count-col">{{ $combinedInstallmentTotals->todate_brand_new_units }}</th>
                                <th class="amount-col">{{ number_format((float) $combinedInstallmentTotals->todate_brand_new_amount, 2) }}</th>
                                <th class="count-col">{{ $combinedInstallmentTotals->todate_repo_units }}</th>
                                <th class="amount-col">{{ number_format((float) $combinedInstallmentTotals->todate_repo_amount, 2) }}</th>

                                <th class="count-col">{{ $combinedInstallmentTotals->total_units }}</th>
                                <th class="amount-col">{{ number_format((float) $combinedInstallmentTotals->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div id="sales-overview" class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="kpi-card blue p-4">
                    <div class="kpi-label">Sales Today</div>
                    <div class="kpi-value mt-3">{{ number_format((float) $todayAmount, 2) }}</div>
                    <div class="kpi-sub mt-3">Validated from current dashboard totals</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="kpi-card green p-4">
                    <div class="kpi-label">Transactions Today</div>
                    <div class="kpi-value mt-3">{{ $todayTransactionCount }}</div>
                    <div class="kpi-sub mt-3">Count of all matching records</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="kpi-card yellow p-4">
                    <div class="kpi-label">Month-to-Date Sales</div>
                    <div class="kpi-value mt-3">{{ number_format((float) $monthToDateAmount, 2) }}</div>
                    <div class="kpi-sub mt-3">Month-to-date summary amount</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="kpi-card purple p-4">
                    <div class="kpi-label">Month-to-Date Transactions</div>
                    <div class="kpi-value mt-3">{{ $monthToDateTransactionCount }}</div>
                    <div class="kpi-sub mt-3">Month-to-date transaction volume</div>
                </div>
            </div>
        </div>
                <div id="top-summary" class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Top Branch This Month</div>

                        @if($topBranchThisMonth)
                            <div class="fw-semibold fs-5">{{ $topBranchThisMonth->branch_name }}</div>
                            <div class="text-muted small mb-2">{{ $topBranchThisMonth->branch_code }}</div>
                            <div class="fs-3 fw-bold">
                                {{ number_format((float) $topBranchThisMonth->month_to_date_amount, 2) }}
                            </div>
                        @else
                            <div class="text-muted">No branch data found.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Top Business Unit This Month</div>

                        @if($topBusinessUnitThisMonth)
                            <div class="fw-semibold fs-5">{{ $topBusinessUnitThisMonth->name }}</div>
                            <div class="text-muted small mb-2">{{ $topBusinessUnitThisMonth->code }}</div>
                            <div class="fs-3 fw-bold">
                                {{ number_format((float) $topBusinessUnitThisMonth->total_amount, 2) }}
                            </div>
                        @else
                            <div class="text-muted">No business unit data found.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
                    <div id="top-branches" class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Top 5 Branches This Month</h5>
                    <p class="text-muted small mb-0">Highest-performing branches based on month-to-date sales.</p>
                </div>
            </div>

            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Rank</th>
                                <th>Branch</th>
                                <th>Business Unit</th>
                                <th class="count-col">Month-to-Date Transactions</th>
                                <th class="amount-col">Month-to-Date Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topFiveBranchesThisMonth as $index => $branch)
                                <tr>
                                    <td class="fw-semibold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $branch->branch_name }}</div>
                                        <div class="small text-muted">{{ $branch->branch_code }}</div>
                                    </td>
                                    <td>{{ $branch->business_unit_name }}</td>
                                    <td class="count-col">{{ $branch->month_to_date_transaction_count }}</td>
                                    <td class="amount-col fw-semibold">{{ number_format((float) $branch->month_to_date_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No branch ranking data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="branch-performance" class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <div>
                        <h5 class="mb-1 dashboard-card-title">Branch Performance Summary</h5>
                        <p class="text-muted small mb-0">Today and month-to-date sales performance by branch.</p>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Branch</th>
                                <th>Business Unit</th>
                                <th class="count-col">Today Transactions</th>
                                <th class="amount-col">Today Sales</th>
                                <th class="count-col">Month-to-Date Transactions</th>
                                <th class="amount-col">Month-to-Date Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branchPerformanceSummary as $branch)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $branch->branch_name }}</div>
                                        <div class="small text-muted">{{ $branch->branch_code }}</div>
                                    </td>
                                    <td>{{ $branch->business_unit_name }}</td>
                                    <td class="count-col">{{ $branch->today_transaction_count }}</td>
                                    <td class="amount-col fw-semibold">{{ number_format((float) $branch->today_amount, 2) }}</td>
                                    <td class="count-col">{{ $branch->month_to_date_transaction_count }}</td>
                                    <td class="amount-col fw-semibold">{{ number_format((float) $branch->month_to_date_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No branch performance data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="business-unit-totals" class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 dashboard-card-title">Business Unit Totals</h5>
            </div>
            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Business Unit</th>
                                <th class="code-col">Code</th>
                                <th class="count-col">Branch Count</th>
                                <th class="count-col">Transaction Count</th>
                                <th class="amount-col">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($businessUnitTotals as $unit)
                                <tr>
                                    <td>{{ $unit->name }}</td>
                                    <td class="code-col">
                                        <span class="badge rounded-pill text-bg-dark">{{ $unit->code }}</span>
                                    </td>
                                    <td class="count-col">{{ $unit->branch_count }}</td>
                                    <td class="count-col">{{ $unit->transaction_count }}</td>
                                    <td class="amount-col fw-semibold">{{ number_format((float) $unit->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No business unit totals found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="latest-sales-transactions" class="row g-4 mb-4">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="mb-0 dashboard-card-title">Latest Sales Transactions</h5>
                    </div>
                    <div class="card-body pt-0 px-4 pb-4">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Branch</th>
                                        <th class="amount-col">Sales</th>
                                        <th class="text-nowrap">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestTransactions as $transaction)
                                        <tr>
                                            <td class="truncate-cell" title="{{ $transaction->customer_name ?? '-' }}">
                                                <a href="{{ route('sales-transactions.show', $transaction) }}" class="fw-semibold text-decoration-none">
                                                    {{ $transaction->customer_name ?? '-' }}
                                                </a>
                                            </td>
                                            <td>{{ $transaction->branch->display_name ?? '-' }}</td>
                                            <td class="amount-col fw-semibold">
                                                {{ $transaction->promissory_note_amount !== null ? number_format((float) $transaction->promissory_note_amount, 2) : '-' }}
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $transaction->invoice_date ? \Carbon\Carbon::parse($transaction->invoice_date)->format('M d, Y') : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                No transactions found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="branch-transaction-totals" class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 dashboard-card-title">Branch Transaction Totals</h5>
            </div>
            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Branch</th>
                                <th class="count-col">Transaction Count</th>
                                <th class="amount-col">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branchTotals as $branchTotal)
                                <tr>
                                    <td>{{ $branchTotal->branch->display_name ?? '-' }}</td>
                                    <td class="count-col">{{ $branchTotal->transaction_count }}</td>
                                    <td class="amount-col fw-semibold">{{ number_format((float) $branchTotal->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        No branch totals found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="charts-branch-business-unit" class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="mb-0 dashboard-card-title">Transactions by Branch</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="branchTransactionsChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="mb-0 dashboard-card-title">Amount by Business Unit</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="businessUnitAmountChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div id="charts-monthly" class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="mb-0 dashboard-card-title">Transactions by Month</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="transactionsByMonthChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="mb-0 dashboard-card-title">Amount by Month</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="amountByMonthChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->hasAnyRole(['importer', 'admin', 'super_admin']))
            <div id="latest-import-batches" class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="mb-0 dashboard-card-title">Latest Import Batches</h5>
                </div>
                <div class="card-body pt-0 px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table report-table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="id-col">ID</th>
                                    <th>Filename</th>
                                    <th class="status-col">Status</th>
                                    <th>Uploaded By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestImportBatches as $batch)
                                    <tr>
                                        <td class="id-col">
                                            <a href="{{ route('import-batches.show', $batch) }}" class="fw-semibold text-decoration-none">
                                                #{{ $batch->id }}
                                            </a>
                                        </td>
                                        <td class="truncate-cell" title="{{ $batch->original_filename }}">
                                            {{ $batch->original_filename }}
                                        </td>
                                        <td class="status-col">
                                            <span class="badge rounded-pill text-bg-light border">
                                                {{ ucfirst(str_replace('_', ' ', $batch->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $batch->user->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            No import batches found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if(auth()->user()->hasAnyRole(['admin', 'super_admin']))
            <div id="admin-summary" class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="text-muted small mb-2">Active Branches</div>
                            <div class="fs-2 fw-bold">{{ $activeBranches }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="text-muted small mb-2">Sales Transactions</div>
                            <div class="fs-2 fw-bold">{{ $totalSalesTransactions }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="text-muted small mb-2">Total Imported Amount</div>
                            <div class="fs-2 fw-bold">{{ number_format((float) $totalImportedAmount, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(auth()->user()->hasAnyRole(['super_admin', 'admin']))
            <div id="system-totals" class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="text-muted small mb-2">Total Branches</div>
                            <div class="fs-2 fw-bold">{{ $totalBranches }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="text-muted small mb-2">Total Users</div>
                            <div class="fs-2 fw-bold">{{ $totalUsers }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="report-fab">
        <div id="reportMenu" class="report-menu">
            <div class="report-menu-header">Reports</div>
            <div class="report-menu-body">
                <div class="report-menu-group">Cash Reports</div>
                <a href="#appliance-cash">Appliance Cash</a>
                <a href="#motorcycle-cash">Motorcycle Cash</a>
                <a href="#combined-cash">Combined Cash</a>

                <div class="report-menu-group">Installment Reports</div>
                <a href="#appliance-installment">Appliance Installment</a>
                <a href="#motorcycle-installment">Motorcycle Installment</a>
                <a href="#combined-installment">Combined Installment</a>

                <div class="report-menu-group">Summary Sections</div>
                <a href="#sales-overview">Sales Overview</a>
                <a href="#top-summary">Top Summary</a>
                <a href="#top-branches">Top 5 Branches</a>
                <a href="#branch-performance">Branch Performance</a>
                <a href="#business-unit-totals">Business Unit Totals</a>
                <a href="#latest-sales-transactions">Latest Sales Transactions</a>
                <a href="#branch-transaction-totals">Branch Transaction Totals</a>
                <a href="#charts-branch-business-unit">Branch & BU Charts</a>
                <a href="#charts-monthly">Monthly Charts</a>
                

                @if(auth()->user()->hasAnyRole(['importer', 'admin', 'super_admin']))
                    <a href="#latest-import-batches">Latest Import Batches</a>
                @endif

                @if(auth()->user()->hasAnyRole(['admin', 'super_admin']))
                    <a href="#admin-summary">Admin Summary</a>
                @endif

                @if(auth()->user()->hasAnyRole(['super_admin', 'admin']))
                    <a href="#system-totals">System Totals</a>
                @endif
            </div>
        </div>

        <button id="reportMenuToggle" type="button" class="btn btn-dark">
            Reports
        </button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const branchLabels = @json($branchChartLabels);
        const branchCounts = @json($branchChartCounts);

        const businessUnitLabels = @json($businessUnitChartLabels);
        const businessUnitAmounts = @json($businessUnitChartAmounts);

        const transactionsByMonthLabels = @json($transactionsByMonthLabels);
        const transactionsByMonthCounts = @json($transactionsByMonthCounts);
        const transactionsByMonthAmounts = @json($transactionsByMonthAmounts);

        const branchTransactionsCtx = document.getElementById('branchTransactionsChart');
        if (branchTransactionsCtx) {
            new Chart(branchTransactionsCtx, {
                type: 'bar',
                data: {
                    labels: branchLabels,
                    datasets: [{
                        label: 'Transactions',
                        data: branchCounts,
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        const businessUnitAmountCtx = document.getElementById('businessUnitAmountChart');
        if (businessUnitAmountCtx) {
            new Chart(businessUnitAmountCtx, {
                type: 'pie',
                data: {
                    labels: businessUnitLabels,
                    datasets: [{
                        label: 'Total Amount',
                        data: businessUnitAmounts,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        const transactionsByMonthCtx = document.getElementById('transactionsByMonthChart');
        if (transactionsByMonthCtx) {
            new Chart(transactionsByMonthCtx, {
                type: 'line',
                data: {
                    labels: transactionsByMonthLabels,
                    datasets: [{
                        label: 'Transactions',
                        data: transactionsByMonthCounts,
                        borderWidth: 2,
                        tension: 0.25,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        const amountByMonthCtx = document.getElementById('amountByMonthChart');
        if (amountByMonthCtx) {
            new Chart(amountByMonthCtx, {
                type: 'line',
                data: {
                    labels: transactionsByMonthLabels,
                    datasets: [{
                        label: 'Total Amount',
                        data: transactionsByMonthAmounts,
                        borderWidth: 2,
                        tension: 0.25,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }


            const reportMenuToggle = document.getElementById('reportMenuToggle');
            const reportMenu = document.getElementById('reportMenu');

            if (reportMenuToggle && reportMenu) {
                reportMenuToggle.addEventListener('click', function () {
                    reportMenu.classList.toggle('show');
                });

                document.addEventListener('click', function (event) {
                    const clickedInsideMenu = reportMenu.contains(event.target);
                    const clickedToggle = reportMenuToggle.contains(event.target);

                    if (!clickedInsideMenu && !clickedToggle) {
                        reportMenu.classList.remove('show');
                    }
                });

                reportMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function () {
                        reportMenu.classList.remove('show');
                    });
                });
            }

    </script>
</x-app-layout>