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

        .dashboard-chart-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;
        }

        .dashboard-chart-box {
            background: #ffffff;
            border: 2px solid #d9e4f4;
            border-radius: 1rem;
            padding: 1rem;
            min-height: 310px;
            box-shadow: 0 8px 20px rgba(15, 59, 120, 0.04);
        }

        .dashboard-chart-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--summary-blue);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.85rem;
        }

        .dashboard-chart-canvas {
            position: relative;
            height: 245px;
        }

        @media (max-width: 992px) {
            .dashboard-chart-grid {
                grid-template-columns: 1fr;
            }
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
            overflow-wrap: anywhere;
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

        .dashboard-filter-control {
            border-radius: 0.85rem;
            border: 1px solid var(--summary-border);
            min-height: 46px;
            box-shadow: none;
        }

        .dashboard-filter-control:focus {
            border-color: #7aa7e8;
            box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
        }


        .dashboard-control-center {
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border: 1px solid var(--summary-border);
            border-radius: 1rem;
            box-shadow: 0 10px 28px rgba(15, 59, 120, 0.08);
            overflow: hidden;
        }

        .dashboard-control-top {
            background:
                radial-gradient(circle at top left, rgba(255,255,255,0.22), transparent 34%),
                linear-gradient(135deg, var(--summary-blue), var(--summary-blue-dark));
            color: #fff;
            padding: 1.15rem 1.25rem;
        }

        .dashboard-control-title {
            font-size: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin: 0;
        }

        .dashboard-control-subtitle {
            margin: 0.25rem 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.9rem;
        }

        .dashboard-control-body {
            padding: 1.25rem;
        }

        .dashboard-chip-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
            margin-bottom: 1rem;
        }

        .dashboard-filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.42rem 0.75rem;
            border-radius: 999px;
            background: #eef4ff;
            border: 1px solid #c7d6ee;
            color: var(--summary-blue);
            font-size: 0.82rem;
            font-weight: 800;
        }

        .dashboard-filter-chip.muted {
            background: #f8fafc;
            color: #64748b;
            border-color: #e2e8f0;
        }

        .dashboard-preset-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .dashboard-preset-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            border: 1px solid #c7d6ee;
            background: #fff;
            color: var(--summary-blue);
            font-size: 0.82rem;
            font-weight: 800;
            text-decoration: none;
        }

        .dashboard-preset-btn:hover {
            background: #eef4ff;
            color: var(--summary-blue-dark);
            border-color: #9fb9e9;
        }

        .dashboard-empty-state {
            border: 1px dashed #b9c9e4;
            background: #f8fbff;
            border-radius: 1rem;
            padding: 1.25rem;
            color: var(--summary-text);
        }

        .dashboard-empty-state-title {
            font-weight: 800;
            color: var(--summary-blue);
            margin-bottom: 0.35rem;
        }

        .dashboard-empty-state-text {
            color: var(--summary-muted);
            margin: 0;
        }

        .btn-dashboard-primary {
            background: var(--summary-blue);
            border-color: var(--summary-blue);
            color: #fff;
            border-radius: 999px;
            font-weight: 700;
            min-height: 46px;
            padding-inline: 1.1rem;
        }

        .btn-dashboard-primary:hover {
            background: var(--summary-blue-dark);
            border-color: var(--summary-blue-dark);
            color: #fff;
        }

        .btn-dashboard-outline {
            border: 1px solid var(--summary-border);
            background: #fff;
            color: var(--summary-text);
            border-radius: 999px;
            font-weight: 700;
            min-height: 46px;
            padding-inline: 1.1rem;
        }

        .btn-dashboard-outline:hover {
            background: #f4f7fb;
            color: var(--summary-blue);
            border-color: #b9c9e4;
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

        .summary-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

    .summary-highlight-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }

    .executive-card {
        background: #fff;
        border-radius: 1rem;
        border: 2px solid #d9e4f4;
        box-shadow: 0 8px 24px rgba(15, 59, 120, 0.06);
        min-height: 170px;
        overflow: hidden;
    }

    .executive-card-body {
        padding: 1.25rem 1.25rem 1.1rem;
    }

    .executive-card-top {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 0.9rem;
    }

    .executive-icon {
        width: 56px;
        height: 56px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        color: #fff;
        font-weight: 700;
        flex-shrink: 0;
    }

    .executive-title {
        font-size: 0.95rem;
        font-weight: 800;
        text-transform: uppercase;
        line-height: 1.25;
        margin-bottom: 0;
    }

    .executive-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.1;
        color: #111827;
        margin-bottom: 0.35rem;
    }

    .executive-subtext {
        color: #6b7280;
        font-size: 0.92rem;
        font-weight: 500;
    }

    .executive-code {
        color: #6b7280;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
    }

    .executive-small-value {
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1.1;
        color: #111827;
    }

    .card-blue {
        background: #eef5ff;
        border-color: #9ec5ff;
    }
    .card-blue .executive-title {
        color: #114187;
    }
    .card-blue .executive-icon {
        background: #114187;
    }

    .card-green {
        background: #eefaf1;
        border-color: #9fd6ad;
    }
    .card-green .executive-title {
        color: #1d7c39;
    }
    .card-green .executive-icon {
        background: #1d7c39;
    }

    .card-yellow {
        background: #fff8e8;
        border-color: #f0d07f;
    }
    .card-yellow .executive-title {
        color: #b7791f;
    }
    .card-yellow .executive-icon {
        background: #d69e2e;
    }

    .card-purple {
        background: #f5f0ff;
        border-color: #c4b5fd;
    }
    .card-purple .executive-title {
        color: #6d28d9;
    }
    .card-purple .executive-icon {
        background: #6d28d9;
    }

    .card-teal {
        background: #edf9fb;
        border-color: #9bd8e3;
    }
    .card-teal .executive-title {
        color: #0f7890;
    }
    .card-teal .executive-icon {
        background: #0f7890;
    }

    .card-navy {
        background: #eef4ff;
        border-color: #9fb9e9;
    }
    .card-navy .executive-title {
        color: #103f86;
    }
    .card-navy .executive-icon {
        background: #103f86;
    }

    .card-cyan {
        background: #eefbfd;
        border-color: #9edcea;
    }
    .card-cyan .executive-title {
        color: #0b7285;
    }
    .card-cyan .executive-icon {
        background: #0b7285;
    }

    @media (max-width: 1400px) {
        .summary-kpi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .summary-highlight-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 992px) {
        .summary-highlight-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .summary-kpi-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
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

    <div class="summary-shell px-3 px-md-4 py-4" style="padding-top: 5.5rem;">

        {{-- Hero --}}
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

    {{-- Dashboard Filters / Control Center --}}
@php
    $selectedBusinessUnitName = $businessUnits
        ->firstWhere('id', (int) $selectedBusinessUnitId)
        ?->name ?? 'All Business Units';

    $selectedBranchName = $branches
        ->firstWhere('id', (int) $selectedBranchId)
        ?->display_name ?? 'All Branches';

    $hasActiveFilters = $selectedBusinessUnitId || $selectedBranchId || $dateFrom || $dateTo;

    $presetToday = now()->toDateString();
    $presetMonthStart = now()->startOfMonth()->toDateString();
    $presetMonthEnd = now()->endOfMonth()->toDateString();
    $presetLastMonthStart = now()->subMonthNoOverflow()->startOfMonth()->toDateString();
    $presetLastMonthEnd = now()->subMonthNoOverflow()->endOfMonth()->toDateString();
    $presetYearStart = now()->startOfYear()->toDateString();

    $hasDashboardData =
    ((float) $filteredTotalAmount > 0)
    || ((int) $filteredTransactionCount > 0)
    || ((float) $filteredCashAmount > 0)
    || ((int) $filteredBranchCount > 0)
    || $branchPerformanceSummary->count() > 0
    || $businessUnitTotals->count() > 0
    || $latestTransactions->count() > 0;

    $comparisonRangeLabel = null;

    if ($comparisonEnabled && $previousPeriodStart && $previousPeriodEnd) {
        $comparisonRangeLabel =
            \Carbon\Carbon::parse($previousPeriodStart)->format('M d, Y')
            . ' - '
            . \Carbon\Carbon::parse($previousPeriodEnd)->format('M d, Y');
    }

    $trendBadge = function ($current, $previous, $percent) {
        if ((float) $previous === 0.0) {
            return [
                'class' => (float) $current > 0 ? 'good' : 'warn',
                'label' => (float) $current > 0 ? 'New activity' : 'No previous activity',
            ];
        }

        return [
            'class' => $percent >= 0 ? 'good' : 'danger',
            'label' => ($percent >= 0 ? '↑ ' : '↓ ') . number_format(abs($percent), 1) . '%',
        ];
    };

    $amountTrend = $trendBadge($filteredTotalAmount, $previousPeriodAmount, $amountChangePercent);
    $transactionTrend = $trendBadge($filteredTransactionCount, $previousPeriodTransactionCount, $transactionChangePercent);
    $cashTrend = $trendBadge($filteredCashAmount, $previousPeriodCashAmount, $cashAmountChangePercent);
    $branchTrend = $trendBadge($filteredBranchCount, $previousPeriodBranchCount, $branchCountChangePercent);  
@endphp

<div class="dashboard-control-center mb-4">
    <div class="dashboard-control-top d-flex flex-column flex-lg-row justify-content-between gap-3">
        <div>
            <h5 class="dashboard-control-title">Dashboard Control Center</h5>
            <p class="dashboard-control-subtitle">
                Use filters to drive the KPIs, reports, charts, and transaction summaries below.
            </p>
        </div>

        <div class="text-lg-end">
            <div class="small text-white-50 fw-semibold text-uppercase">Current View</div>
            <div class="fw-bold">
                {{ $dateFrom ?: 'Start' }} to {{ $dateTo ?: 'Latest' }}
            </div>
        </div>
    </div>

    <div class="dashboard-control-body">
        <div class="dashboard-chip-row">
            <span class="dashboard-filter-chip">
                Period:
                {{ $dateFrom ?: 'All Start Dates' }}
                —
                {{ $dateTo ?: 'Latest' }}
            </span>

            <span class="dashboard-filter-chip {{ $selectedBusinessUnitId ? '' : 'muted' }}">
                Business Unit: {{ $selectedBusinessUnitName }}
            </span>

            <span class="dashboard-filter-chip {{ $selectedBranchId ? '' : 'muted' }}">
                Branch: {{ $selectedBranchName }}
            </span>

            <span class="dashboard-filter-chip {{ $hasActiveFilters ? '' : 'muted' }}">
                {{ $hasActiveFilters ? 'Filtered View Active' : 'Default Dashboard View' }}
            </span>
        </div>

        <form method="GET" action="{{ route('dashboard') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="business_unit_id" class="form-label fw-semibold">Business Unit</label>
                    <select name="business_unit_id" id="business_unit_id" class="form-select dashboard-filter-control">
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
                    <select name="branch_id" id="branch_id" class="form-select dashboard-filter-control">
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
                    <input type="date" name="date_from" id="date_from" class="form-control dashboard-filter-control" value="{{ $dateFrom }}">
                </div>

                <div class="col-md-2">
                    <label for="date_to" class="form-label fw-semibold">Date To</label>
                    <input type="date" name="date_to" id="date_to" class="form-control dashboard-filter-control" value="{{ $dateTo }}">
                </div>

                <div class="col-md-2">
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-dashboard-primary w-100">Apply</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-dashboard-outline w-100">Reset</a>
                    </div>
                </div>
            </div>
        </form>

        <div class="dashboard-preset-row mt-3">
            <a class="dashboard-preset-btn"
               href="{{ route('dashboard', ['date_from' => $presetToday, 'date_to' => $presetToday, 'business_unit_id' => $selectedBusinessUnitId, 'branch_id' => $selectedBranchId]) }}">
                Today
            </a>

            <a class="dashboard-preset-btn"
               href="{{ route('dashboard', ['date_from' => $presetMonthStart, 'date_to' => $presetMonthEnd, 'business_unit_id' => $selectedBusinessUnitId, 'branch_id' => $selectedBranchId]) }}">
                This Month
            </a>

            <a class="dashboard-preset-btn"
               href="{{ route('dashboard', ['date_from' => $presetLastMonthStart, 'date_to' => $presetLastMonthEnd, 'business_unit_id' => $selectedBusinessUnitId, 'branch_id' => $selectedBranchId]) }}">
                Last Month
            </a>

            <a class="dashboard-preset-btn"
               href="{{ route('dashboard', ['date_from' => $presetYearStart, 'date_to' => $presetToday, 'business_unit_id' => $selectedBusinessUnitId, 'branch_id' => $selectedBranchId]) }}">
                Year to Date
            </a>

            <a class="dashboard-preset-btn" href="{{ route('dashboard') }}">
                All Time
            </a>
        </div>

        @if(! $hasDashboardData)
            <div class="dashboard-empty-state mt-3">
                <div class="dashboard-empty-state-title">
                    No dashboard activity found for this selected view.
                </div>

                <p class="dashboard-empty-state-text">
                    Try selecting <strong>Last Month</strong>, clearing filters, or checking if recent branch files have already been imported.
                    @if($latestAvailableTransactionDate)
                        Latest matching transaction date:
                        <strong>{{ \Carbon\Carbon::parse($latestAvailableTransactionDate)->format('M d, Y') }}</strong>.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

    <div id="charts-overview" class="summary-card mb-4">
        <div class="summary-section-header">
            <div>
                <h5 class="mb-1 dashboard-card-title">Filtered Charts Overview</h5>
                <p class="mb-0">
                    Visual summary of branch activity, business unit amount, and monthly trends based on selected filters.
                </p>
            </div>
        </div>

        <div class="p-3 p-md-4">
            <div class="dashboard-chart-grid">
                <div class="dashboard-chart-box">
                    <div class="dashboard-chart-title">
                        Filtered Transactions by Branch
                    </div>

                    @if(count($branchChartLabels ?? []) > 0)
                        <div class="dashboard-chart-canvas">
                            <canvas id="branchTransactionsChart"></canvas>
                        </div>
                    @else
                        <div class="dashboard-empty-state">
                            <div class="dashboard-empty-state-title">No branch chart data available.</div>
                            <p class="dashboard-empty-state-text">
                                Try changing the date range or clearing the branch/business unit filters.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="dashboard-chart-box">
                    <div class="dashboard-chart-title">
                        Filtered Amount by Business Unit
                    </div>

                    @if(count($businessUnitChartLabels ?? []) > 0)
                        <div class="dashboard-chart-canvas">
                            <canvas id="businessUnitAmountChart"></canvas>
                        </div>
                    @else
                        <div class="dashboard-empty-state">
                            <div class="dashboard-empty-state-title">No business unit chart data available.</div>
                            <p class="dashboard-empty-state-text">
                                Try changing the date range or clearing the branch/business unit filters.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="dashboard-chart-box">
                    <div class="dashboard-chart-title">
                        Monthly Transaction Trend
                    </div>

                    @if(count($transactionsByMonthLabels ?? []) > 0)
                        <div class="dashboard-chart-canvas">
                            <canvas id="transactionsByMonthChart"></canvas>
                        </div>
                    @else
                        <div class="dashboard-empty-state">
                            <div class="dashboard-empty-state-title">No monthly transaction trend available.</div>
                            <p class="dashboard-empty-state-text">
                                Try selecting a wider date range or clearing filters.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="dashboard-chart-box">
                    <div class="dashboard-chart-title">
                        Monthly Amount Trend
                    </div>

                    @if(count($transactionsByMonthLabels ?? []) > 0)
                        <div class="dashboard-chart-canvas">
                            <canvas id="amountByMonthChart"></canvas>
                        </div>
                    @else
                        <div class="dashboard-empty-state">
                            <div class="dashboard-empty-state-title">No monthly amount trend available.</div>
                            <p class="dashboard-empty-state-text">
                                Try selecting a wider date range or clearing filters.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

        {{-- TOP SUMMARY CARDS --}}
    <div id="sales-overview" class="summary-kpi-grid mb-4">
        <div class="executive-card card-blue">
            <div class="executive-card-body">
                <div class="executive-card-top">
                    <div class="executive-icon">₱</div>
                    <div>
                        <div class="executive-title">Filtered Total Amount</div>
                    </div>
                </div>
                <div class="executive-value">{{ number_format((float) $filteredTotalAmount, 2) }}</div>
                <div class="executive-subtext">Total amount based on selected filters</div>
                @if($comparisonEnabled)
                    <div class="mt-2">
                        <span class="summary-chip {{ $amountTrend['class'] }}"
                            title="Previous period: {{ $comparisonRangeLabel }}">
                            {{ $amountTrend['label'] }} vs previous period
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="executive-card card-green">
            <div class="executive-card-body">
                <div class="executive-card-top">
                    <div class="executive-icon">#</div>
                    <div>
                        <div class="executive-title">Filtered Transactions</div>
                    </div>
                </div>
                <div class="executive-value">{{ $filteredTransactionCount }}</div>
                <div class="executive-subtext">Transaction count based on selected filters</div>
                @if($comparisonEnabled)
                    <div class="mt-2">
                        <span class="summary-chip {{ $transactionTrend['class'] }}"
                            title="Previous period: {{ $comparisonRangeLabel }}">
                            {{ $transactionTrend['label'] }} vs previous period
                        </span>
                    </div>
                @endif
                            </div>
        </div>

        <div class="executive-card card-yellow">
            <div class="executive-card-body">
                <div class="executive-card-top">
                    <div class="executive-icon">₱</div>
                    <div>
                        <div class="executive-title">Filtered Cash Amount</div>
                    </div>
                </div>
                <div class="executive-value">{{ number_format((float) $filteredCashAmount, 2) }}</div>
                <div class="executive-subtext">Cash amount based on selected filters</div>
                @if($comparisonEnabled)
                    <div class="mt-2">
                        <span class="summary-chip {{ $cashTrend['class'] }}"
                            title="Previous period: {{ $comparisonRangeLabel }}">
                            {{ $cashTrend['label'] }} vs previous period
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="executive-card card-purple">
            <div class="executive-card-body">
                <div class="executive-card-top">
                    <div class="executive-icon">🏬</div>
                    <div>
                        <div class="executive-title">Branches With Activity</div>
                    </div>
                </div>
                <div class="executive-value">{{ $filteredBranchCount }}</div>
                <div class="executive-subtext">Branches found in the filtered transaction result</div>
                @if($comparisonEnabled)
                    <div class="mt-2">
                        <span class="summary-chip {{ $branchTrend['class'] }}"
                            title="Previous period: {{ $comparisonRangeLabel }}">
                            {{ $branchTrend['label'] }} vs previous period
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="top-summary" class="summary-highlight-grid mb-4">
        <div class="executive-card card-navy">
            <div class="executive-card-body">
                <div class="executive-card-top">
                    <div class="executive-icon">🏆</div>
                    <div>
                        <div class="executive-title">Top Branch in Filtered Result</div>
                    </div>
                </div>

                @if($topFilteredBranch)
                    <div class="executive-value" style="font-size: 1.45rem;">
                        {{ $topFilteredBranch->branch_name }}
                    </div>

                    <div class="executive-code">
                        {{ $topFilteredBranch->branch_code }}
                        · {{ $topFilteredBranch->transaction_count }} transaction(s)
                    </div>

                    <div class="executive-small-value">
                        {{ number_format((float) $topFilteredBranch->filtered_total_amount, 2) }}
                    </div>
                @else
                    <div class="executive-subtext">
                        No branch activity found for the selected filters.
                    </div>
                @endif
            </div>
        </div>

        <div class="executive-card card-teal">
            <div class="executive-card-body">
                <div class="executive-card-top">
                    <div class="executive-icon">🏢</div>
                    <div>
                        <div class="executive-title">Top Business Unit in Filtered Result</div>
                    </div>
                </div>

                @if($topFilteredBusinessUnit)
                    <div class="executive-value" style="font-size: 1.45rem;">
                        {{ $topFilteredBusinessUnit->name }}
                    </div>

                    <div class="executive-code">
                        {{ $topFilteredBusinessUnit->code }}
                        · {{ $topFilteredBusinessUnit->transaction_count }} transaction(s)
                    </div>

                    <div class="executive-small-value">
                        {{ number_format((float) $topFilteredBusinessUnit->filtered_total_amount, 2) }}
                    </div>
                @else
                    <div class="executive-subtext">
                        No business unit activity found for the selected filters.
                    </div>
                @endif
            </div>
        </div>

        <div class="executive-card card-cyan">
            <div class="executive-card-body">
                <div class="executive-card-top">
                    <div class="executive-icon">🏬</div>
                    <div>
                        <div class="executive-title">Branches With Activity</div>
                    </div>
                </div>

                <div class="executive-value">{{ $activeFilteredBranches }}</div>
                <div class="executive-subtext">
                    Branches found in the current filtered transaction result
                </div>
            </div>
        </div>
    </div>

            <div id="product-sales-intelligence" class="summary-card mb-4">
    <div class="summary-section-header">
        <div>
            <h5 class="mb-1 dashboard-card-title">Product & Sales Intelligence</h5>
            <p class="mb-0">
                Brand, product, and term insights based on the selected dashboard filters.
            </p>
        </div>
    </div>

    <div class="p-3 p-md-4">
        <div class="summary-highlight-grid mb-4">
            <div class="executive-card card-navy">
                <div class="executive-card-body">
                    <div class="executive-card-top">
                        <div class="executive-icon">🏷️</div>
                        <div>
                            <div class="executive-title">Top Selling Brand</div>
                        </div>
                    </div>

                    @if($topBrandInsight)
                        <div class="executive-value" style="font-size: 1.45rem;">
                            {{ $topBrandInsight->brand_name }}
                        </div>
                        <div class="executive-code">
                            {{ $topBrandInsight->transaction_count }} transaction(s)
                        </div>
                        <div class="executive-small-value">
                            {{ number_format((float) $topBrandInsight->total_amount, 2) }}
                        </div>
                    @else
                        <div class="executive-subtext">
                            No brand data found for the selected filters.
                        </div>
                    @endif
                </div>
            </div>

            <div class="executive-card card-teal">
                <div class="executive-card-body">
                    <div class="executive-card-top">
                        <div class="executive-icon">🔥</div>
                        <div>
                            <div class="executive-title">Hot Product</div>
                        </div>
                    </div>

                    @if($hotProductInsight)
                        <div class="executive-value" style="font-size: 1.25rem;">
                            {{ $hotProductInsight->product_name }}
                        </div>
                        <div class="executive-code">
                            {{ $hotProductInsight->transaction_count }} transaction(s)
                        </div>
                        <div class="executive-small-value">
                            {{ number_format((float) $hotProductInsight->total_amount, 2) }}
                        </div>
                    @else
                        <div class="executive-subtext">
                            No product data found for the selected filters.
                        </div>
                    @endif
                </div>
            </div>

            <div class="executive-card card-cyan">
                <div class="executive-card-body">
                    <div class="executive-card-top">
                        <div class="executive-icon">%</div>
                        <div>
                            <div class="executive-title">Highest Term Share</div>
                        </div>
                    </div>

                    @if($highestTermInsight)
                        <div class="executive-value" style="font-size: 1.45rem;">
                            {{ $highestTermInsight->terms }}
                        </div>
                        <div class="executive-code">
                            {{ $highestTermInsight->transaction_count }} transaction(s)
                        </div>
                        <div class="executive-small-value">
                            {{ number_format((float) $highestTermInsight->percentage, 2) }}%
                        </div>
                    @else
                        <div class="executive-subtext">
                            No term data found for the selected filters.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th class="count-col">Transactions</th>
                                <th class="amount-col">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topBrands as $brand)
                                <tr>
                                    <td class="fw-semibold">{{ $brand->brand_name }}</td>
                                    <td class="count-col">{{ $brand->transaction_count }}</td>
                                    <td class="amount-col fw-semibold">
                                        {{ number_format((float) $brand->total_amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No brand sales data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th>Product / Model</th>
                                <th class="count-col">Transactions</th>
                                <th class="amount-col">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hotProducts as $product)
                                <tr>
                                    <td class="fw-semibold">{{ $product->product_name }}</td>
                                    <td class="count-col">{{ $product->transaction_count }}</td>
                                    <td class="amount-col fw-semibold">
                                        {{ number_format((float) $product->total_amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No product sales data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th>Product Line</th>
                                <th class="count-col">Transactions</th>
                                <th class="amount-col">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProductLines as $line)
                                <tr>
                                    <td class="fw-semibold">{{ $line->product_line }}</td>
                                    <td class="count-col">{{ $line->transaction_count }}</td>
                                    <td class="amount-col fw-semibold">
                                        {{ number_format((float) $line->total_amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No product line data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th class="count-col">Transactions</th>
                                <th class="amount-col">Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topTerms as $term)
                                <tr>
                                    <td class="fw-semibold">{{ $term->terms }}</td>
                                    <td class="count-col">{{ $term->transaction_count }}</td>
                                    <td class="amount-col fw-semibold">
                                        {{ number_format((float) $term->percentage, 2) }}%
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No term data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
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
        <div id="customer-intelligence" class="summary-card mb-4">
            <div class="summary-section-header">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Customer Intelligence</h5>
                    <p class="mb-0">
                        Repeat buyers and highest PN customers based on real paid sales only.
                    </p>
                </div>
            </div>

            <div class="p-3 p-md-4">
                <div class="summary-highlight-grid mb-4">
                    <div class="executive-card card-navy">
                        <div class="executive-card-body">
                            <div class="executive-card-top">
                                <div class="executive-icon">👤</div>
                                <div>
                                    <div class="executive-title">Top Repeat Buyer</div>
                                </div>
                            </div>

                            @if($topRepeatCustomerInsight)
                                <div class="executive-value" style="font-size: 1.25rem;">
                                    <a href="{{ route('sales-transactions.show', $topRepeatCustomerInsight->latest_sales_transaction_id) }}"
                                    class="text-decoration-none text-dark">
                                        {{ $topRepeatCustomerInsight->customer_name }}
                                    </a>
                                </div>

                                <div class="executive-code">
                                    {{ $topRepeatCustomerInsight->account_count }} account(s)
                                    · {{ $topRepeatCustomerInsight->transaction_count }} transaction(s)
                                </div>

                                <div class="executive-small-value">
                                    {{ number_format((float) $topRepeatCustomerInsight->total_sales_amount, 2) }}
                                </div>
                            @else
                                <div class="executive-subtext">
                                    No repeat buyer found for the selected filters.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="executive-card card-teal">
                        <div class="executive-card-body">
                            <div class="executive-card-top">
                                <div class="executive-icon">₱</div>
                                <div>
                                    <div class="executive-title">Highest PN Customer</div>
                                </div>
                            </div>

                            @if($topPnCustomerInsight)
                                <div class="executive-value" style="font-size: 1.25rem;">
                                    <a href="{{ route('sales-transactions.show', $topPnCustomerInsight->sales_transaction_id) }}"
                                    class="text-decoration-none text-dark">
                                        {{ $topPnCustomerInsight->customer_name }}
                                    </a>
                                </div>

                                <div class="executive-code">
                                    {{ $topPnCustomerInsight->account_number ?? '-' }}
                                    · {{ $topPnCustomerInsight->receipt_number ?? '-' }}
                                </div>

                                <div class="executive-small-value">
                                    {{ number_format((float) $topPnCustomerInsight->total_pn_amount, 2) }}
                                </div>
                            @else
                                <div class="executive-subtext">
                                    No PN customer data found for the selected filters.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="executive-card card-cyan">
                        <div class="executive-card-body">
                            <div class="executive-card-top">
                                <div class="executive-icon">↻</div>
                                <div>
                                    <div class="executive-title">Repeat Buyer Count</div>
                                </div>
                            </div>

                            <div class="executive-value">{{ $topRepeatCustomers->count() }}</div>
                            <div class="executive-subtext">
                                Customers with more than one paid purchase in the selected filters
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Repeat Buyer</th>
                                        <th class="count-col">Accounts</th>
                                        <th class="count-col">Transactions</th>
                                        <th class="amount-col">Total Sales</th>
                                        <th>Latest Purchase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topRepeatCustomers as $customer)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">
                                                    <a href="{{ route('sales-transactions.show', $customer->latest_sales_transaction_id) }}"
                                                    class="text-decoration-none">
                                                        {{ $customer->customer_name }}
                                                    </a>
                                                </div>
                                                <div class="small text-muted">{{ $customer->contact_number ?? '-' }}</div>
                                            </td>

                                            <td class="count-col">{{ $customer->account_count }}</td>
                                            <td class="count-col">{{ $customer->transaction_count }}</td>

                                            <td class="amount-col fw-semibold">
                                                {{ number_format((float) $customer->total_sales_amount, 2) }}
                                            </td>

                                            <td>
                                                {{ $customer->latest_purchase_date ? \Carbon\Carbon::parse($customer->latest_purchase_date)->format('M d, Y') : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-3">
                                                <div class="dashboard-empty-state text-center">
                                                    <div class="dashboard-empty-state-title">
                                                        No repeat buyer data found.
                                                    </div>
                                                    <p class="dashboard-empty-state-text">
                                                        Try selecting a wider date range or clearing filters.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Highest PN Customer</th>
                                        <th>Account</th>
                                        <th>Product</th>
                                        <th class="amount-col">Total PN</th>
                                        <th>Latest Purchase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topPnCustomers as $customer)
                                        <tr>
                                            <td class="fw-semibold">
                                                <a href="{{ route('sales-transactions.show', $customer->sales_transaction_id) }}"
                                                class="text-decoration-none">
                                                    {{ $customer->customer_name }}
                                                </a>
                                            </td>

                                            <td>{{ $customer->account_number ?? '-' }}</td>

                                            <td>
                                                {{ $customer->brand_name ?? '-' }}
                                                {{ $customer->model ? '· ' . $customer->model : '' }}
                                            </td>

                                            <td class="amount-col fw-semibold">
                                                {{ number_format((float) $customer->total_pn_amount, 2) }}
                                            </td>

                                            <td>
                                                {{ $customer->latest_purchase_date ? \Carbon\Carbon::parse($customer->latest_purchase_date)->format('M d, Y') : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-3">
                                                <div class="dashboard-empty-state text-center">
                                                    <div class="dashboard-empty-state-title">
                                                        No PN ranking data found.
                                                    </div>
                                                    <p class="dashboard-empty-state-text">
                                                        Try changing the date range, branch, or business unit filter.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Latest Repeat Buyer Activity</th>
                                        <th class="count-col">Accounts</th>
                                        <th class="count-col">Transactions</th>
                                        <th>Latest Purchase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestRepeatCustomers as $customer)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">
                                                    <a href="{{ route('sales-transactions.show', $customer->latest_sales_transaction_id) }}"
                                                    class="text-decoration-none">
                                                        {{ $customer->customer_name }}
                                                    </a>
                                                </div>
                                                <div class="small text-muted">{{ $customer->contact_number ?? '-' }}</div>
                                            </td>

                                            <td class="count-col">{{ $customer->account_count }}</td>
                                            <td class="count-col">{{ $customer->transaction_count }}</td>

                                            <td>
                                                {{ $customer->latest_purchase_date ? \Carbon\Carbon::parse($customer->latest_purchase_date)->format('M d, Y') : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-3">
                                                <div class="dashboard-empty-state text-center">
                                                    <div class="dashboard-empty-state-title">
                                                        No latest repeat buyer activity found.
                                                    </div>
                                                    <p class="dashboard-empty-state-text">
                                                        Try selecting a wider date range or clearing filters.
                                                    </p>
                                                </div>
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

            <div id="appliance-cash" class="summary-card mb-4">
                <div class="summary-section-header">
                    <div>
                        <h5 class="mb-1 dashboard-card-title">Appliance Cash Transactions</h5>
                        <p class="mb-0">
                            Lucky 4 Appliances cash sales summary by branch.
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
                                        <td colspan="11" class="p-3">
                                            <div class="dashboard-empty-state text-center">
                                                <div class="dashboard-empty-state-title">
                                                    No appliance cash transaction data found.
                                                </div>
                                                <p class="dashboard-empty-state-text">
                                                    Try changing the date range, branch, or business unit filter.
                                                </p>
                                            </div>
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
                            <p class="mb-0">
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
                                            <td colspan="11" class="p-3">
                                                <div class="dashboard-empty-state text-center">
                                                    <div class="dashboard-empty-state-title">
                                                        No motorcycle cash transaction data found.
                                                    </div>
                                                    <p class="dashboard-empty-state-text">
                                                        Try changing the date range, branch, or business unit filter.
                                                    </p>
                                                </div>
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
                            <p class="mb-0">
                                Lucky 4 and Motor 8 motorcycle combined with appliances cash sales summary by branch.
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
                                            <td colspan="11" class="p-3">
                                                <div class="dashboard-empty-state text-center">
                                                    <div class="dashboard-empty-state-title">
                                                        No combined cash transaction data found.
                                                    </div>
                                                    <p class="dashboard-empty-state-text">
                                                        Try changing the date range, branch, or business unit filter.
                                                    </p>
                                                </div>
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
                    <p class="mb-0">
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
                                    <td colspan="11" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No appliance installment sales transaction data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
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
                    <p class="mb-0">
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
                                    <td colspan="11" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No motorcycle installment transaction data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
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
                    <p class="mb-0">
                        Lucky 4 and Motor 8 combined installment sales summary by branch.
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
                                    <td colspan="11" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No combined installment sales transaction data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
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

        <div id="branch-performance" class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <div>
                        <h5 class="mb-1 dashboard-card-title">Branch Performance Summary</h5>
                        <p class="text-muted small mb-0">
                            Current-day and period sales performance by branch under the selected filters.
                        </p>
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
                                    <td colspan="6" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No sales performance transaction data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
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
                                    <td colspan="5" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No business unit totals data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
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
                                            <td colspan="4" class="p-3">
                                                <div class="dashboard-empty-state text-center">
                                                    <div class="dashboard-empty-state-title">
                                                        No latest sales transaction data found.
                                                    </div>
                                                    <p class="dashboard-empty-state-text">
                                                        Try changing the date range, branch, or business unit filter.
                                                    </p>
                                                </div>
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
                                    <td colspan="3" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No branch transaction total data found.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                                        <td colspan="4" class="p-3">
                                            <div class="dashboard-empty-state text-center">
                                                <div class="dashboard-empty-state-title">
                                                    No latest import batches data found.
                                                </div>
                                                <p class="dashboard-empty-state-text">
                                                    No import batches have been uploaded yet.
                                                </p>
                                            </div>
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
                            <div class="text-muted small mb-2">Business Units</div>
                            <div class="fs-2 fw-bold">{{ $businessUnits->count() }}</div>
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
               <a href="#charts-overview">Charts Overview</a>
                <a href="#sales-overview">Sales Overview</a>
                <a href="#top-summary">Top Summary</a>
                <a href="#product-sales-intelligence">Product & Sales Intelligence</a>
                <a href="#customer-intelligence">Customer Intelligence</a>
                <a href="#branch-performance">Branch Performance</a>
                <a href="#business-unit-totals">Business Unit Totals</a>
                <a href="#latest-sales-transactions">Latest Sales Transactions</a>
                <a href="#branch-transaction-totals">Branch Transaction Totals</a>
                

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

            const defaultChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
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
            };

            const pieChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            };

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
                    options: defaultChartOptions
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
                    options: pieChartOptions
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
                    options: defaultChartOptions
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
                    options: defaultChartOptions
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