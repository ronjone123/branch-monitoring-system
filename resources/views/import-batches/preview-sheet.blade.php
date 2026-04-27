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
            font-size: 1.4rem;
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

        .btn-summary-outline {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.65rem 1.15rem;
        }

        .row-highlight-header {
            background: #fff8e6 !important;
        }

        .row-highlight-header td,
        .row-highlight-header th {
            background: #fff8e6 !important;
            color: #8a5a00;
            font-weight: 700;
        }

        .usable-row td,
        .usable-row th {
            background: #f1fbf4 !important;
        }

        .chip-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
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

        .preview-row-label {
            min-width: 90px;
            white-space: nowrap;
            font-weight: 700;
            color: var(--summary-text);
            background: #f8fafc;
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
        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Sheet Preview</div>
                    <div class="mt-2 text-white-50">
                        Preview raw spreadsheet data, detected headers, and usable mapping for {{ $sheet->sheet_name }}.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Batch Reference</div>
                    <div class="summary-date-value">
                        #{{ $importBatch->id }}<br>{{ $preview['sheet_name'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div class="text-muted small">
                Reviewing sheet <strong>{{ $sheet->sheet_name }}</strong> from import batch <strong>#{{ $importBatch->id }}</strong>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('import-batches.show', $importBatch) }}" class="btn btn-outline-secondary btn-summary-outline">
                    Back to Batch
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Highest Row</div>
                    <div class="summary-stat-value">{{ $preview['highest_row'] }}</div>
                    <div class="summary-stat-sub">Last detected spreadsheet row in this sheet</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Highest Column</div>
                    <div class="summary-stat-value">{{ $preview['highest_column'] }}</div>
                    <div class="summary-stat-sub">Last detected spreadsheet column</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Header Row</div>
                    <div class="summary-stat-value">{{ $preview['header_row_number'] ?? '-' }}</div>
                    <div class="summary-stat-sub">Detected row used as the source header</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-stat">
                    <div class="summary-stat-label">Last Useful Column</div>
                    <div class="summary-stat-value">{{ $preview['last_useful_column_letter'] ?? '-' }}</div>
                    <div class="summary-stat-sub">Last meaningful mapped column detected</div>
                </div>
            </div>
        </div>

        <div class="summary-card mb-4">
            <div class="summary-section-header">
                <h5>Detected Headers</h5>
                <div class="summary-section-subtitle">
                    Raw headers recognized from the detected header row.
                </div>
            </div>

            <div class="p-4">
                @if(!empty($preview['headers']))
                    <div class="chip-wrap">
                        @foreach($preview['headers'] as $header)
                            <span class="soft-badge info">{{ $header ?: '(blank)' }}</span>
                        @endforeach
                    </div>
                @else
                    <div class="text-muted">No header row detected yet.</div>
                @endif
            </div>
        </div>

        <div class="summary-card mb-4">
            <div class="summary-section-header">
                <h5>Usable Headers Only</h5>
                <div class="summary-section-subtitle">
                    Cleaned columns considered usable for mapping and parsing.
                </div>
            </div>

            <div class="p-4">
                @if(!empty($preview['usable_header_map']))
                    <div class="chip-wrap">
                        @foreach($preview['usable_header_map'] as $header)
                            <span class="soft-badge success">
                                {{ $header['column_letter'] }} - {{ $header['clean_header'] }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="text-muted">No usable headers detected.</div>
                @endif
            </div>
        </div>

        <div class="summary-card mb-4">
            <div class="summary-section-header">
                <h5>Header Mapping Preview</h5>
                <div class="summary-section-subtitle">
                    Compare raw headers, cleaned headers, and usability status by column.
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <thead>
                            <tr>
                                <th>Column</th>
                                <th>Raw Header</th>
                                <th>Clean Header</th>
                                <th>Usable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($preview['header_map'] as $header)
                                <tr class="{{ $header['is_useful'] ? 'usable-row' : '' }}">
                                    <td class="fw-semibold">{{ $header['column_letter'] }}</td>
                                    <td>{{ $header['raw_header'] ?? '-' }}</td>
                                    <td>{{ $header['clean_header'] ?? '-' }}</td>
                                    <td>
                                        @if($header['is_useful'])
                                            <span class="soft-badge success">Yes</span>
                                        @else
                                            <span class="soft-badge secondary">No</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-0">
                                        <div class="empty-state">
                                            <div class="empty-state-title">No header map available</div>
                                            <div>There is no header mapping data available for this preview.</div>
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
                <h5>First 20 Rows</h5>
                <div class="summary-section-subtitle">
                    Raw spreadsheet preview. The detected header row is highlighted.
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table report-table align-middle">
                        <tbody>
                            @foreach($preview['preview_rows'] as $rowNumber => $cells)
                                <tr class="{{ $rowNumber === $preview['header_row_number'] ? 'row-highlight-header' : '' }}">
                                    <th class="preview-row-label">
                                        Row {{ $rowNumber }}
                                    </th>
                                    @foreach($cells as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>