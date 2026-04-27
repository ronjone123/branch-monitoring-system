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

        .truncate-cell {
            max-width: 280px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

    @php
        $selectedStatus = request('status', 'pending');

        $mapStatusClass = function ($status) {
            return match (strtolower((string) $status)) {
                'resolved', 'reviewed' => 'success',
                'pending' => 'warning',
                'ignored' => 'secondary',
                default => 'info',
            };
        };

        $pendingCount = $conflicts->getCollection()->where('status', 'pending')->count();
        $reviewedCount = $conflicts->getCollection()->where('status', 'reviewed')->count();
        $resolvedCount = $conflicts->getCollection()->where('status', 'resolved')->count();
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
                    <div class="summary-hero-title">Import Conflicts</div>
                    <div class="mt-2 text-white-50">
                        Review changed sales rows detected during import and track their resolution status.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Date</div>
                    <div class="summary-date-value">{{ now()->format('F d, Y') }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Total Conflicts</div>
                    <div class="summary-stat-value">{{ $conflicts->total() }}</div>
                    <div class="summary-stat-sub">Total conflict records returned by the current query</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Pending in Page</div>
                    <div class="summary-stat-value">{{ $pendingCount }}</div>
                    <div class="summary-stat-sub">Conflicts waiting for review in the current list</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Reviewed in Page</div>
                    <div class="summary-stat-value">{{ $reviewedCount }}</div>
                    <div class="summary-stat-sub">Conflicts already reviewed in this result set</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Resolved in Page</div>
                    <div class="summary-stat-value">{{ $resolvedCount }}</div>
                    <div class="summary-stat-sub">Conflicts marked resolved in the current page</div>
                </div>
            </div>
        </div>

        <div class="summary-card mb-4">
            <div class="summary-section-header">
                <h5>Conflict Filters</h5>
                <div class="summary-section-subtitle">
                    Narrow the list by batch, branch, and review status.
                </div>
            </div>

            <div class="p-4">
                <form method="GET" action="{{ route('import-conflicts.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="import_batch_id" class="form-label">Import Batch</label>
                            <select name="import_batch_id" id="import_batch_id" class="form-select">
                                <option value="">All Batches</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ request('import_batch_id') == $batch->id ? 'selected' : '' }}>
                                        #{{ $batch->id }} - {{ $batch->original_filename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="all" {{ $selectedStatus === 'all' ? 'selected' : '' }}>
                                    All Statuses
                                </option>

                                @foreach(['pending', 'reviewed', 'ignored', 'resolved'] as $status)
                                    <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-summary-primary">Apply Filters</button>
                            <a href="{{ route('import-conflicts.index') }}" class="btn btn-outline-secondary btn-summary-outline">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-section-header">
                <h5>Conflict Records</h5>
                <div class="summary-section-subtitle">
                    Review each detected conflict and open the record for deeper inspection.
                </div>
            </div>

            <div class="summary-toolbar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="text-muted small">
                    Showing <strong>{{ $conflicts->count() }}</strong> record(s) on this page out of
                    <strong>{{ $conflicts->total() }}</strong> total conflicts
                </div>

                <div class="text-muted small">
                    Current status filter:
                    <strong>{{ $selectedStatus === 'all' ? 'All Statuses' : ucfirst($selectedStatus) }}</strong>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 90px;">ID</th>
                                <th style="width: 100px;">Batch</th>
                                <th>Sheet</th>
                                <th style="width: 180px;">Branch</th>
                                <th style="width: 110px;">Source Row</th>
                                <th style="width: 140px;">Status</th>
                                <th>Notes</th>
                                <th class="text-end" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($conflicts as $conflict)
                                <tr>
                                    <td class="fw-bold">#{{ $conflict->id }}</td>
                                    <td>#{{ $conflict->import_batch_id }}</td>
                                    <td>{{ $conflict->importBatchSheet->sheet_name ?? '-' }}</td>
                                    <td>{{ $conflict->branch->display_name ?? '-' }}</td>
                                    <td>{{ $conflict->source_row_number ?? '-' }}</td>
                                    <td>
                                        <span class="soft-badge {{ $mapStatusClass($conflict->status) }}">
                                            {{ ucfirst($conflict->status) }}
                                        </span>
                                    </td>
                                    <td class="truncate-cell" title="{{ $conflict->notes ?? '-' }}">
                                        {{ $conflict->notes ?? '-' }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('import-conflicts.show', $conflict) }}"
                                           class="btn btn-sm btn-outline-primary btn-summary-outline-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-0">
                                        <div class="empty-state">
                                            <div class="empty-state-title">No import conflicts found</div>
                                            <div>No conflict records matched the current filters.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($conflicts->hasPages())
                <div class="card-footer bg-white border-0 px-4 py-3">
                    {{ $conflicts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>