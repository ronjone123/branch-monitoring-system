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

        .detail-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem 1rem;
        }

        .page-loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 59, 120, 0.28);
            backdrop-filter: blur(3px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-loading-overlay.d-none {
            display: none !important;
        }

        .page-loading-box {
            width: min(92vw, 420px);
            background: #ffffff;
            border: 1px solid #cfd9ea;
            border-radius: 1.25rem;
            box-shadow: 0 24px 60px rgba(15, 59, 120, 0.18);
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .page-loading-spinner {
            width: 56px;
            height: 56px;
            margin: 0 auto 1rem;
            border: 5px solid #d9e6f7;
            border-top-color: #0f3b78;
            border-radius: 50%;
            animation: pageSpin 0.9s linear infinite;
        }

        .page-loading-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #162033;
            margin-bottom: 0.35rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .page-loading-text {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        body.loading-active {
            overflow: hidden;
        }

        @keyframes pageSpin {
            to {
                transform: rotate(360deg);
            }
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
            padding: 0.65rem 1.15rem;
        }

        .btn-summary-primary:hover {
            background: var(--summary-blue-dark);
            border-color: var(--summary-blue-dark);
            color: #fff;
        }

        .btn-summary-success {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.65rem 1.15rem;
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
                'processed', 'completed', 'success', 'parsed' => 'success',
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

   <div class="summary-shell px-3 px-md-4 py-4" style="padding-top: 6.5rem;">
        @if(session('success'))
            <div class="alert alert-success rounded-4 shadow-sm border-0">
                {{ session('success') }}
            </div>
        @endif

        {{-- Hero --}}
        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Import Batch Details</div>
                    <div class="mt-2 text-white-50">
                        Review batch metadata, sheet tracking, parsing progress, and import errors.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Imported At</div>
                    <div class="summary-date-value">
                        {{ optional($importBatch->imported_at)->format('M d, Y') ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Action row --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div class="text-muted small">
                Batch ID <strong>#{{ $importBatch->id }}</strong> ·
                Status <strong>{{ $formatStatus($importBatch->status) }}</strong>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <form action="{{ route('import-batches.parse-all', $importBatch) }}"
                    method="POST"
                    data-loading="true"
                    data-loading-message="Parsing all transaction sheets. Please wait...">
                    @csrf
                    <button type="submit" class="btn btn-success btn-summary-success">
                        Parse All Transaction Sheets
                    </button>
                </form>

                <a href="{{ route('import-batches.index') }}" class="btn btn-outline-secondary btn-summary-outline">
                    Back to List
                </a>
            </div>
        </div>

        {{-- Quick summary --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Total Sheets</div>
                    <div class="summary-stat-value">{{ $importBatch->total_sheets }}</div>
                    <div class="summary-stat-sub">Detected sheets in the uploaded file</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Total Rows</div>
                    <div class="summary-stat-value">{{ $importBatch->total_rows }}</div>
                    <div class="summary-stat-sub">All rows discovered during batch scan</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Imported Rows</div>
                    <div class="summary-stat-value">{{ $importBatch->imported_rows }}</div>
                    <div class="summary-stat-sub">Rows successfully imported into the system</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Conflict Rows</div>
                    <div class="summary-stat-value">{{ $importBatch->conflict_rows }}</div>
                    <div class="summary-stat-sub">Rows requiring further review or action</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Batch info --}}
            <div class="col-lg-5">
                <div class="summary-card h-100">
                    <div class="summary-section-header">
                        <h5>Batch Information</h5>
                        <div class="summary-section-subtitle">
                            Metadata and processing totals for this import batch.
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="detail-list">
                            <div class="detail-item">
                                <div class="detail-label">ID</div>
                                <div class="detail-value">#{{ $importBatch->id }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="soft-badge {{ $mapStatusClass($importBatch->status) }}">
                                        {{ $formatStatus($importBatch->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Original Filename</div>
                                <div class="detail-value">{{ $importBatch->original_filename }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Stored Filename</div>
                                <div class="detail-value">{{ $importBatch->stored_filename ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Uploaded By</div>
                                <div class="detail-value">{{ $importBatch->user->name ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Source Type</div>
                                <div class="detail-value text-uppercase">{{ $importBatch->source_type ?? '-' }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Supported Sheets</div>
                                <div class="detail-value">{{ $importBatch->supported_sheets }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Valid Rows</div>
                                <div class="detail-value">{{ $importBatch->valid_rows }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Invalid Rows</div>
                                <div class="detail-value">{{ $importBatch->invalid_rows }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Skipped Rows</div>
                                <div class="detail-value">{{ $importBatch->skipped_rows }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Duplicate Rows</div>
                                <div class="detail-value">{{ $importBatch->duplicate_rows }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Imported At</div>
                                <div class="detail-value">{{ optional($importBatch->imported_at)->format('M d, Y h:i A') ?? '-' }}</div>
                            </div>

                            <div class="detail-item" style="grid-column: 1 / -1;">
                                <div class="detail-label">Notes</div>
                                <div class="detail-value">{{ $importBatch->notes ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right side sections --}}
            <div class="col-lg-7">
                <div class="summary-card mb-4">
                    <div class="summary-section-header">
                        <h5>Sheet Tracking</h5>
                        <div class="summary-section-subtitle">
                            Track transaction sheets, parsing status, row counts, and next actions.
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Sheet Name</th>
                                        <th>Type</th>
                                        <th>Branch</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Imported</th>
                                        <th>Valid</th>
                                        <th>Duplicate</th>
                                        <th>Conflict</th>
                                        <th>Notes</th>
                                        <th style="min-width: 170px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($importBatch->sheets as $sheet)
                                        <tr>
                                            <td class="fw-semibold">{{ $sheet->sheet_name }}</td>
                                            <td>{{ ucfirst($sheet->sheet_type) }}</td>
                                            <td>{{ $sheet->branch->display_name ?? '-' }}</td>
                                            <td>
                                                <span class="soft-badge {{ $mapStatusClass($sheet->status) }}">
                                                    {{ ucfirst($sheet->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $sheet->total_rows }}</td>
                                            <td>{{ $sheet->imported_rows }}</td>
                                            <td>{{ $sheet->valid_rows }}</td>
                                            <td>{{ $sheet->duplicate_rows }}</td>
                                            <td>{{ $sheet->conflict_rows }}</td>
                                            <td>{{ $sheet->notes ?? '-' }}</td>
                                            <td>
                                                @if($sheet->sheet_type === 'transaction')
                                                    <div class="d-flex flex-column gap-2">
                                                        <a href="{{ route('import-batches.sheets.preview', [$importBatch, $sheet]) }}"
                                                           class="btn btn-sm btn-outline-primary btn-summary-outline">
                                                            Preview
                                                        </a>

                                                        <form action="{{ route('import-batches.sheets.parse', [$importBatch, $sheet]) }}"
                                                                method="POST"
                                                                data-loading="true"
                                                                data-loading-message="Parsing selected sheet. Please wait...">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success w-100 btn-summary-outline">
                                                                Parse
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('import-batch-sheets.reset', $sheet) }}"
                                                                method="POST"
                                                                data-loading="true"
                                                                data-loading-message="Resetting parsed sheet data. Please wait..."
                                                                onsubmit="return confirm('Reset parsed data for this sheet?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 btn-summary-outline">
                                                                Reset
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="p-0">
                                                <div class="empty-state">
                                                    <div class="empty-state-title">No sheet records yet</div>
                                                    <div>No sheet tracking records are available for this batch.</div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>Import Errors</h5>
                        <div class="summary-section-subtitle">
                            Validation or parsing issues detected during import processing.
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Sheet</th>
                                        <th>Row</th>
                                        <th>Field</th>
                                        <th>Error</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($importBatch->errors as $error)
                                        <tr>
                                            <td>{{ $error->sheet_name }}</td>
                                            <td>{{ $error->row_number }}</td>
                                            <td>{{ $error->field_name ?? '-' }}</td>
                                            <td>{{ $error->error_message }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-0">
                                                <div class="empty-state">
                                                    <div class="empty-state-title">No import errors yet</div>
                                                    <div>No validation or parsing errors have been recorded for this batch.</div>
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
        <div id="pageLoadingOverlay" class="page-loading-overlay d-none">
            <div class="page-loading-box">
                <div class="page-loading-spinner"></div>
                <div class="page-loading-title">Processing Request</div>
                <div class="page-loading-text">
                    Please wait while the system uploads and processes the file.
                </div>
            </div>
        </div>

        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const overlay = document.getElementById('pageLoadingOverlay');

        function showLoading(message = null) {
            if (!overlay) return;

            if (message) {
                const text = overlay.querySelector('.page-loading-text');
                if (text) text.textContent = message;
            }

            overlay.classList.remove('d-none');
            document.body.classList.add('loading-active');
        }

        document.querySelectorAll('form[data-loading="true"]').forEach(form => {
            form.addEventListener('submit', function () {
                const message = form.getAttribute('data-loading-message');
                showLoading(message);

                const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                submitButtons.forEach(btn => {
                    btn.disabled = true;
                });
            });
        });
    });

    submitButtons.forEach(btn => {
    btn.disabled = true;
    if (btn.tagName === 'BUTTON') {
        btn.dataset.originalText = btn.innerHTML;
        btn.innerHTML = 'Processing...';
    }
});
</script>
</x-app-layout>