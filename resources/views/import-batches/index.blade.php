<x-app-layout>
    <style>
        .import-page {
            max-width: 1600px;
            margin: 0 auto;
            padding-top: 6.5rem;
            color: #0f172a;
        }

        .import-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
        }

        .import-page-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 900;
            line-height: 1.15;
        }

        .import-page-subtitle {
            margin: .4rem 0 0;
            color: #64748b;
            font-size: .9rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .import-page-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: .55rem;
        }

        .import-btn {
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

        .import-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .import-btn-primary:hover,
        .import-btn-primary:focus {
            color: #ffffff;
            background: #1d4ed8;
            border-color: #1d4ed8;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .import-btn-secondary {
            color: #334155;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.14);
        }

        .import-btn-secondary:hover,
        .import-btn-secondary:focus {
            color: #0f172a;
            background: #f8fafc;
            border-color: rgba(15, 23, 42, 0.22);
            text-decoration: none;
        }

        .import-btn:active {
            transform: translateY(0);
        }

        .import-alert {
            background: #ecfdf5;
            border: 1px solid rgba(34, 197, 94, 0.22);
            color: #166534;
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            padding: .85rem 1rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .import-summary-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: .9rem;
            margin-bottom: 1.15rem;
        }

        .import-summary-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.055);
            padding: 1rem;
            min-width: 0;
        }

        .import-summary-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .import-summary-value {
            color: #0f172a;
            font-size: 1.32rem;
            font-weight: 900;
            line-height: 1.1;
            margin-top: .45rem;
            overflow-wrap: anywhere;
        }

        .import-summary-meta {
            color: #64748b;
            font-size: .8rem;
            font-weight: 600;
            line-height: 1.4;
            margin-top: .35rem;
        }

        .import-table-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .import-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .8rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .import-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
        }

        .import-card-subtitle {
            margin: .25rem 0 0;
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .import-table-toolbar {
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

        .import-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .import-batches-table {
            width: 100%;
            min-width: 1050px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .import-batches-table thead th {
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

        .import-batches-table tbody td {
            padding: .88rem .78rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: .84rem;
            vertical-align: middle;
        }

        .import-batches-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .import-batches-table tbody tr:hover td {
            background: #f3f4f6;
        }

        .import-batch-id {
            color: #0f172a;
            font-weight: 900;
            white-space: nowrap;
        }

        .import-file-name {
            color: #0f172a;
            font-size: .9rem;
            font-weight: 900;
            line-height: 1.35;
            max-width: 360px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .import-file-meta {
            color: #64748b;
            font-size: .76rem;
            font-weight: 700;
            margin-top: .12rem;
        }

        .import-muted {
            color: #64748b;
            font-size: .8rem;
            font-weight: 700;
        }

        .import-source-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            color: #475569;
            background: rgba(100, 116, 139, 0.10);
            border: 1px solid rgba(100, 116, 139, 0.18);
            padding: .28rem .6rem;
            font-size: .68rem;
            font-weight: 900;
            letter-spacing: .03em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .import-status-badge {
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

        .import-status-success {
            color: #166534;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.22);
        }

        .import-status-info {
            color: #1d4ed8;
            background: rgba(37, 99, 235, 0.10);
            border: 1px solid rgba(37, 99, 235, 0.20);
        }

        .import-status-warning {
            color: #92400e;
            background: rgba(245, 158, 11, 0.14);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .import-status-danger {
            color: #991b1b;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.22);
        }

        .import-status-secondary {
            color: #475569;
            background: rgba(100, 116, 139, 0.10);
            border: 1px solid rgba(100, 116, 139, 0.18);
        }

        .import-empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            color: #64748b;
        }

        .import-empty-title {
            color: #0f172a;
            font-size: 1.05rem;
            font-weight: 900;
            margin-bottom: .35rem;
        }

        .import-pagination {
            padding: 1rem 1.1rem;
            background: #ffffff;
        }

        @media (max-width: 1199.98px) {
            .import-summary-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .import-page {
                padding-top: 5.75rem;
            }

            .import-page-header,
            .import-card-header,
            .import-table-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .import-page-actions {
                width: 100%;
            }

            .import-page-actions .import-btn {
                width: 100%;
            }

            .import-summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $showingFrom = method_exists($importBatches, 'firstItem') ? $importBatches->firstItem() : null;
        $showingTo = method_exists($importBatches, 'lastItem') ? $importBatches->lastItem() : null;
        $totalRows = method_exists($importBatches, 'total') ? $importBatches->total() : $importBatches->count();
        $currentRows = $importBatches->getCollection();
        $latestBatch = $currentRows->first();
        $processedCount = $currentRows->filter(fn ($batch) => in_array(strtolower((string) $batch->status), ['processed', 'completed', 'success', 'imported'], true))->count();
        $reviewCount = $currentRows->filter(fn ($batch) => in_array(strtolower((string) $batch->status), ['pending', 'queued', 'uploaded', 'processing'], true))->count();
        $failedCount = $currentRows->filter(fn ($batch) => in_array(strtolower((string) $batch->status), ['failed', 'error', 'rejected'], true))->count();

        $statusClass = function ($status) {
            return match (strtolower((string) $status)) {
                'processed', 'completed', 'success', 'imported' => 'success',
                'processing', 'parsing', 'in_progress' => 'info',
                'pending', 'queued', 'draft', 'uploaded' => 'warning',
                'failed', 'error', 'rejected' => 'danger',
                default => 'secondary',
            };
        };

        $formatStatus = fn ($status) => filled($status) ? ucfirst(str_replace('_', ' ', (string) $status)) : 'Unknown';
    @endphp

    <div class="import-page px-3 px-md-4 py-4">
        @if(session('success'))
            <div class="import-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="import-page-header">
            <div>
                <h1 class="import-page-title">Import Batches</h1>
                <p class="import-page-subtitle">
                    Monitor uploaded files, import progress, processed sheets, and batch review activity.
                </p>
            </div>

            <div class="import-page-actions">
                <a href="{{ route('import-batches.index') }}" class="import-btn import-btn-secondary">
                    Refresh
                </a>
                <a href="{{ route('import-batches.create') }}" class="import-btn import-btn-primary">
                    Upload New File
                </a>
            </div>
        </div>

        <div class="import-summary-grid">
            <article class="import-summary-card">
                <div class="import-summary-label">Total Import Batches</div>
                <div class="import-summary-value">{{ number_format($totalRows) }}</div>
                <div class="import-summary-meta">Uploaded import files recorded in the system</div>
            </article>

            <article class="import-summary-card">
                <div class="import-summary-label">Visible Processed</div>
                <div class="import-summary-value">{{ number_format($processedCount) }}</div>
                <div class="import-summary-meta">Processed or completed records on this page</div>
            </article>

            <article class="import-summary-card">
                <div class="import-summary-label">Visible Needs Review</div>
                <div class="import-summary-value">{{ number_format($reviewCount) }}</div>
                <div class="import-summary-meta">Pending, uploaded, queued, or processing records on this page</div>
            </article>

            <article class="import-summary-card">
                <div class="import-summary-label">Visible Failed</div>
                <div class="import-summary-value">{{ number_format($failedCount) }}</div>
                <div class="import-summary-meta">Failed records visible on this page</div>
            </article>

            <article class="import-summary-card">
                <div class="import-summary-label">Latest Visible Import</div>
                <div class="import-summary-value">{{ $latestBatch ? '#' . $latestBatch->id : '—' }}</div>
                <div class="import-summary-meta">{{ $latestBatch?->original_filename ?? 'No visible import batch available' }}</div>
            </article>
        </div>

        <section class="import-table-card">
            <div class="import-card-header">
                <div>
                    <h2 class="import-card-title">Import Batch List</h2>
                    <p class="import-card-subtitle">
                        Review imported files, upload source details, status, and processing activity.
                    </p>
                </div>
            </div>

            <div class="import-table-toolbar">
                <div>
                    @if($showingFrom && $showingTo)
                        Showing <strong>{{ number_format($showingFrom) }}</strong>-<strong>{{ number_format($showingTo) }}</strong>
                        of <strong>{{ number_format($totalRows) }}</strong> result(s)
                    @else
                        Showing <strong>{{ number_format($importBatches->count()) }}</strong> result(s)
                    @endif
                </div>
                <div>Actions use existing import batch routes</div>
            </div>

            <div class="import-table-wrap">
                <table class="import-batches-table">
                    <thead>
                        <tr>
                            <th>Batch / File Name</th>
                            <th>Status</th>
                            <th>Source Type</th>
                            <th>Uploaded By</th>
                            <th>Imported At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($importBatches as $batch)
                            @php
                                $badgeClass = 'import-status-' . $statusClass($batch->status);
                            @endphp
                            <tr>
                                <td>
                                    <div class="import-file-name" title="{{ $batch->original_filename }}">
                                        {{ $batch->original_filename }}
                                    </div>
                                    <div class="import-file-meta">
                                        <span class="import-batch-id">#{{ $batch->id }}</span>
                                        <span class="ms-2">Stored source record</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="import-status-badge {{ $badgeClass }}">
                                        {{ $formatStatus($batch->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="import-source-pill">{{ $batch->source_type ?? '—' }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $batch->user->name ?? '—' }}</div>
                                </td>
                                <td>
                                    {{ optional($batch->imported_at)->format('M d, Y h:i A') ?? '—' }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('import-batches.show', $batch) }}" class="import-btn import-btn-secondary">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-0">
                                    <div class="import-empty-state">
                                        <div class="import-empty-title">No import batches found</div>
                                        <div class="mb-3">There are no uploaded import files to display yet.</div>
                                        <a href="{{ route('import-batches.create') }}" class="import-btn import-btn-primary">
                                            Upload Your First File
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($importBatches->hasPages())
                <div class="import-pagination">
                    {{ $importBatches->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
