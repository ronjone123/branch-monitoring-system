<x-app-layout>
    <style>
        :root {
            --summary-blue: #0f3b78;
            --summary-blue-dark: #0b2f60;
            --summary-blue-soft: #eaf2ff;
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
            font-size: 1.35rem;
            font-weight: 800;
            margin-top: 0.35rem;
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
            font-size: 1.65rem;
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
            font-size: 0.85rem;
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

        .file-name {
            font-weight: 700;
            color: var(--summary-text);
        }

        .file-meta {
            font-size: 0.8rem;
            color: var(--summary-muted);
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
            background: #eef2f7;
            color: #475467;
        }

        .btn-summary-primary {
            background: var(--summary-blue);
            border-color: var(--summary-blue);
            color: #fff;
            border-radius: 999px;
            font-weight: 700;
            padding: 0.65rem 1.15rem;
        }

        .btn-summary-primary:hover {
            background: var(--summary-blue-dark);
            border-color: var(--summary-blue-dark);
            color: #fff;
        }

        .btn-summary-outline {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.45rem 0.9rem;
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
                font-size: 1.6rem;
            }

            .summary-date-box {
                border-left: 0;
                border-top: 1px solid rgba(255, 255, 255, 0.15);
                min-width: 100%;
            }
        }
    </style>

    @php
        $showingFrom = method_exists($importBatches, 'firstItem') ? $importBatches->firstItem() : null;
        $showingTo = method_exists($importBatches, 'lastItem') ? $importBatches->lastItem() : null;
        $totalRows = method_exists($importBatches, 'total') ? $importBatches->total() : $importBatches->count();

        $mapStatusClass = function ($status) {
            return match (strtolower((string) $status)) {
                'processed', 'completed', 'success' => 'success',
                'processing', 'parsing', 'uploaded', 'in_progress' => 'info',
                'pending', 'queued', 'draft' => 'warning',
                'failed', 'error', 'rejected' => 'danger',
                default => 'secondary',
            };
        };

        $formatStatus = function ($status) {
            return ucfirst(str_replace('_', ' ', (string) $status));
        };
    @endphp

    <div class="summary-shell page-with-fixed-nav px-3 px-md-4 py-4">
        @if(session('success'))
            <div class="alert alert-success rounded-4 shadow-sm border-0">
                {{ session('success') }}
            </div>
        @endif

        {{-- Hero --}}
        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Import Batches</div>
                    <div class="mt-2 text-white-50">
                        Track uploaded import files, monitor processing status, and review import activity.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Date</div>
                    <div class="summary-date-value">{{ now()->format('F d, Y') }}</div>
                </div>
            </div>
        </div>

        {{-- Quick summary row --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Total Import Batches</div>
                    <div class="summary-stat-value">{{ $totalRows }}</div>
                    <div class="summary-stat-sub">All uploaded import files recorded in the system</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Showing Records</div>
                    <div class="summary-stat-value">
                        {{ $showingFrom && $showingTo ? $showingFrom . ' - ' . $showingTo : $importBatches->count() }}
                    </div>
                    <div class="summary-stat-sub">Current list range displayed on this page</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat d-flex flex-column justify-content-between">
                    <div>
                        <div class="summary-stat-label">Next Action</div>
                        <div class="summary-stat-value" style="font-size: 1.2rem;">Upload New File</div>
                        <div class="summary-stat-sub">Create a new import batch from an Excel file</div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('import-batches.create') }}" class="btn btn-summary-primary">
                            Upload New File
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main table card --}}
        <div class="summary-card">
            <div class="summary-section-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h5>Import Batch List</h5>
                    <div class="summary-section-subtitle">
                        Review imported files, upload source details, status, and processing activity.
                    </div>
                </div>
            </div>

            <div class="summary-toolbar d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="text-muted small">
                    @if($showingFrom && $showingTo)
                        Showing <strong>{{ $showingFrom }}</strong> to <strong>{{ $showingTo }}</strong> of <strong>{{ $totalRows }}</strong> results
                    @else
                        Showing <strong>{{ $importBatches->count() }}</strong> result(s)
                    @endif
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 90px;">ID</th>
                                <th>Filename</th>
                                <th style="width: 180px;">Uploaded By</th>
                                <th style="width: 150px;">Source Type</th>
                                <th style="width: 150px;">Status</th>
                                <th style="width: 180px;">Imported At</th>
                                <th class="text-end" style="width: 130px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($importBatches as $batch)
                                @php
                                    $statusClass = $mapStatusClass($batch->status);
                                @endphp
                                <tr>
                                    <td class="fw-bold">#{{ $batch->id }}</td>

                                    <td>
                                        <div class="file-name">{{ $batch->original_filename }}</div>
                                        <div class="file-meta">
                                            Batch record #{{ $batch->id }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">{{ $batch->user->name ?? '-' }}</div>
                                    </td>

                                    <td>
                                        <span class="text-uppercase fw-semibold text-muted small">
                                            {{ $batch->source_type ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="soft-badge {{ $statusClass }}">
                                            {{ $formatStatus($batch->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ optional($batch->imported_at)->format('M d, Y h:i A') ?? '-' }}
                                    </td>

                                    <td class="text-end">
                                        <a href="{{ route('import-batches.show', $batch) }}"
                                           class="btn btn-sm btn-outline-primary btn-summary-outline">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-0">
                                        <div class="empty-state">
                                            <div class="empty-state-title">No import batches found</div>
                                            <div class="mb-3">
                                                There are no uploaded import files to display yet.
                                            </div>
                                            <a href="{{ route('import-batches.create') }}" class="btn btn-summary-primary">
                                                Upload Your First File
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($importBatches->hasPages())
                <div class="card-footer bg-white border-0 px-4 py-3">
                    {{ $importBatches->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>