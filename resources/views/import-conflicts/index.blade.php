<x-app-layout>
    <style>
        body {
            background: #f4f7fb;
        }

        .import-conflicts-page {
            max-width: 1600px;
            margin: 0 auto;
            padding-top: 6.5rem;
            color: #0f172a;
        }

        .import-conflicts-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
        }

        .import-conflicts-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 900;
            line-height: 1.15;
        }

        .import-conflicts-subtitle {
            margin: .4rem 0 0;
            color: #64748b;
            font-size: .92rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .import-conflicts-actions,
        .import-conflicts-filter-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: .55rem;
        }

        .import-conflicts-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            border-radius: 999px;
            padding: .55rem .95rem;
            font-size: .8rem;
            font-weight: 900;
            line-height: 1;
            text-decoration: none;
            white-space: nowrap;
            transition: background .15s ease, border-color .15s ease, color .15s ease, box-shadow .15s ease, transform .15s ease;
        }

        .import-conflicts-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .import-conflicts-btn-primary:hover,
        .import-conflicts-btn-primary:focus {
            color: #ffffff;
            background: #1d4ed8;
            border-color: #1d4ed8;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .import-conflicts-btn-secondary {
            color: #334155;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.14);
        }

        .import-conflicts-btn-secondary:hover,
        .import-conflicts-btn-secondary:focus {
            color: #0f172a;
            background: #f8fafc;
            border-color: rgba(15, 23, 42, 0.22);
            text-decoration: none;
        }

        .import-conflicts-alert {
            background: #ecfdf5;
            border: 1px solid rgba(34, 197, 94, 0.22);
            color: #166534;
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            padding: .85rem 1rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .import-conflicts-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: .9rem;
            margin-bottom: 1.15rem;
        }

        .import-conflicts-summary-card,
        .import-conflicts-filter-card,
        .import-conflicts-table-card,
        .import-conflicts-helper-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .import-conflicts-summary-card {
            padding: 1rem;
            min-width: 0;
        }

        .import-conflicts-summary-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .import-conflicts-summary-value {
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 900;
            line-height: 1.1;
            margin-top: .45rem;
        }

        .import-conflicts-summary-meta {
            color: #64748b;
            font-size: .8rem;
            font-weight: 600;
            line-height: 1.4;
            margin-top: .35rem;
        }

        .import-conflicts-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .8rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .import-conflicts-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
        }

        .import-conflicts-card-subtitle {
            margin: .25rem 0 0;
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .import-conflicts-card-body {
            padding: 1.1rem;
        }

        .import-conflicts-filter-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .85rem;
            align-items: end;
        }

        .import-conflicts-field label {
            display: block;
            color: #334155;
            font-size: .76rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .45rem;
        }

        .import-conflicts-field select {
            width: 100%;
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: .85rem;
            background: #ffffff;
            color: #0f172a;
            font-size: .86rem;
            font-weight: 700;
            padding: .72rem .85rem;
            box-shadow: none;
        }

        .import-conflicts-field select:focus {
            border-color: rgba(37, 99, 235, 0.45);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, 0.08);
            outline: 0;
        }

        .import-conflicts-helper-card {
            margin: 1rem 0;
            padding: .95rem 1rem;
            background: #f8fafc;
        }

        .import-conflicts-helper-title {
            color: #0f172a;
            font-size: .9rem;
            font-weight: 900;
            margin-bottom: .25rem;
        }

        .import-conflicts-helper-text {
            color: #64748b;
            font-size: .84rem;
            font-weight: 650;
            line-height: 1.45;
            margin: 0;
        }

        .import-conflicts-toolbar {
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

        .import-conflicts-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .import-conflicts-table {
            width: 100%;
            min-width: 1160px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .import-conflicts-table thead th {
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

        .import-conflicts-table tbody td {
            padding: .88rem .78rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: .84rem;
            vertical-align: middle;
        }

        .import-conflicts-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .import-conflicts-table tbody tr:hover td {
            background: #f3f4f6;
        }

        .import-conflict-id {
            color: #0f172a;
            font-weight: 900;
            white-space: nowrap;
        }

        .import-conflict-muted {
            color: #64748b;
            font-size: .78rem;
            font-weight: 700;
        }

        .import-conflict-notes {
            max-width: 280px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .import-conflict-badge {
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

        .import-conflict-badge-success {
            color: #166534;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.22);
        }

        .import-conflict-badge-info {
            color: #1d4ed8;
            background: rgba(37, 99, 235, 0.10);
            border: 1px solid rgba(37, 99, 235, 0.20);
        }

        .import-conflict-badge-warning {
            color: #92400e;
            background: rgba(245, 158, 11, 0.14);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .import-conflict-badge-danger {
            color: #991b1b;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.22);
        }

        .import-conflict-badge-secondary {
            color: #475569;
            background: rgba(100, 116, 139, 0.10);
            border: 1px solid rgba(100, 116, 139, 0.18);
        }

        .import-conflicts-empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            color: #64748b;
        }

        .import-conflicts-empty-title {
            color: #0f172a;
            font-size: 1.05rem;
            font-weight: 900;
            margin-bottom: .35rem;
        }

        .import-conflicts-pagination {
            padding: 1rem 1.1rem;
            background: #ffffff;
        }

        @media (max-width: 1199.98px) {
            .import-conflicts-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .import-conflicts-page {
                padding-top: 5.75rem;
            }

            .import-conflicts-header,
            .import-conflicts-card-header,
            .import-conflicts-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .import-conflicts-actions,
            .import-conflicts-filter-actions {
                width: 100%;
            }

            .import-conflicts-actions .import-conflicts-btn,
            .import-conflicts-filter-actions .import-conflicts-btn,
            .import-conflicts-filter-actions button {
                width: 100%;
            }

            .import-conflicts-summary-grid,
            .import-conflicts-filter-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $selectedStatus = request('status', 'pending');

        $statusClass = function ($status) {
            return match (strtolower((string) $status)) {
                'resolved' => 'success',
                'reviewed' => 'info',
                'pending' => 'warning',
                'ignored', 'skipped' => 'secondary',
                default => 'secondary',
            };
        };

        $conflictTypeLabel = function ($type) {
            return match ($type) {
                'data_quality_conflict' => 'Data Quality',
                'strict_identity_conflict' => 'Changed Row',
                'completeness_conflict' => 'More Complete Incoming',
                'related_account_conflict' => 'Related Account',
                'ambiguous_account_conflict' => 'Ambiguous Account',
                'missing_from_latest_import' => 'Missing in Latest Import',
                default => 'Changed Row',
            };
        };

        $conflictTypeClass = function ($type) {
            return match ($type) {
                'data_quality_conflict' => 'danger',
                'strict_identity_conflict' => 'warning',
                'completeness_conflict' => 'info',
                'related_account_conflict' => 'info',
                'ambiguous_account_conflict' => 'secondary',
                'missing_from_latest_import' => 'secondary',
                default => 'warning',
            };
        };

        $pendingCount = $conflicts->getCollection()->where('status', 'pending')->count();
        $reviewedCount = $conflicts->getCollection()->where('status', 'reviewed')->count();
        $resolvedCount = $conflicts->getCollection()->where('status', 'resolved')->count();
    @endphp

    <div class="import-conflicts-page px-3 px-md-4 py-4">
        @if(session('success'))
            <div class="import-conflicts-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="import-conflicts-header">
            <div>
                <h1 class="import-conflicts-title">Import Conflicts</h1>
                <p class="import-conflicts-subtitle">
                    Review changed sales rows detected during import and track their resolution status.
                </p>
            </div>

            <div class="import-conflicts-actions">
                <a href="{{ route('import-batches.index') }}" class="import-conflicts-btn import-conflicts-btn-secondary">
                    Back to Import Batches
                </a>
                <a href="{{ route('import-conflicts.index', request()->query()) }}" class="import-conflicts-btn import-conflicts-btn-primary">
                    Refresh
                </a>
            </div>
        </div>

        <section class="import-conflicts-summary-grid">
            <article class="import-conflicts-summary-card">
                <div class="import-conflicts-summary-label">Visible Conflicts</div>
                <div class="import-conflicts-summary-value">{{ number_format($conflicts->total()) }}</div>
                <div class="import-conflicts-summary-meta">Total records returned by the current filters</div>
            </article>

            <article class="import-conflicts-summary-card">
                <div class="import-conflicts-summary-label">Pending in Page</div>
                <div class="import-conflicts-summary-value">{{ number_format($pendingCount) }}</div>
                <div class="import-conflicts-summary-meta">Pending records visible on this page</div>
            </article>

            <article class="import-conflicts-summary-card">
                <div class="import-conflicts-summary-label">Reviewed in Page</div>
                <div class="import-conflicts-summary-value">{{ number_format($reviewedCount) }}</div>
                <div class="import-conflicts-summary-meta">Reviewed records visible on this page</div>
            </article>

            <article class="import-conflicts-summary-card">
                <div class="import-conflicts-summary-label">Resolved in Page</div>
                <div class="import-conflicts-summary-value">{{ number_format($resolvedCount) }}</div>
                <div class="import-conflicts-summary-meta">Resolved records visible on this page</div>
            </article>
        </section>

        <section class="import-conflicts-filter-card mb-3">
            <div class="import-conflicts-card-header">
                <div>
                    <h2 class="import-conflicts-card-title">Conflict Filters</h2>
                    <p class="import-conflicts-card-subtitle">
                        Narrow the list by batch, branch, and review status.
                    </p>
                </div>
            </div>

            <div class="import-conflicts-card-body">
                <form method="GET" action="{{ route('import-conflicts.index') }}">
                    <div class="import-conflicts-filter-grid">
                        <div class="import-conflicts-field">
                            <label for="import_batch_id">Import Batch</label>
                            <select name="import_batch_id" id="import_batch_id">
                                <option value="">All Batches</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ request('import_batch_id') == $batch->id ? 'selected' : '' }}>
                                        #{{ $batch->id }} - {{ $batch->original_filename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="import-conflicts-field">
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

                        <div class="import-conflicts-field">
                            <label for="status">Status</label>
                            <select name="status" id="status">
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
                    </div>

                    <div class="import-conflicts-filter-actions mt-3">
                        <button type="submit" class="import-conflicts-btn import-conflicts-btn-primary">
                            Apply Filters
                        </button>
                        <a href="{{ route('import-conflicts.index') }}" class="import-conflicts-btn import-conflicts-btn-secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </section>

        <div class="import-conflicts-helper-card">
            <div class="import-conflicts-helper-title">Review Reminder</div>
            <p class="import-conflicts-helper-text">
                Compare the detected imported row carefully before resolving or relying on the record.
            </p>
        </div>

        <section class="import-conflicts-table-card">
            <div class="import-conflicts-card-header">
                <div>
                    <h2 class="import-conflicts-card-title">Conflict Records</h2>
                    <p class="import-conflicts-card-subtitle">
                        Review each detected conflict and open the record for deeper inspection.
                    </p>
                </div>
            </div>

            <div class="import-conflicts-toolbar">
                <div>
                    Showing <strong>{{ number_format($conflicts->count()) }}</strong> record(s) on this page out of
                    <strong>{{ number_format($conflicts->total()) }}</strong> total conflict(s)
                </div>

                <div>
                    Current status filter:
                    <strong>{{ $selectedStatus === 'all' ? 'All Statuses' : ucfirst($selectedStatus) }}</strong>
                </div>
            </div>

            <div class="import-conflicts-table-wrap">
                <table class="import-conflicts-table">
                    <thead>
                        <tr>
                            <th style="width: 90px;">ID</th>
                            <th style="width: 100px;">Batch</th>
                            <th>Sheet</th>
                            <th style="width: 180px;">Branch</th>
                            <th style="width: 110px;">Source Row</th>
                            <th style="width: 140px;">Status</th>
                            <th style="width: 190px;">Conflict Type</th>
                            <th>Notes</th>
                            <th class="text-end" style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conflicts as $conflict)
                            <tr>
                                <td>
                                    <span class="import-conflict-id">#{{ $conflict->id }}</span>
                                </td>
                                <td>
                                    <span class="import-conflict-id">#{{ $conflict->import_batch_id }}</span>
                                </td>
                                <td>{{ $conflict->importBatchSheet->sheet_name ?? '-' }}</td>
                                <td>{{ $conflict->branch->display_name ?? '-' }}</td>
                                <td>{{ $conflict->source_row_number ?? '-' }}</td>
                                <td>
                                    <span class="import-conflict-badge import-conflict-badge-{{ $statusClass($conflict->status) }}">
                                        {{ ucfirst($conflict->status) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="import-conflict-badge import-conflict-badge-{{ $conflictTypeClass($conflict->conflict_type) }}">
                                        {{ $conflictTypeLabel($conflict->conflict_type) }}
                                    </span>
                                </td>

                                <td class="import-conflict-notes" title="{{ $conflict->notes ?? '-' }}">
                                    {{ $conflict->notes ?? '-' }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('import-conflicts.show', $conflict) }}"
                                        class="import-conflicts-btn import-conflicts-btn-secondary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-0">
                                    <div class="import-conflicts-empty-state">
                                        <div class="import-conflicts-empty-title">No import conflicts found.</div>
                                        <div class="mb-3">
                                            This batch or filter currently has no records requiring manual review.
                                        </div>
                                        <a href="{{ route('import-conflicts.index') }}" class="import-conflicts-btn import-conflicts-btn-secondary">
                                            Reset Filters
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($conflicts->hasPages())
                <div class="import-conflicts-pagination">
                    {{ $conflicts->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
