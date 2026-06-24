<x-app-layout>
    <style>
        body {
            background: #f4f7fb;
        }

        .import-conflict-show-page {
            max-width: 1600px;
            margin: 0 auto;
            padding-top: 6.5rem;
            color: #0f172a;
        }

        .import-conflict-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: .35rem;
            color: #64748b;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .7rem;
        }

        .import-conflict-breadcrumb a {
            color: #2563eb;
            text-decoration: none;
        }

        .import-conflict-breadcrumb a:hover,
        .import-conflict-breadcrumb a:focus {
            color: #1d4ed8;
            text-decoration: none;
        }

        .import-conflict-show-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
        }

        .import-conflict-show-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 900;
            line-height: 1.15;
        }

        .import-conflict-show-subtitle {
            margin: .4rem 0 0;
            color: #64748b;
            font-size: .92rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .import-conflict-actions,
        .import-conflict-action-stack {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: .55rem;
        }

        .import-conflict-action-stack {
            align-items: stretch;
            flex-direction: column;
        }

        .import-conflict-action-stack form {
            margin: 0;
        }

        .import-conflict-btn {
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

        .import-conflict-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .import-conflict-btn-primary:hover,
        .import-conflict-btn-primary:focus {
            color: #ffffff;
            background: #1d4ed8;
            border-color: #1d4ed8;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .import-conflict-btn-success {
            color: #ffffff;
            background: #16a34a;
            border: 1px solid #16a34a;
            box-shadow: 0 8px 18px rgba(22, 163, 74, 0.14);
        }

        .import-conflict-btn-success:hover,
        .import-conflict-btn-success:focus {
            color: #ffffff;
            background: #15803d;
            border-color: #15803d;
            text-decoration: none;
        }

        .import-conflict-btn-info {
            color: #ffffff;
            background: #0ea5e9;
            border: 1px solid #0ea5e9;
        }

        .import-conflict-btn-info:hover,
        .import-conflict-btn-info:focus {
            color: #ffffff;
            background: #0284c7;
            border-color: #0284c7;
            text-decoration: none;
        }

        .import-conflict-btn-secondary {
            color: #334155;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.14);
        }

        .import-conflict-btn-secondary:hover,
        .import-conflict-btn-secondary:focus {
            color: #0f172a;
            background: #f8fafc;
            border-color: rgba(15, 23, 42, 0.22);
            text-decoration: none;
        }

        .import-conflict-btn-danger {
            color: #991b1b;
            background: #ffffff;
            border: 1px solid rgba(239, 68, 68, 0.28);
        }

        .import-conflict-btn-danger:hover,
        .import-conflict-btn-danger:focus {
            color: #ffffff;
            background: #dc2626;
            border-color: #dc2626;
            text-decoration: none;
        }

        .import-conflict-alert {
            background: #ecfdf5;
            border: 1px solid rgba(34, 197, 94, 0.22);
            color: #166534;
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            padding: .85rem 1rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .import-conflict-hero,
        .import-conflict-summary-card,
        .import-conflict-reminder-card,
        .import-conflict-data-card,
        .import-conflict-diff-card,
        .import-conflict-actions-card,
        .import-conflict-audit-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .import-conflict-hero {
            padding: 1.15rem;
            margin-bottom: 1.15rem;
        }

        .import-conflict-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .import-conflict-hero-title {
            color: #0f172a;
            font-size: 1.1rem;
            font-weight: 900;
            line-height: 1.35;
        }

        .import-conflict-hero-meta {
            color: #64748b;
            font-size: .82rem;
            font-weight: 700;
            margin-top: .2rem;
        }

        .import-conflict-badge-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: .45rem;
        }

        .import-conflict-meta-grid,
        .import-conflict-summary-grid,
        .import-conflict-context-grid,
        .import-conflict-technical-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: .85rem;
        }

        .import-conflict-summary-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 1.15rem;
        }

        .import-conflict-field-row {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: .9rem;
            background: #f8fafc;
            padding: .85rem;
            min-width: 0;
        }

        .import-conflict-field-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .import-conflict-field-value {
            color: #0f172a;
            font-size: .9rem;
            font-weight: 850;
            line-height: 1.35;
            margin-top: .32rem;
            overflow-wrap: anywhere;
        }

        .import-conflict-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .8rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .import-conflict-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
        }

        .import-conflict-card-subtitle {
            margin: .25rem 0 0;
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .import-conflict-card-body {
            padding: 1.1rem;
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

        .import-conflict-reminder-card {
            padding: .95rem 1rem;
            background: #fffbeb;
            border-color: rgba(245, 158, 11, 0.22);
            margin-bottom: 1.15rem;
        }

        .import-conflict-reminder-title {
            color: #92400e;
            font-size: .9rem;
            font-weight: 900;
            margin-bottom: .25rem;
        }

        .import-conflict-reminder-text {
            color: #92400e;
            font-size: .84rem;
            font-weight: 650;
            line-height: 1.45;
            margin: 0;
        }

        .import-conflict-comparison-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.15rem;
        }

        .import-conflict-data-list {
            display: grid;
            gap: .7rem;
        }

        .import-conflict-data-row {
            display: grid;
            grid-template-columns: minmax(120px, .42fr) minmax(0, 1fr);
            gap: .8rem;
            align-items: start;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: .85rem;
            background: #f8fafc;
            padding: .78rem .85rem;
        }

        .import-conflict-data-row.is-different {
            background: #fffbeb;
            border-color: rgba(245, 158, 11, 0.25);
            box-shadow: inset 4px 0 0 rgba(245, 158, 11, 0.55);
        }

        .import-conflict-data-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .import-conflict-data-value {
            color: #0f172a;
            font-size: .88rem;
            font-weight: 800;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .import-conflict-diff-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .85rem;
        }

        .import-conflict-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .import-conflict-comparison-table {
            width: 100%;
            min-width: 920px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .import-conflict-comparison-table thead th {
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

        .import-conflict-comparison-table tbody td {
            padding: .88rem .78rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: .84rem;
            vertical-align: middle;
        }

        .import-conflict-comparison-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .import-conflict-comparison-table tbody tr.is-different td {
            background: #fffbeb;
        }

        .import-conflict-layout-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(320px, .85fr);
            gap: 1rem;
            align-items: start;
            margin-bottom: 1.15rem;
        }

        .import-conflict-empty-state {
            padding: 2.2rem 1.2rem;
            text-align: center;
            color: #64748b;
            font-weight: 650;
        }

        .import-conflict-audit-card details {
            padding: 1rem 1.1rem;
        }

        .import-conflict-audit-card summary {
            cursor: pointer;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
            list-style: none;
        }

        .import-conflict-audit-card summary::-webkit-details-marker {
            display: none;
        }

        @media (max-width: 1199.98px) {
            .import-conflict-meta-grid,
            .import-conflict-summary-grid,
            .import-conflict-context-grid,
            .import-conflict-technical-grid,
            .import-conflict-diff-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .import-conflict-layout-grid,
            .import-conflict-comparison-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .import-conflict-show-page {
                padding-top: 5.75rem;
            }

            .import-conflict-show-header,
            .import-conflict-hero-top,
            .import-conflict-card-header {
                align-items: stretch;
                flex-direction: column;
            }

            .import-conflict-actions,
            .import-conflict-actions .import-conflict-btn,
            .import-conflict-action-stack .import-conflict-btn,
            .import-conflict-action-stack button {
                width: 100%;
            }

            .import-conflict-meta-grid,
            .import-conflict-summary-grid,
            .import-conflict-context-grid,
            .import-conflict-technical-grid,
            .import-conflict-diff-grid {
                grid-template-columns: 1fr;
            }

            .import-conflict-data-row {
                grid-template-columns: 1fr;
                gap: .25rem;
            }
        }
    </style>

    @php
        $statusClass = function ($status) {
            return match (strtolower((string) $status)) {
                'resolved' => 'success',
                'reviewed' => 'info',
                'pending' => 'warning',
                'ignored', 'skipped' => 'secondary',
                'error', 'failed' => 'danger',
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

        $displayValue = function ($value) {
            return filled($value) ? $value : '-';
        };
        $canDeleteImportConflict = auth()->user()?->hasAnyRole(['super_admin', 'admin']);

        $comparison = collect($comparisonRows);
        $changedRows = $comparison->where('changed', true);
        $changedCount = $changedRows->count();
        $sameCount = $comparison->where('changed', false)->count();
        $missingCount = $comparison->filter(function ($row) {
            return ! filled($row['existing'] ?? null) || ! filled($row['incoming'] ?? null);
        })->count();

        $rowByLabel = $comparison->keyBy('label');
        $summaryFields = [
            'Customer Name',
            'Account Number',
            'Branch Name From Sheet',
            'Model',
            'Brand',
            'Unit Type',
            'Cash Amount',
            'Promissory Note Amount',
            'Gross Sales Amount',
            'SRP / COD Amount',
            'Invoice Date',
            'Receipt Number',
            'Terms',
            'Product Remarks',
        ];

        $firstChangedLabels = $changedRows->take(6)->pluck('label')->implode(', ');
    @endphp

    <div class="import-conflict-show-page px-3 px-md-4 py-4">
        @if(session('success'))
            <div class="import-conflict-alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="import-conflict-alert">
                {{ session('warning') }}
            </div>
        @endif

        <div class="import-conflict-breadcrumb">
            <a href="{{ route('import-conflicts.index') }}">Import Conflicts</a>
            <span>/</span>
            <span>Conflict #{{ $importConflict->id }}</span>
        </div>

        <div class="import-conflict-show-header">
            <div>
                <h1 class="import-conflict-show-title">Conflict Detail Review</h1>
                <p class="import-conflict-show-subtitle">
                    Compare the imported row against the existing record before resolving the conflict.
                </p>
            </div>

            <div class="import-conflict-actions">
                <a href="{{ route('import-conflicts.index') }}" class="import-conflict-btn import-conflict-btn-secondary">
                    Back to Import Conflicts
                </a>
                @if($importConflict->importBatch)
                    <a href="{{ route('import-batches.show', $importConflict->importBatch) }}" class="import-conflict-btn import-conflict-btn-secondary">
                        Back to Batch Review
                    </a>
                @endif
                <a href="{{ route('import-conflicts.show', $importConflict) }}" class="import-conflict-btn import-conflict-btn-primary">
                    Refresh
                </a>
            </div>
        </div>

        <section class="import-conflict-hero">
            <div class="import-conflict-hero-top">
                <div>
                    <div class="import-conflict-hero-title">Conflict #{{ $importConflict->id }}</div>
                    <div class="import-conflict-hero-meta">
                        Batch #{{ $importConflict->import_batch_id }} | Source row {{ $importConflict->source_row_number ?? '-' }}
                    </div>
                </div>

                <div class="import-conflict-badge-row">
                    <span class="import-conflict-badge import-conflict-badge-{{ $statusClass($importConflict->status) }}">
                        {{ ucfirst($importConflict->status) }}
                    </span>
                    <span class="import-conflict-badge import-conflict-badge-{{ $conflictTypeClass($importConflict->conflict_type) }}">
                        {{ $conflictTypeLabel($importConflict->conflict_type) }}
                    </span>
                </div>
            </div>

            <div class="import-conflict-meta-grid">
                <div class="import-conflict-field-row">
                    <div class="import-conflict-field-label">Import Batch / File</div>
                    <div class="import-conflict-field-value">
                        #{{ $importConflict->import_batch_id }} - {{ $importConflict->importBatch->original_filename ?? '-' }}
                    </div>
                </div>
                <div class="import-conflict-field-row">
                    <div class="import-conflict-field-label">Sheet Name</div>
                    <div class="import-conflict-field-value">{{ $importConflict->importBatchSheet->sheet_name ?? '-' }}</div>
                </div>
                <div class="import-conflict-field-row">
                    <div class="import-conflict-field-label">Branch</div>
                    <div class="import-conflict-field-value">{{ $importConflict->branch->display_name ?? '-' }}</div>
                </div>
                <div class="import-conflict-field-row">
                    <div class="import-conflict-field-label">Detected / Updated</div>
                    <div class="import-conflict-field-value">
                        {{ $importConflict->created_at?->format('M d, Y h:i A') ?? '-' }} /
                        {{ $importConflict->updated_at?->format('M d, Y h:i A') ?? '-' }}
                    </div>
                </div>
            </div>
        </section>

        <section class="import-conflict-reminder-card">
            <div class="import-conflict-reminder-title">Review Reminder</div>
            <p class="import-conflict-reminder-text">
                Compare the imported row with the existing record before resolving. Only accept imported changes when the source workbook has been verified.
            </p>
        </section>

        <section class="import-conflict-comparison-grid">
            <article class="import-conflict-data-card">
                <div class="import-conflict-card-header">
                    <div>
                        <h2 class="import-conflict-card-title">Imported Row</h2>
                        <p class="import-conflict-card-subtitle">Incoming data detected during the import.</p>
                    </div>
                </div>
                <div class="import-conflict-card-body">
                    @if($comparison->isNotEmpty())
                        <div class="import-conflict-data-list">
                            @foreach($summaryFields as $field)
                                @php
                                    $row = $rowByLabel->get($field);
                                @endphp
                                <div class="import-conflict-data-row {{ ($row['changed'] ?? false) ? 'is-different' : '' }}">
                                    <div class="import-conflict-data-label">{{ $field }}</div>
                                    <div class="import-conflict-data-value">{{ $displayValue($row['incoming'] ?? null) }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="import-conflict-empty-state">Imported row details are unavailable.</div>
                    @endif
                </div>
            </article>

            <article class="import-conflict-data-card">
                <div class="import-conflict-card-header">
                    <div>
                        <h2 class="import-conflict-card-title">Existing / Current Record</h2>
                        <p class="import-conflict-card-subtitle">Current stored data this import row conflicts with.</p>
                    </div>
                </div>
                <div class="import-conflict-card-body">
                    @if($comparison->isNotEmpty())
                        <div class="import-conflict-data-list">
                            @foreach($summaryFields as $field)
                                @php
                                    $row = $rowByLabel->get($field);
                                @endphp
                                <div class="import-conflict-data-row {{ ($row['changed'] ?? false) ? 'is-different' : '' }}">
                                    <div class="import-conflict-data-label">{{ $field }}</div>
                                    <div class="import-conflict-data-value">{{ $displayValue($row['existing'] ?? null) }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="import-conflict-empty-state">Existing record details are unavailable.</div>
                    @endif
                </div>
            </article>
        </section>

        <section class="import-conflict-summary-grid">
            <article class="import-conflict-summary-card">
                <div class="import-conflict-card-body">
                    <div class="import-conflict-field-label">Changed Fields</div>
                    <div class="import-conflict-field-value" style="font-size: 1.35rem;">{{ number_format($changedCount) }}</div>
                    <div class="import-conflict-card-subtitle">{{ $firstChangedLabels ?: 'No changed fields detected.' }}</div>
                </div>
            </article>
            <article class="import-conflict-summary-card">
                <div class="import-conflict-card-body">
                    <div class="import-conflict-field-label">Missing Values</div>
                    <div class="import-conflict-field-value" style="font-size: 1.35rem;">{{ number_format($missingCount) }}</div>
                    <div class="import-conflict-card-subtitle">Blank values found across existing or imported data.</div>
                </div>
            </article>
            <article class="import-conflict-summary-card">
                <div class="import-conflict-card-body">
                    <div class="import-conflict-field-label">Unchanged Fields</div>
                    <div class="import-conflict-field-value" style="font-size: 1.35rem;">{{ number_format($sameCount) }}</div>
                    <div class="import-conflict-card-subtitle">Fields matching between imported and existing records.</div>
                </div>
            </article>
        </section>

        <div class="import-conflict-layout-grid">
            <section class="import-conflict-diff-card">
                <div class="import-conflict-card-header">
                    <div>
                        <h2 class="import-conflict-card-title">Difference Summary / Changed Fields</h2>
                        <p class="import-conflict-card-subtitle">Full field-by-field comparison from the current conflict payload.</p>
                    </div>
                </div>

                <div class="import-conflict-table-wrap">
                    <table class="import-conflict-comparison-table">
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
                                <tr class="{{ $row['changed'] ? 'is-different' : '' }}">
                                    <td>{{ $row['column'] }}</td>
                                    <td class="fw-semibold">{{ $row['label'] }}</td>
                                    <td>{{ $displayValue($row['existing'] ?? null) }}</td>
                                    <td>{{ $displayValue($row['incoming'] ?? null) }}</td>
                                    <td>
                                        @if($row['changed'])
                                            <span class="import-conflict-badge import-conflict-badge-warning">Changed</span>
                                        @else
                                            <span class="import-conflict-badge import-conflict-badge-secondary">Same</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="import-conflict-empty-state">Review the imported row and existing record comparison above.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="d-grid gap-3">
                <section class="import-conflict-actions-card">
                    <div class="import-conflict-card-header">
                        <div>
                            <h2 class="import-conflict-card-title">Resolution Actions</h2>
                            <p class="import-conflict-card-subtitle">Use the existing review actions after validating the row comparison.</p>
                        </div>
                    </div>
                    <div class="import-conflict-card-body">
                        @if($importConflict->conflict_type === 'related_account_conflict')
                            <div class="import-conflict-empty-state mb-3">
                                Use Apply Newest Data when the latest import corrects the existing sale. Use Import as Separate Transaction only when this is truly a different sale/customer.
                            </div>
                        @endif

                        <div class="import-conflict-action-stack">
                            @if(
                                $importConflict->status === 'pending'
                                    && !in_array($importConflict->conflict_type, ['missing_from_latest_import', 'data_quality_conflict'], true)
                                    && !empty($incomingData)
                            )
                                <form action="{{ route('import-conflicts.accept-update', $importConflict) }}" method="POST"
                                      onsubmit="return confirm('Apply incoming row data to the existing sales transaction?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="import-conflict-btn import-conflict-btn-primary w-100">
                                        Apply Newest Data / Accept Incoming Update
                                    </button>
                                </form>
                            @endif

                            @if(
                                $importConflict->status === 'pending'
                                    && $importConflict->conflict_type === 'related_account_conflict'
                                    && !empty($incomingData)
                                    && !($hasImportedIncomingTransaction ?? false)
                            )
                                <form action="{{ route('import-conflicts.import-separate', $importConflict) }}" method="POST"
                                      onsubmit="return confirm('Import this incoming row as a separate sales transaction?')">
                                    @csrf
                                    <button type="submit" class="import-conflict-btn import-conflict-btn-primary w-100">
                                        Import as Separate Transaction / Confirm as Separate Customer
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'reviewed')
                                <form action="{{ route('import-conflicts.mark-reviewed', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="import-conflict-btn import-conflict-btn-success w-100">
                                        Mark Reviewed
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'ignored')
                                <form action="{{ route('import-conflicts.mark-ignored', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="import-conflict-btn import-conflict-btn-secondary w-100">
                                        Mark Ignored
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'resolved')
                                <form action="{{ route('import-conflicts.mark-resolved', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="import-conflict-btn import-conflict-btn-info w-100">
                                        Mark Resolved
                                    </button>
                                </form>
                            @endif

                            @if($canDeleteImportConflict)
                                <form action="{{ route('import-conflicts.destroy', $importConflict) }}" method="POST"
                                      onsubmit="return confirm('Delete this conflict permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="import-conflict-btn import-conflict-btn-danger w-100">
                                        Delete Conflict
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="import-conflict-data-card">
                    <div class="import-conflict-card-header">
                        <div>
                            <h2 class="import-conflict-card-title">Source / Batch Context</h2>
                            <p class="import-conflict-card-subtitle">Batch, sheet, row, and uploader context for this conflict.</p>
                        </div>
                    </div>
                    <div class="import-conflict-card-body">
                        <div class="import-conflict-context-grid">
                            <div class="import-conflict-field-row">
                                <div class="import-conflict-field-label">Import Batch</div>
                                <div class="import-conflict-field-value">#{{ $importConflict->import_batch_id }}</div>
                            </div>
                            <div class="import-conflict-field-row">
                                <div class="import-conflict-field-label">Source Type</div>
                                <div class="import-conflict-field-value">{{ $importConflict->importBatch->source_type ?? '-' }}</div>
                            </div>
                            <div class="import-conflict-field-row">
                                <div class="import-conflict-field-label">Uploaded By</div>
                                <div class="import-conflict-field-value">{{ $importConflict->importBatch->user->name ?? '-' }}</div>
                            </div>
                            <div class="import-conflict-field-row">
                                <div class="import-conflict-field-label">Uploaded At</div>
                                <div class="import-conflict-field-value">{{ $importConflict->importBatch->created_at?->format('M d, Y h:i A') ?? '-' }}</div>
                            </div>
                            <div class="import-conflict-field-row">
                                <div class="import-conflict-field-label">Sheet Name</div>
                                <div class="import-conflict-field-value">{{ $importConflict->importBatchSheet->sheet_name ?? '-' }}</div>
                            </div>
                            <div class="import-conflict-field-row">
                                <div class="import-conflict-field-label">Source Row</div>
                                <div class="import-conflict-field-value">{{ $importConflict->source_row_number ?? '-' }}</div>
                            </div>
                            <div class="import-conflict-field-row">
                                <div class="import-conflict-field-label">Batch Status</div>
                                <div class="import-conflict-field-value">{{ ucfirst((string) ($importConflict->importBatch->status ?? '-')) }}</div>
                            </div>
                            <div class="import-conflict-field-row">
                                <div class="import-conflict-field-label">Batch Review</div>
                                <div class="import-conflict-field-value">
                                    @if($importConflict->importBatch)
                                        <a href="{{ route('import-batches.show', $importConflict->importBatch) }}">Open batch review</a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <section class="import-conflict-audit-card">
            <details>
                <summary>Show Technical Details</summary>
                <div class="import-conflict-technical-grid mt-3">
                    <div class="import-conflict-field-row">
                        <div class="import-conflict-field-label">Internal Conflict ID</div>
                        <div class="import-conflict-field-value">#{{ $importConflict->id }}</div>
                    </div>
                    <div class="import-conflict-field-row">
                        <div class="import-conflict-field-label">Raw Status</div>
                        <div class="import-conflict-field-value">{{ $importConflict->status ?? '-' }}</div>
                    </div>
                    <div class="import-conflict-field-row">
                        <div class="import-conflict-field-label">Raw Conflict Type</div>
                        <div class="import-conflict-field-value">{{ $importConflict->conflict_type ?? '-' }}</div>
                    </div>
                    <div class="import-conflict-field-row">
                        <div class="import-conflict-field-label">Created At</div>
                        <div class="import-conflict-field-value">{{ $importConflict->created_at?->format('M d, Y h:i A') ?? '-' }}</div>
                    </div>
                    <div class="import-conflict-field-row">
                        <div class="import-conflict-field-label">Updated At</div>
                        <div class="import-conflict-field-value">{{ $importConflict->updated_at?->format('M d, Y h:i A') ?? '-' }}</div>
                    </div>
                    <div class="import-conflict-field-row">
                        <div class="import-conflict-field-label">System Notes</div>
                        <div class="import-conflict-field-value">{{ $importConflict->notes ?? 'No additional technical metadata available.' }}</div>
                    </div>
                </div>
            </details>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const technicalDetails = document.querySelector('.import-conflict-audit-card details');
            if (technicalDetails) {
                const summary = technicalDetails.querySelector('summary');
                technicalDetails.addEventListener('toggle', function () {
                    if (summary) {
                        summary.textContent = technicalDetails.open ? 'Hide Technical Details' : 'Show Technical Details';
                    }
                });
            }
        });
    </script>
</x-app-layout>
