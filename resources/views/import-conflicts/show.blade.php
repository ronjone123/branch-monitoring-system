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

        .btn-summary-outline {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.7rem 1.2rem;
        }

        .btn-summary-outline-sm {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.45rem 0.9rem;
        }

        .action-stack form {
            margin: 0;
        }

        .comparison-changed td {
            background: #fff8e6 !important;
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

            .detail-list {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $mapStatusClass = function ($status) {
            return match (strtolower((string) $status)) {
                'resolved', 'reviewed' => 'success',
                'pending' => 'warning',
                'ignored' => 'secondary',
                default => 'info',
            };
        };

        $changedCount = collect($comparisonRows)->where('changed', true)->count();
        $sameCount = collect($comparisonRows)->where('changed', false)->count();
    @endphp

    <div class="summary-shell page-with-fixed-nav px-3 px-md-4 py-4">
        @if(session('success'))
            <div class="alert alert-success rounded-4 shadow-sm border-0">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Import Conflict Details</div>
                    <div class="mt-2 text-white-50">
                        Review metadata, compare existing and incoming values, and decide how to resolve the conflict.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Conflict Status</div>
                    <div class="summary-date-value">
                        {{ ucfirst($importConflict->status) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div class="text-muted small">
                Conflict <strong>#{{ $importConflict->id }}</strong> from batch
                <strong>#{{ $importConflict->import_batch_id }}</strong>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('import-conflicts.index') }}" class="btn btn-outline-secondary btn-summary-outline">
                    Back to Conflicts
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Changed Fields</div>
                    <div class="summary-stat-value">{{ $changedCount }}</div>
                    <div class="summary-stat-sub">Fields where incoming data differs from the existing record</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Unchanged Fields</div>
                    <div class="summary-stat-value">{{ $sameCount }}</div>
                    <div class="summary-stat-sub">Fields where the incoming and existing values are the same</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Source Row</div>
                    <div class="summary-stat-value">{{ $importConflict->source_row_number ?? '-' }}</div>
                    <div class="summary-stat-sub">Original source row number from the uploaded sheet</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="summary-card h-100">
                    <div class="summary-section-header">
                        <h5>Conflict Metadata</h5>
                        <div class="summary-section-subtitle">
                            Record reference details and available conflict actions.
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="detail-list mb-4">
                            <div class="detail-item">
                                <div class="detail-label">ID</div>
                                <div class="detail-value">#{{ $importConflict->id }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="soft-badge {{ $mapStatusClass($importConflict->status) }}">
                                        {{ ucfirst($importConflict->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Batch</div>
                                <div class="detail-value">#{{ $importConflict->import_batch_id }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Sheet</div>
                                <div class="detail-value">{{ $importConflict->importBatchSheet->sheet_name ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Branch</div>
                                <div class="detail-value">{{ $importConflict->branch->display_name ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Source Row Number</div>
                                <div class="detail-value">{{ $importConflict->source_row_number ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Existing Transaction ID</div>
                                <div class="detail-value">{{ $importConflict->existing_sales_transaction_id ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Created At</div>
                                <div class="detail-value">{{ $importConflict->created_at?->format('M d, Y h:i A') ?? '-' }}</div>
                            </div>

                            <div class="detail-item" style="grid-column: 1 / -1;">
                                <div class="detail-label">Notes</div>
                                <div class="detail-value">{{ $importConflict->notes ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 action-stack">
                            @if($importConflict->status === 'pending')
                                <form action="{{ route('import-conflicts.accept-update', $importConflict) }}" method="POST"
                                      onsubmit="return confirm('Apply incoming row data to the existing sales transaction?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-summary-primary w-100">
                                        Accept Incoming Update
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'reviewed')
                                <form action="{{ route('import-conflicts.mark-reviewed', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-summary-outline w-100">
                                        Mark Reviewed
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'ignored')
                                <form action="{{ route('import-conflicts.mark-ignored', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-secondary btn-summary-outline w-100">
                                        Mark Ignored
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'resolved')
                                <form action="{{ route('import-conflicts.mark-resolved', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-info btn-summary-outline w-100">
                                        Mark Resolved
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('import-conflicts.destroy', $importConflict) }}" method="POST"
                                  onsubmit="return confirm('Delete this conflict permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-summary-outline w-100">
                                    Delete Conflict
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>Field Comparison</h5>
                        <div class="summary-section-subtitle">
                            Compare existing values against the incoming row data and review which fields changed.
                        </div>
                    </div>

                    <div class="card-body border-bottom bg-light px-4 py-3">
                        <strong>Changed Fields: {{ $changedCount }}</strong>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 8%;">Col</th>
                                        <th style="width: 22%;">Field</th>
                                        <th style="width: 30%;">Existing Value</th>
                                        <th style="width: 30%;">Incoming Value</th>
                                        <th style="width: 10%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($comparisonRows as $row)
                                        <tr class="{{ $row['changed'] ? 'comparison-changed' : '' }}">
                                            <td>{{ $row['column'] }}</td>
                                            <td class="fw-semibold">{{ $row['label'] }}</td>
                                            <td>{{ $row['existing'] !== null && $row['existing'] !== '' ? $row['existing'] : '-' }}</td>
                                            <td>{{ $row['incoming'] !== null && $row['incoming'] !== '' ? $row['incoming'] : '-' }}</td>
                                            <td>
                                                @if($row['changed'])
                                                    <span class="soft-badge warning">Changed</span>
                                                @else
                                                    <span class="soft-badge secondary">Same</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-0">
                                                <div class="empty-state">
                                                    <div class="empty-state-title">No comparison data found</div>
                                                    <div>There is no field comparison information available for this conflict.</div>
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
    </div>
</x-app-layout>