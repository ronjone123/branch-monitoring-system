<x-app-layout>
    <style>
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

        .dashboard-table .code-col,
        .dashboard-table .status-col,
        .dashboard-table .id-col {
            white-space: nowrap;
        }

        .truncate-cell {
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dashboard-card-title {
            font-weight: 600;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body bg-dark text-dark p-4">
                    <h2 class="h3 mb-1 fw-bold">Dashboard</h2>
                    <p class="mb-0 text-white-50">Business summary, branch performance, and sales activity.</p>
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

            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div>
                        <h5 class="mb-1 dashboard-card-title">Appliance Cash Transactions</h5>
                        <p class="text-muted small mb-0">
                            Lucky 4 appliance cash sales summary by branch.
                        </p>
                    </div>
                </div>

                <div class="card-body pt-0 px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 dashboard-table">
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
                                        <td>
                                            <div class="fw-semibold">{{ $row->branch_name }}</div>
                                            <div class="small text-muted">{{ $row->branch_code }}</div>
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
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <div>
                            <h5 class="mb-1 dashboard-card-title">Motorcycle Cash Transactions</h5>
                            <p class="text-muted small mb-0">
                                Lucky 4 and Motor 8 motorcycle cash sales summary by branch.
                            </p>
                        </div>
                    </div>

                    <div class="card-body pt-0 px-4 pb-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 dashboard-table">
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
                                            <td>
                                                <div class="fw-semibold">{{ $row->branch_name }}</div>
                                                <div class="small text-muted">{{ $row->branch_code }}</div>
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
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <div>
                            <h5 class="mb-1 dashboard-card-title">Combined Motorcycle and Appliances Cash Transactions</h5>
                            <p class="text-muted small mb-0">
                                Lucky 4 and Motor 8 combined cash sales summary by branch.
                            </p>
                        </div>
                    </div>

                    <div class="card-body pt-0 px-4 pb-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 dashboard-table">
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
                                            <td>
                                                <div class="fw-semibold">{{ $row->branch_name }}</div>
                                                <div class="small text-muted">{{ $row->branch_code }}</div>
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

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Appliance Installment Transactions</h5>
                    <p class="text-muted small mb-0">
                        Lucky 4 appliance installment sales summary by branch.
                    </p>
                </div>
            </div>

            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 dashboard-table">
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
                                    <td>
                                        <div class="fw-semibold">{{ $row->branch_name }}</div>
                                        <div class="small text-muted">{{ $row->branch_code }}</div>
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

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Motorcycle Installment Transactions</h5>
                    <p class="text-muted small mb-0">
                        Lucky 4 and Motor 8 motorcycle installment sales summary by branch.
                    </p>
                </div>
            </div>

            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 dashboard-table">
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
                                    <td>
                                        <div class="fw-semibold">{{ $row->branch_name }}</div>
                                        <div class="small text-muted">{{ $row->branch_code }}</div>
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

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Combined Motorcycle and Appliances Installment Transactions</h5>
                    <p class="text-muted small mb-0">
                        Lucky 4 and Motor 8 combined installment summary by branch.
                    </p>
                </div>
            </div>

            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 dashboard-table">
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
                                    <td>
                                        <div class="fw-semibold">{{ $row->branch_name }}</div>
                                        <div class="small text-muted">{{ $row->branch_code }}</div>
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

        <div class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Sales Today</div>
                        <div class="fs-2 fw-bold">{{ number_format((float) $todayAmount, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Transactions Today</div>
                        <div class="fs-2 fw-bold">{{ $todayTransactionCount }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Month-to-Date Sales</div>
                        <div class="fs-2 fw-bold">{{ number_format((float) $monthToDateAmount, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="text-muted small mb-2">Month-to-Date Transactions</div>
                        <div class="fs-2 fw-bold">{{ $monthToDateTransactionCount }}</div>
                    </div>
                </div>
            </div>
        </div>
                <div class="row g-4 mb-4">
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
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Top 5 Branches This Month</h5>
                    <p class="text-muted small mb-0">Highest-performing branches based on month-to-date sales.</p>
                </div>
            </div>

            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 dashboard-table">
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

        <div class="card shadow-sm border-0 rounded-4 mb-4">
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
                    <table class="table table-hover align-middle mb-0 dashboard-table">
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

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 dashboard-card-title">Business Unit Totals</h5>
            </div>
            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 dashboard-table">
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

        <div class="row g-4 mb-4">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="mb-0 dashboard-card-title">Latest Sales Transactions</h5>
                    </div>
                    <div class="card-body pt-0 px-4 pb-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 dashboard-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Branch</th>
                                        <th class="amount-col">Amount</th>
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
                                                {{ $transaction->amount !== null ? number_format((float) $transaction->amount, 2) : '-' }}
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

        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 dashboard-card-title">Branch Transaction Totals</h5>
            </div>
            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 dashboard-table">
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

        <div class="row g-4 mb-4">
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

        <div class="row g-4 mb-4">
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
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="mb-0 dashboard-card-title">Latest Import Batches</h5>
                </div>
                <div class="card-body pt-0 px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 dashboard-table">
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
            <div class="row g-4 mb-4">
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
            <div class="row g-4 mb-4">
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
    </script>
</x-app-layout>