<x-app-layout>
    <style>
        body {
            background: #f4f7fb;
        }

        .import-show-page {
            max-width: 1600px;
            margin: 0 auto;
            padding-top: 6.5rem;
            color: #0f172a;
        }

        .import-show-breadcrumb {
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

        .import-show-breadcrumb a {
            color: #2563eb;
            text-decoration: none;
        }

        .import-show-breadcrumb a:hover,
        .import-show-breadcrumb a:focus {
            color: #1d4ed8;
            text-decoration: none;
        }

        .import-show-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
        }

        .import-show-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 900;
            line-height: 1.15;
        }

        .import-show-subtitle {
            margin: .4rem 0 0;
            color: #64748b;
            font-size: .92rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .import-show-actions,
        .import-action-stack {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: .55rem;
        }

        .import-show-btn {
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

        .import-show-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .import-show-btn-primary:hover,
        .import-show-btn-primary:focus {
            color: #ffffff;
            background: #1d4ed8;
            border-color: #1d4ed8;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .import-show-btn-secondary {
            color: #334155;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.14);
        }

        .import-show-btn-secondary:hover,
        .import-show-btn-secondary:focus {
            color: #0f172a;
            background: #f8fafc;
            border-color: rgba(15, 23, 42, 0.22);
            text-decoration: none;
        }

        .import-show-btn-success {
            color: #ffffff;
            background: #16a34a;
            border: 1px solid #16a34a;
            box-shadow: 0 8px 18px rgba(22, 163, 74, 0.14);
        }

        .import-show-btn-success:hover,
        .import-show-btn-success:focus {
            color: #ffffff;
            background: #15803d;
            border-color: #15803d;
            text-decoration: none;
        }

        .import-show-btn-danger {
            color: #991b1b;
            background: #ffffff;
            border: 1px solid rgba(239, 68, 68, 0.28);
        }

        .import-show-btn-danger:hover,
        .import-show-btn-danger:focus {
            color: #ffffff;
            background: #dc2626;
            border-color: #dc2626;
            text-decoration: none;
        }

        .import-show-btn:disabled,
        .import-show-btn.disabled {
            cursor: not-allowed;
            opacity: .62;
            transform: none;
            box-shadow: none;
        }

        .import-show-alert {
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            padding: .9rem 1rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .import-show-alert-success {
            background: #ecfdf5;
            border: 1px solid rgba(34, 197, 94, 0.22);
            color: #166534;
        }

        .import-show-alert-warning {
            background: #fffbeb;
            border: 1px solid rgba(245, 158, 11, 0.24);
            color: #92400e;
        }

        .import-show-alert-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            background: #eff6ff;
            border: 1px solid rgba(37, 99, 235, 0.18);
            color: #1e40af;
        }

        .import-batch-hero,
        .import-timeline-card,
        .import-review-card,
        .import-preview-card,
        .import-audit-card,
        .import-technical-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .import-batch-hero {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr);
            gap: 1rem;
            padding: 1.2rem;
            margin-bottom: 1.15rem;
        }

        .import-file-icon {
            width: 64px;
            height: 64px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
            border: 1px solid rgba(37, 99, 235, 0.14);
            color: #2563eb;
            font-size: 1.4rem;
            font-weight: 900;
        }

        .import-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: .85rem;
        }

        .import-file-name-large {
            color: #0f172a;
            font-size: 1.12rem;
            font-weight: 900;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .import-file-meta-line {
            color: #64748b;
            font-size: .82rem;
            font-weight: 700;
            margin-top: .22rem;
        }

        .import-meta-grid,
        .import-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .85rem;
        }

        .import-info-grid {
            margin-bottom: 1.15rem;
        }

        .import-detail-item {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: .9rem;
            background: #f8fafc;
            padding: .85rem;
            min-width: 0;
        }

        .import-detail-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .import-detail-value {
            color: #0f172a;
            font-size: .9rem;
            font-weight: 850;
            line-height: 1.35;
            margin-top: .32rem;
            overflow-wrap: anywhere;
        }

        .import-health-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: .85rem;
            margin-bottom: 1.15rem;
        }

        .import-health-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.055);
            padding: 1rem;
            min-width: 0;
        }

        .import-health-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .import-health-value {
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 900;
            line-height: 1.1;
            margin-top: .45rem;
        }

        .import-health-meta {
            color: #64748b;
            font-size: .78rem;
            font-weight: 600;
            line-height: 1.4;
            margin-top: .35rem;
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

        .import-card-body {
            padding: 1.1rem;
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

        .import-timeline-card {
            margin-bottom: 1.15rem;
        }

        .import-timeline {
            display: grid;
            grid-template-columns: repeat(6, minmax(130px, 1fr));
            gap: .75rem;
            min-width: 880px;
        }

        .import-timeline-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: .1rem;
        }

        .timeline-step {
            position: relative;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: .95rem;
            background: #f8fafc;
            padding: .85rem;
            min-height: 112px;
        }

        .timeline-step::before {
            content: "";
            position: absolute;
            top: 1.15rem;
            left: -.78rem;
            width: .78rem;
            height: 3px;
            background: #e5e7eb;
        }

        .timeline-step:first-child::before {
            display: none;
        }

        .timeline-step.is-complete {
            background: #f0fdf4;
            border-color: rgba(34, 197, 94, 0.22);
        }

        .timeline-step.is-active {
            background: #eff6ff;
            border-color: rgba(37, 99, 235, 0.28);
        }

        .timeline-step.is-active::before {
            background: linear-gradient(90deg, rgba(37, 99, 235, .18), rgba(37, 99, 235, .65), rgba(37, 99, 235, .18));
            background-size: 200% 100%;
            animation: importTimelineShimmer 1.4s linear infinite;
        }

        .timeline-step.is-failed {
            background: #fef2f2;
            border-color: rgba(239, 68, 68, 0.22);
        }

        .timeline-dot {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            color: #64748b;
            background: #e5e7eb;
            font-size: .78rem;
            font-weight: 900;
            margin-bottom: .65rem;
        }

        .timeline-step.is-complete .timeline-dot {
            color: #ffffff;
            background: #16a34a;
        }

        .timeline-step.is-active .timeline-dot {
            color: #ffffff;
            background: #2563eb;
            animation: importTimelinePulse 1.45s ease-in-out infinite;
        }

        .timeline-step.is-failed .timeline-dot {
            color: #ffffff;
            background: #dc2626;
        }

        .timeline-title {
            color: #0f172a;
            font-size: .82rem;
            font-weight: 900;
            line-height: 1.25;
        }

        .timeline-meta {
            color: #64748b;
            font-size: .75rem;
            font-weight: 650;
            line-height: 1.4;
            margin-top: .3rem;
        }

        @keyframes importTimelinePulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, .22);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(37, 99, 235, 0);
            }
        }

        @keyframes importTimelineShimmer {
            from {
                background-position: 200% 0;
            }
            to {
                background-position: -200% 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .timeline-step.is-active .timeline-dot,
            .timeline-step.is-active::before {
                animation: none;
            }
        }

        .import-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .import-sheet-table,
        .import-preview-table,
        .import-audit-table {
            width: 100%;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .import-sheet-table {
            min-width: 1120px;
        }

        .import-preview-table {
            min-width: 1040px;
        }

        .import-audit-table {
            min-width: 680px;
        }

        .import-sheet-table thead th,
        .import-preview-table thead th,
        .import-audit-table thead th {
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

        .import-sheet-table tbody td,
        .import-preview-table tbody td,
        .import-audit-table tbody td {
            padding: .88rem .78rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: .84rem;
            vertical-align: middle;
        }

        .import-sheet-table tbody tr:nth-child(even) td,
        .import-preview-table tbody tr:nth-child(even) td,
        .import-audit-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .import-sheet-table tbody tr:hover td,
        .import-preview-table tbody tr:hover td,
        .import-audit-table tbody tr:hover td {
            background: #f3f4f6;
        }

        .numeric {
            text-align: right;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .import-empty-state {
            padding: 2.4rem 1.5rem;
            text-align: center;
            color: #64748b;
        }

        .import-empty-title {
            color: #0f172a;
            font-size: 1.05rem;
            font-weight: 900;
            margin-bottom: .35rem;
        }

        .import-note {
            color: #64748b;
            font-size: .84rem;
            font-weight: 650;
            line-height: 1.5;
        }

        .import-quality-message {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: .95rem;
            padding: .9rem;
            background: #f8fafc;
            color: #475569;
            font-size: .86rem;
            font-weight: 700;
            line-height: 1.5;
        }

        .import-quality-message.clean {
            color: #166534;
            background: #f0fdf4;
            border-color: rgba(34, 197, 94, 0.22);
        }

        .import-quality-message.review {
            color: #92400e;
            background: #fffbeb;
            border-color: rgba(245, 158, 11, 0.24);
        }

        .import-technical-card details {
            padding: 1rem 1.1rem;
        }

        .import-technical-card summary {
            cursor: pointer;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
            list-style: none;
        }

        .import-technical-card summary::-webkit-details-marker {
            display: none;
        }

        .import-technical-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .85rem;
            margin-top: 1rem;
        }

        .page-loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.28);
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
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18);
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .page-loading-spinner {
            width: 56px;
            height: 56px;
            margin: 0 auto 1rem;
            border: 5px solid #dbeafe;
            border-top-color: #2563eb;
            border-radius: 50%;
            animation: pageSpin 0.9s linear infinite;
        }

        .page-loading-title {
            color: #0f172a;
            font-size: 1.1rem;
            font-weight: 900;
            margin-bottom: .35rem;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .page-loading-text {
            color: #64748b;
            font-size: .95rem;
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

        @media (max-width: 1199.98px) {
            .import-health-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .import-info-grid,
            .import-technical-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .import-show-page {
                padding-top: 5.75rem;
            }

            .import-show-header,
            .import-card-header,
            .import-hero-top,
            .import-show-alert-info {
                align-items: stretch;
                flex-direction: column;
            }

            .import-show-actions,
            .import-action-stack {
                width: 100%;
            }

            .import-show-actions .import-show-btn,
            .import-action-stack .import-show-btn,
            .import-action-stack form,
            .import-action-stack button {
                width: 100%;
            }

            .import-batch-hero {
                grid-template-columns: 1fr;
            }

            .import-meta-grid,
            .import-health-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @php
        $statusClass = function ($status) {
            return match (strtolower((string) $status)) {
                'processed', 'completed', 'success', 'parsed', 'imported' => 'success',
                'processing', 'parsing', 'in_progress' => 'info',
                'uploaded', 'pending', 'queued', 'draft' => 'warning',
                'failed', 'error', 'rejected' => 'danger',
                default => 'secondary',
            };
        };

        $formatStatus = fn ($status) => filled($status) ? ucfirst(str_replace('_', ' ', (string) $status)) : 'Unknown';
        $money = fn ($value) => filled($value) ? 'PHP ' . number_format((float) $value, 2) : '-';
        $dateTime = fn ($value) => $value ? $value->format('M d, Y h:i A') : '-';
        $dateOnly = fn ($value) => $value ? $value->format('M d, Y') : '-';

        $autoRefreshStatuses = ['queued', 'processing'];
        $batchStatus = strtolower((string) $importBatch->status);
        $batchIsBusy = in_array($batchStatus, $autoRefreshStatuses, true);
        $batchHasFailed = in_array($batchStatus, ['failed', 'error', 'rejected'], true);
        $batchIsComplete = in_array($batchStatus, ['processed', 'completed', 'success', 'parsed', 'imported'], true);

        $shouldAutoRefresh =
            $batchIsBusy
            || $importBatch->sheets->contains(function ($sheet) use ($autoRefreshStatuses) {
                return in_array(strtolower((string) $sheet->status), $autoRefreshStatuses, true);
            });

        $hasParseableSheets = $importBatch->sheets->contains(function ($sheet) {
            return $sheet->sheet_type === 'transaction'
                && in_array(strtolower((string) $sheet->status), ['pending', 'failed'], true);
        });

        $conflictCount = (int) ($importBatch->conflict_rows ?? 0);
        $missingConflictCount = (int) ($missingFromLatestConflictCount ?? 0);
        $hasReviewableLatestRows = ($hasImportedTransactions ?? false) || ($hasTransactionSheetActivity ?? false);
        $errorCount = $importBatch->errors->count();
        $skippedRows = (int) ($importBatch->skipped_rows ?? 0);
        $invalidRows = (int) ($importBatch->invalid_rows ?? 0);
        $duplicateRows = (int) ($importBatch->duplicate_rows ?? 0);
        $hasQualityIssues = $conflictCount > 0 || $errorCount > 0 || $skippedRows > 0 || $invalidRows > 0 || $duplicateRows > 0;
        $canAccessImportConflicts = auth()->user()?->hasAnyRole(['super_admin', 'admin', 'importer']);
        $canResetImportBatchSheets = auth()->user()?->hasAnyRole(['super_admin', 'admin']);
        $canRunMissingReview = auth()->user()?->hasAnyRole(['super_admin', 'admin', 'importer'])
            && $batchStatus === 'imported'
            && $hasReviewableLatestRows
            && ! $batchIsBusy;

        $timelineSteps = [
            ['key' => 'uploaded', 'label' => 'Uploaded', 'meta' => 'Batch file registered.'],
            ['key' => 'opened', 'label' => 'Workbook Opened', 'meta' => 'Workbook scanned by importer.'],
            ['key' => 'detected', 'label' => 'Sheets Detected', 'meta' => number_format((int) $importBatch->total_sheets) . ' sheet(s) found.'],
            ['key' => 'parsed', 'label' => 'Rows Parsed', 'meta' => number_format((int) $importBatch->valid_rows) . ' valid row(s).'],
            ['key' => 'checked', 'label' => 'Conflicts Checked', 'meta' => number_format($conflictCount) . ' conflict row(s).'],
            ['key' => 'imported', 'label' => 'Transactions Imported', 'meta' => number_format((int) $importBatch->imported_rows) . ' imported row(s).'],
        ];

        $completedStepCount = 1;
        if ((int) $importBatch->total_sheets > 0 || $importBatch->sheets->isNotEmpty()) $completedStepCount = 3;
        if ((int) $importBatch->valid_rows > 0 || (int) $importBatch->invalid_rows > 0 || (int) $importBatch->skipped_rows > 0) $completedStepCount = 4;
        if ($conflictCount > 0 || $duplicateRows > 0 || $batchIsComplete || (int) $importBatch->imported_rows > 0) $completedStepCount = 5;
        if ($batchIsComplete || (int) $importBatch->imported_rows > 0) $completedStepCount = 6;
        if ($batchHasFailed) $completedStepCount = max(1, min($completedStepCount, 4));
        $activeStep = $batchHasFailed ? $completedStepCount : min($completedStepCount + ($batchIsComplete ? 0 : 1), count($timelineSteps));
    @endphp

    <div class="import-show-page px-3 px-md-4 py-4">
        @if(session('success'))
            <div class="import-show-alert import-show-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="import-show-alert import-show-alert-warning">
                {{ session('warning') }}
                @if(session('warning_detail'))
                    <div class="small mt-1 fw-semibold">{{ session('warning_detail') }}</div>
                @endif
            </div>
        @endif

        <div class="import-show-breadcrumb">
            <a href="{{ route('import-batches.index') }}">Import Batches</a>
            <span>/</span>
            <span>Batch #{{ $importBatch->id }}</span>
        </div>

        <div class="import-show-header">
            <div>
                <h1 class="import-show-title">Import Batch Review</h1>
                <p class="import-show-subtitle">
                    Review uploaded workbook details, processing results, detected sheets, and imported records.
                </p>
            </div>

            <div class="import-show-actions">
                <a href="{{ route('import-batches.index') }}" class="import-show-btn import-show-btn-secondary">
                    Back to Import Batches
                </a>
                <a href="{{ route('sales-transactions.index', ['import_batch_id' => $importBatch->id]) }}" class="import-show-btn import-show-btn-primary">
                    View Imported Transactions
                </a>
                @if($canAccessImportConflicts && $conflictCount > 0)
                    <a href="{{ route('import-conflicts.index') }}" class="import-show-btn import-show-btn-secondary">
                        Review Conflicts
                    </a>
                @endif
            </div>
        </div>

        @if($shouldAutoRefresh)
            <div class="import-show-alert import-show-alert-info">
                <div>
                    <strong>Import is currently {{ $formatStatus($importBatch->status) }}.</strong>
                    <div class="small">
                        This page will refresh automatically every 5 seconds until processing is finished.
                    </div>
                </div>
                <div class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></div>
            </div>
        @endif

        <section class="import-batch-hero">
            <div class="import-file-icon">XLS</div>
            <div>
                <div class="import-hero-top">
                    <div>
                        <div class="import-file-name-large">{{ $importBatch->original_filename }}</div>
                        <div class="import-file-meta-line">
                            Batch #{{ $importBatch->id }} | Source {{ $importBatch->source_type ?? '-' }}
                        </div>
                    </div>
                    <span class="import-status-badge import-status-{{ $statusClass($importBatch->status) }}">
                        {{ $formatStatus($importBatch->status) }}
                    </span>
                </div>

                <div class="import-meta-grid">
                    <div class="import-detail-item">
                        <div class="import-detail-label">Uploaded By</div>
                        <div class="import-detail-value">{{ $importBatch->user->name ?? '-' }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Uploaded At</div>
                        <div class="import-detail-value">{{ $dateTime($importBatch->created_at) }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Processed / Imported At</div>
                        <div class="import-detail-value">{{ $dateTime($importBatch->imported_at) }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Notes</div>
                        <div class="import-detail-value">{{ filled($importBatch->notes) ? $importBatch->notes : '-' }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="import-health-grid">
            <article class="import-health-card">
                <div class="import-health-label">Total Sheets</div>
                <div class="import-health-value">{{ number_format((int) $importBatch->total_sheets) }}</div>
                <div class="import-health-meta">Workbook sheets detected</div>
            </article>
            <article class="import-health-card">
                <div class="import-health-label">Detected Sheets</div>
                <div class="import-health-value">{{ number_format($importBatch->sheets->count()) }}</div>
                <div class="import-health-meta">Tracked sheet records</div>
            </article>
            <article class="import-health-card">
                <div class="import-health-label">Imported Records</div>
                <div class="import-health-value">{{ number_format((int) $importBatch->imported_rows) }}</div>
                <div class="import-health-meta">Rows imported into sales</div>
            </article>
            <article class="import-health-card">
                <div class="import-health-label">Conflicts</div>
                <div class="import-health-value">{{ number_format($conflictCount) }}</div>
                <div class="import-health-meta">Rows requiring review</div>
            </article>
            <article class="import-health-card">
                <div class="import-health-label">Errors</div>
                <div class="import-health-value">{{ number_format($errorCount) }}</div>
                <div class="import-health-meta">Validation/parser issues</div>
            </article>
            <article class="import-health-card">
                <div class="import-health-label">Skipped Rows</div>
                <div class="import-health-value">{{ number_format($skippedRows) }}</div>
                <div class="import-health-meta">Rows not imported</div>
            </article>
        </section>

        <section class="import-timeline-card">
            <div class="import-card-header">
                <div>
                    <h2 class="import-card-title">Processing Timeline</h2>
                    <p class="import-card-subtitle">
                        Upload, sheet detection, parsing, conflict checks, and transaction import status.
                    </p>
                </div>
            </div>
            <div class="import-card-body">
                <div class="import-timeline-wrap">
                    <div class="import-timeline">
                        @foreach($timelineSteps as $index => $step)
                            @php
                                $stepNumber = $index + 1;
                                $stepState = $batchHasFailed && $stepNumber === $activeStep
                                    ? 'is-failed'
                                    : ($stepNumber <= $completedStepCount ? 'is-complete' : ($stepNumber === $activeStep && ! $batchIsComplete ? 'is-active' : 'is-pending'));
                            @endphp
                            <article class="timeline-step {{ $stepState }}">
                                <div class="timeline-dot">
                                    @if($stepState === 'is-complete')
                                        ✓
                                    @elseif($stepState === 'is-failed')
                                        !
                                    @else
                                        {{ $stepNumber }}
                                    @endif
                                </div>
                                <div class="timeline-title">{{ $step['label'] }}</div>
                                <div class="timeline-meta">{{ $step['meta'] }}</div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <div class="import-info-grid">
            <section class="import-review-card">
                <div class="import-card-header">
                    <div>
                        <h2 class="import-card-title">Workbook Information</h2>
                        <p class="import-card-subtitle">File metadata and processing totals for this uploaded workbook.</p>
                    </div>
                </div>
                <div class="import-card-body">
                    <div class="import-meta-grid">
                        <div class="import-detail-item">
                            <div class="import-detail-label">Original File Name</div>
                            <div class="import-detail-value">{{ $importBatch->original_filename }}</div>
                        </div>
                        <div class="import-detail-item">
                            <div class="import-detail-label">Stored File</div>
                            <div class="import-detail-value">{{ $importBatch->stored_filename ?? '-' }}</div>
                        </div>
                        <div class="import-detail-item">
                            <div class="import-detail-label">Source Type</div>
                            <div class="import-detail-value">{{ $importBatch->source_type ?? '-' }}</div>
                        </div>
                        <div class="import-detail-item">
                            <div class="import-detail-label">Upload Date</div>
                            <div class="import-detail-value">{{ $dateTime($importBatch->created_at) }}</div>
                        </div>
                        <div class="import-detail-item">
                            <div class="import-detail-label">Imported / Processed Date</div>
                            <div class="import-detail-value">{{ $dateTime($importBatch->imported_at) }}</div>
                        </div>
                        <div class="import-detail-item">
                            <div class="import-detail-label">Supported Sheets</div>
                            <div class="import-detail-value">{{ number_format((int) $importBatch->supported_sheets) }}</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="import-review-card">
                <div class="import-card-header">
                    <div>
                        <h2 class="import-card-title">Data Quality Review</h2>
                        <p class="import-card-subtitle">Conflicts, errors, duplicates, invalid rows, and skipped rows.</p>
                    </div>
                </div>
                <div class="import-card-body">
                    <div class="import-meta-grid mb-3">
                        <div class="import-detail-item">
                            <div class="import-detail-label">Conflicts Found</div>
                            <div class="import-detail-value">{{ number_format($conflictCount) }}</div>
                        </div>
                        <div class="import-detail-item">
                            <div class="import-detail-label">Duplicate Candidates</div>
                            <div class="import-detail-value">{{ number_format($duplicateRows) }}</div>
                        </div>
                        <div class="import-detail-item">
                            <div class="import-detail-label">Invalid / Error Rows</div>
                            <div class="import-detail-value">{{ number_format($invalidRows + $errorCount) }}</div>
                        </div>
                        <div class="import-detail-item">
                            <div class="import-detail-label">Skipped Rows</div>
                            <div class="import-detail-value">{{ number_format($skippedRows) }}</div>
                        </div>
                    </div>

                    @if($hasQualityIssues)
                        <div class="import-quality-message review">
                            This batch has records that need review before relying on the imported data.
                            @if($canAccessImportConflicts && $conflictCount > 0)
                                <div class="mt-3">
                                    <a href="{{ route('import-conflicts.index') }}" class="import-show-btn import-show-btn-secondary">
                                        Review Conflicts
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="import-quality-message clean">
                            No data quality issues detected for this batch.
                        </div>
                    @endif
                </div>
            </section>
        </div>

        <section class="import-review-card mb-3">
            <div class="import-card-header">
                <div>
                    <h2 class="import-card-title">Missing From Latest Import Review</h2>
                    <p class="import-card-subtitle">
                        Flags previous transactions that are not present in this latest comparable import. This does not delete or change sales totals.
                    </p>
                </div>
                <div class="import-action-stack">
                    <form action="{{ route('import-batches.check-missing-from-latest', $importBatch) }}" method="POST"
                        onsubmit="return confirm('Check this batch against the previous comparable import? This creates audit-only review flags and does not change sales totals.')">
                        @csrf
                        <button type="submit" class="import-show-btn import-show-btn-primary" @disabled(! $canRunMissingReview)>
                            Check Missing From Previous Import
                        </button>
                    </form>
                </div>
            </div>
            <div class="import-card-body">
                <div class="import-meta-grid">
                    <div class="import-detail-item">
                        <div class="import-detail-label">Missing Review Flags</div>
                        <div class="import-detail-value">{{ number_format($missingConflictCount) }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Review Status</div>
                        <div class="import-detail-value">{{ $canRunMissingReview ? 'Ready to scan' : 'Unavailable' }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Latest Row Source</div>
                        <div class="import-detail-value">{{ $hasReviewableLatestRows ? 'Available' : 'None found' }}</div>
                    </div>
                </div>

                <div class="import-quality-message review mt-3">
                    This is an audit-only review. Missing flags do not remove transactions, hide transactions, or change dashboard/report totals.
                    @if($canAccessImportConflicts && $missingConflictCount > 0)
                        <div class="mt-3">
                            <a href="{{ route('import-conflicts.index', ['import_batch_id' => $importBatch->id, 'status' => 'all']) }}" class="import-show-btn import-show-btn-secondary">
                                Review Missing Flags
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="import-review-card mb-3">
            <div class="import-card-header">
                <div>
                    <h2 class="import-card-title">Detected Sheet Breakdown</h2>
                    <p class="import-card-subtitle">Detected sheets, branch mapping, row counts, conflicts, and available actions.</p>
                </div>
                <div class="import-action-stack">
                    <form action="{{ route('import-batches.parse-all', $importBatch) }}"
                        method="POST"
                        data-loading="true"
                        data-loading-message="Parsing all transaction sheets. Please wait...">
                        @csrf
                        <button type="submit"
                            class="import-show-btn import-show-btn-success"
                            @disabled($batchIsBusy || ! $hasParseableSheets)>
                            @if($batchIsBusy)
                                Processing...
                            @elseif(! $hasParseableSheets)
                                No Sheets to Parse
                            @else
                                Parse All Transaction Sheets
                            @endif
                        </button>
                    </form>
                </div>
            </div>

            <div class="import-table-wrap">
                <table class="import-sheet-table">
                    <thead>
                        <tr>
                            <th>Sheet Name</th>
                            <th>Type</th>
                            <th>Detected Branch</th>
                            <th>Rows Found</th>
                            <th>Rows Imported</th>
                            <th>Valid</th>
                            <th>Skipped</th>
                            <th>Duplicate</th>
                            <th>Conflicts</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th style="min-width: 170px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($importBatch->sheets as $sheet)
                            @php
                                $sheetStatus = strtolower((string) $sheet->status);
                                $canParseSheet = $sheet->sheet_type === 'transaction' && in_array($sheetStatus, ['pending', 'failed'], true);
                                $isSheetBusy = in_array($sheetStatus, ['queued', 'processing'], true);
                                $isSheetImported = $sheetStatus === 'imported';
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $sheet->sheet_name }}</td>
                                <td>{{ $formatStatus($sheet->sheet_type) }}</td>
                                <td>{{ $sheet->branch->display_name ?? '-' }}</td>
                                <td class="numeric">{{ number_format((int) $sheet->total_rows) }}</td>
                                <td class="numeric">{{ number_format((int) $sheet->imported_rows) }}</td>
                                <td class="numeric">{{ number_format((int) $sheet->valid_rows) }}</td>
                                <td class="numeric">{{ number_format((int) $sheet->skipped_rows) }}</td>
                                <td class="numeric">{{ number_format((int) $sheet->duplicate_rows) }}</td>
                                <td class="numeric">{{ number_format((int) $sheet->conflict_rows) }}</td>
                                <td>
                                    <span class="import-status-badge import-status-{{ $statusClass($sheet->status) }}">
                                        {{ $formatStatus($sheet->status) }}
                                    </span>
                                </td>
                                <td>{{ $sheet->notes ?? '-' }}</td>
                                <td>
                                    @if($sheet->sheet_type === 'transaction')
                                        <div class="import-action-stack justify-content-start">
                                            <a href="{{ route('import-batches.sheets.preview', [$importBatch, $sheet]) }}"
                                                class="import-show-btn import-show-btn-secondary">
                                                Preview
                                            </a>

                                            @if($canParseSheet)
                                                <form action="{{ route('import-batches.sheets.parse', [$importBatch, $sheet]) }}"
                                                    method="POST"
                                                    data-loading="true"
                                                    data-loading-message="Parsing selected sheet. Please wait...">
                                                    @csrf
                                                    <button type="submit" class="import-show-btn import-show-btn-success">
                                                        Parse
                                                    </button>
                                                </form>
                                            @elseif($isSheetBusy)
                                                <button type="button" class="import-show-btn import-show-btn-secondary" disabled>
                                                    Processing
                                                </button>
                                            @elseif($isSheetImported)
                                                <button type="button" class="import-show-btn import-show-btn-secondary" disabled>
                                                    Imported
                                                </button>
                                            @endif

                                            @if($canResetImportBatchSheets)
                                                <form action="{{ route('import-batch-sheets.reset', $sheet) }}"
                                                    method="POST"
                                                    data-loading="true"
                                                    data-loading-message="Resetting parsed sheet data. Please wait..."
                                                    onsubmit="return confirm('Reset parsed data for this sheet?')">
                                                    @csrf
                                                    <button type="submit" class="import-show-btn import-show-btn-danger">
                                                        Reset
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="p-0">
                                    <div class="import-empty-state">
                                        <div class="import-empty-title">No sheet records yet</div>
                                        <div>No sheet tracking records are available for this batch.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="import-preview-card mb-3">
            <div class="import-card-header">
                <div>
                    <h2 class="import-card-title">Imported Transactions Preview</h2>
                    <p class="import-card-subtitle">Latest imported sales transactions linked to this batch.</p>
                </div>
                <a href="{{ route('sales-transactions.index', ['import_batch_id' => $importBatch->id]) }}" class="import-show-btn import-show-btn-secondary">
                    View All Transactions
                </a>
            </div>

            <div class="import-table-wrap">
                <table class="import-preview-table">
                    <thead>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Branch</th>
                            <th>Customer</th>
                            <th>Product / Model</th>
                            <th>Cash</th>
                            <th>PN Amount</th>
                            <th>Gross Sales</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($importedTransactions as $transaction)
                            @php
                                $productLabel = collect([
                                    $transaction->model,
                                    $transaction->product,
                                    $transaction->product_description,
                                    $transaction->parts_number,
                                ])->first(fn ($value) => filled($value));
                            @endphp
                            <tr>
                                <td>{{ $dateOnly($transaction->invoice_date) }}</td>
                                <td>{{ $transaction->branch->display_name ?? $transaction->branch_name_from_sheet ?? '-' }}</td>
                                <td>{{ $transaction->customer_name ?? '-' }}</td>
                                <td>{{ $productLabel ?? '-' }}</td>
                                <td class="numeric">{{ $money($transaction->cash_amount) }}</td>
                                <td class="numeric">{{ $money($transaction->promissory_note_amount) }}</td>
                                <td class="numeric">{{ $money($transaction->gross_sales_amount ?? $transaction->srp_cod_amount ?? $transaction->amount) }}</td>
                                <td>
                                    <a href="{{ route('sales-transactions.show', $transaction) }}" class="import-show-btn import-show-btn-secondary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-0">
                                    <div class="import-empty-state">
                                        <div class="import-empty-title">No imported transactions yet</div>
                                        <div>No sales transactions are linked to this import batch yet.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="import-audit-card mb-3">
            <div class="import-card-header">
                <div>
                    <h2 class="import-card-title">Audit Trail</h2>
                    <p class="import-card-subtitle">Key lifecycle timestamps and system notes for this batch.</p>
                </div>
            </div>
            <div class="import-table-wrap">
                <table class="import-audit-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Value</th>
                            <th>Context</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Batch Created</td>
                            <td>{{ $dateTime($importBatch->created_at) }}</td>
                            <td>Initial uploaded batch record</td>
                        </tr>
                        <tr>
                            <td>Processing Completed</td>
                            <td>{{ $dateTime($importBatch->imported_at) }}</td>
                            <td>Imported/processed timestamp when available</td>
                        </tr>
                        <tr>
                            <td>Last Updated</td>
                            <td>{{ $dateTime($importBatch->updated_at) }}</td>
                            <td>Latest system change on this batch record</td>
                        </tr>
                        <tr>
                            <td>Uploaded By</td>
                            <td>{{ $importBatch->user->name ?? '-' }}</td>
                            <td>{{ $importBatch->user->email ?? 'Uploader account' }}</td>
                        </tr>
                        <tr>
                            <td>System Notes</td>
                            <td>{{ filled($importBatch->notes) ? $importBatch->notes : '-' }}</td>
                            <td>Batch note captured during upload</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="import-audit-card mb-3">
            <div class="import-card-header">
                <div>
                    <h2 class="import-card-title">Import Errors</h2>
                    <p class="import-card-subtitle">Validation or parsing issues recorded during import processing.</p>
                </div>
            </div>
            <div class="import-table-wrap">
                <table class="import-audit-table">
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
                                    <div class="import-empty-state">
                                        <div class="import-empty-title">No import errors recorded</div>
                                        <div>No validation or parsing errors have been recorded for this batch.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="import-technical-card">
            <details>
                <summary>Show Technical Details</summary>
                <div class="import-technical-grid">
                    <div class="import-detail-item">
                        <div class="import-detail-label">Internal Batch ID</div>
                        <div class="import-detail-value">#{{ $importBatch->id }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Raw Status Value</div>
                        <div class="import-detail-value">{{ $importBatch->status ?? '-' }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Source Type</div>
                        <div class="import-detail-value">{{ $importBatch->source_type ?? '-' }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Created Timestamp</div>
                        <div class="import-detail-value">{{ $dateTime($importBatch->created_at) }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Updated Timestamp</div>
                        <div class="import-detail-value">{{ $dateTime($importBatch->updated_at) }}</div>
                    </div>
                    <div class="import-detail-item">
                        <div class="import-detail-label">Stored Filename</div>
                        <div class="import-detail-value">{{ $importBatch->stored_filename ?? '-' }}</div>
                    </div>
                </div>
            </details>
        </section>
    </div>

    <div id="pageLoadingOverlay" class="page-loading-overlay d-none">
        <div class="page-loading-box">
            <div class="page-loading-spinner"></div>
            <div class="page-loading-title">Processing Request</div>
            <div class="page-loading-text">
                Please wait while the system processes the request.
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
                        if (btn.tagName === 'BUTTON') {
                            btn.innerHTML = 'Processing...';
                        }
                    });
                });
            });

            const technicalDetails = document.querySelector('.import-technical-card details');
            if (technicalDetails) {
                const summary = technicalDetails.querySelector('summary');
                technicalDetails.addEventListener('toggle', function () {
                    if (summary) {
                        summary.textContent = technicalDetails.open ? 'Hide Technical Details' : 'Show Technical Details';
                    }
                });
            }

            @if($shouldAutoRefresh)
                setTimeout(function () {
                    window.location.reload();
                }, 5000);
            @endif
        });
    </script>
</x-app-layout>
