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

        .btn-summary-outline-sm {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.4rem 0.85rem;
        }

        .bu-name {
            font-weight: 700;
            color: var(--summary-text);
        }

        .bu-code {
            color: var(--summary-muted);
            font-size: 0.82rem;
        }

        .truncate-cell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .action-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            flex-wrap: wrap;
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
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 px-4 py-3 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Business Units</div>
                    <div class="mt-2 text-white-50">
                        Manage business unit master records, codes, descriptions, and operational status.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Date</div>
                    <div class="summary-date-value">{{ now()->format('F d, Y') }}</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('business-units.create') }}" class="btn btn-summary-primary">
                Add Business Unit
            </a>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Total Business Units</div>
                    <div class="summary-stat-value">{{ $businessUnits->total() }}</div>
                    <div class="summary-stat-sub">All business unit records currently listed in the system</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Current Page</div>
                    <div class="summary-stat-value">{{ $businessUnits->currentPage() }}</div>
                    <div class="summary-stat-sub">Current pagination page being viewed</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Showing Records</div>
                    <div class="summary-stat-value">{{ $businessUnits->count() }}</div>
                    <div class="summary-stat-sub">Number of business units shown on this page</div>
                </div>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-section-header">
                <h5>Business Unit List</h5>
                <div class="summary-section-subtitle">
                    Review business unit codes, names, descriptions, and current status.
                </div>
            </div>

            <div class="summary-toolbar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="text-muted small">
                    Showing <strong>{{ $businessUnits->count() }}</strong> record(s) on this page out of
                    <strong>{{ $businessUnits->total() }}</strong> total
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($businessUnits as $businessUnit)
                                <tr>
                                    <td>
                                        <span class="soft-badge secondary">{{ $businessUnit->code }}</span>
                                    </td>

                                    <td>
                                        <div class="bu-name">{{ $businessUnit->name }}</div>
                                    </td>

                                    <td class="truncate-cell" title="{{ $businessUnit->description ?? '-' }}">
                                        {{ $businessUnit->description ?? '-' }}
                                    </td>

                                    <td>
                                        <span class="soft-badge {{ $businessUnit->status === 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($businessUnit->status) }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <div class="action-group">
                                            <a href="{{ route('business-units.show', $businessUnit) }}"
                                               class="btn btn-sm btn-outline-secondary btn-summary-outline-sm">
                                                View
                                            </a>
                                            <a href="{{ route('business-units.edit', $businessUnit) }}"
                                               class="btn btn-sm btn-outline-primary btn-summary-outline-sm">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-0">
                                        <div class="empty-state">
                                            <div class="empty-state-title">No business units found</div>
                                            <div>No business unit master records are available yet.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($businessUnits->hasPages())
                <div class="card-footer bg-white border-0 px-4 py-3">
                    {{ $businessUnits->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>