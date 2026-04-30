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

            --summary-secondary-bg: #eef2f7;
            --summary-secondary-text: #475467;

            --summary-info-bg: #eaf4ff;
            --summary-info-text: #175cd3;
        }

        body {
            background: var(--summary-bg);
        }

        .summary-shell {
            max-width: 1400px;
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
            min-width: 220px;
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
            font-size: 1.2rem;
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

        .soft-badge.danger {
            background: var(--summary-danger-bg);
            color: var(--summary-danger-text);
        }

        .soft-badge.secondary {
            background: var(--summary-secondary-bg);
            color: var(--summary-secondary-text);
        }

        .soft-badge.info {
            background: var(--summary-info-bg);
            color: var(--summary-info-text);
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

        .product-lines-box {
            border: 1px solid var(--summary-border);
            border-radius: 0.9rem;
            background: #fbfdff;
            padding: 1rem;
        }

        .product-line-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.42rem 0.75rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            background: var(--summary-info-bg);
            color: var(--summary-info-text);
            margin: 0 0.45rem 0.45rem 0;
        }

        .helper-box {
            background: var(--summary-info-bg);
            color: var(--summary-info-text);
            border: 1px solid #cfe1ff;
            border-radius: 0.9rem;
            padding: 1rem 1.1rem;
        }

        .helper-box-title {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-bottom: 0.45rem;
        }

        .helper-box ul {
            margin: 0;
            padding-left: 1.1rem;
        }

        .helper-box li {
            margin-bottom: 0.3rem;
        }

        @media (max-width: 991.98px) {
            .summary-hero-title {
                font-size: 1.6rem;
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
                    <div class="summary-hero-title">Branch Details</div>
                    <div class="mt-2 text-white-50">
                        Review branch information, mapping details, product lines, and operational status.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Branch Code</div>
                    <div class="summary-date-value">{{ $branch->code }}</div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('branches.edit', $branch) }}" class="btn btn-summary-primary">
                    Edit Branch
                </a>
                <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary btn-summary-outline">
                    Back to List
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Current Status</div>
                    <div class="summary-stat-value">
                        {{ ucfirst($branch->status) }}
                    </div>
                    <div class="summary-stat-sub">Current operational branch status</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Business Unit</div>
                    <div class="summary-stat-value">
                        {{ $branch->businessUnit->code ?? '-' }}
                    </div>
                    <div class="summary-stat-sub">
                        {{ $branch->businessUnit->name ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Location</div>
                    <div class="summary-stat-value">
                        {{ $branch->location->code ?? '-' }}
                    </div>
                    <div class="summary-stat-sub">
                        {{ $branch->location->name ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="summary-card mb-4">
                    <div class="summary-section-header">
                        <h5>Branch Information</h5>
                        <div class="summary-section-subtitle">
                            Core branch identity, assignments, and spreadsheet mapping details.
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="detail-list">
                            <div class="detail-item">
                                <div class="detail-label">Code</div>
                                <div class="detail-value">{{ $branch->code }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Display Name</div>
                                <div class="detail-value">{{ $branch->display_name }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Business Unit</div>
                                <div class="detail-value">
                                    {{ $branch->businessUnit->name ?? '-' }}
                                    @if($branch->businessUnit?->code)
                                        ({{ $branch->businessUnit->code }})
                                    @endif
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Location</div>
                                <div class="detail-value">
                                    {{ $branch->location->name ?? '-' }}
                                    @if($branch->location?->code)
                                        ({{ $branch->location->code }})
                                    @endif
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Area / Barangay</div>
                                <div class="detail-value">{{ $branch->area_barangay ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Spreadsheet Sheet Name</div>
                                <div class="detail-value">{{ $branch->spreadsheet_sheet_name ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="soft-badge
                                        @if($branch->status === 'active') success
                                        @elseif($branch->status === 'inactive') warning
                                        @else danger
                                        @endif">
                                        {{ ucfirst($branch->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Opened Date</div>
                                <div class="detail-value">{{ optional($branch->opened_at)->format('Y-m-d') ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Closed Date</div>
                                <div class="detail-value">{{ optional($branch->closed_at)->format('Y-m-d') ?? '-' }}</div>
                            </div>

                            <div class="detail-item" style="grid-column: 1 / -1;">
                                <div class="detail-label">Remarks</div>
                                <div class="detail-value">{{ $branch->remarks ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>Allowed Product Lines</h5>
                        <div class="summary-section-subtitle">
                            Product lines currently assigned to this branch.
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="product-lines-box">
                            @forelse($branch->productLines as $productLine)
                                <span class="product-line-chip">
                                    {{ $productLine->name }} ({{ $productLine->code }})
                                </span>
                            @empty
                                <span class="text-muted">No allowed product lines assigned.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="helper-box mb-4">
                    <div class="helper-box-title">Branch Notes</div>
                    <ul>
                        <li>Branch setup affects imports, dashboard filters, and summary reporting.</li>
                        <li>Spreadsheet sheet name should match source naming where imports depend on it.</li>
                        <li>Status changes may affect operational monitoring scope.</li>
                    </ul>
                </div>

                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>Reference Summary</h5>
                        <div class="summary-section-subtitle">
                            Quick review of linked organizational details.
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="detail-list">
                            <div class="detail-item">
                                <div class="detail-label">Business Unit Code</div>
                                <div class="detail-value">{{ $branch->businessUnit->code ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Location Code</div>
                                <div class="detail-value">{{ $branch->location->code ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Total Product Lines</div>
                                <div class="detail-value">{{ $branch->productLines->count() }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">{{ ucfirst($branch->status) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>