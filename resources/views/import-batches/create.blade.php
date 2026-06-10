<x-app-layout>
    <style>
        body {
            background: #f4f7fb;
        }

        .import-create-page {
            max-width: 1440px;
            margin: 0 auto;
            padding-top: 6.5rem;
            color: #0f172a;
        }

        .import-create-breadcrumb {
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

        .import-create-breadcrumb a {
            color: #2563eb;
            text-decoration: none;
        }

        .import-create-breadcrumb a:hover,
        .import-create-breadcrumb a:focus {
            color: #1d4ed8;
            text-decoration: none;
        }

        .import-create-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
        }

        .import-create-title {
            margin: 0;
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 900;
            line-height: 1.15;
        }

        .import-create-subtitle {
            margin: .4rem 0 0;
            color: #64748b;
            font-size: .92rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .import-create-actions,
        .import-form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: .55rem;
        }

        .import-create-btn {
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

        .import-create-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .import-create-btn-primary:hover,
        .import-create-btn-primary:focus {
            color: #ffffff;
            background: #1d4ed8;
            border-color: #1d4ed8;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .import-create-btn-secondary {
            color: #334155;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.14);
        }

        .import-create-btn-secondary:hover,
        .import-create-btn-secondary:focus {
            color: #0f172a;
            background: #f8fafc;
            border-color: rgba(15, 23, 42, 0.22);
            text-decoration: none;
        }

        .import-create-btn:active {
            transform: translateY(0);
        }

        .import-create-alert,
        .import-create-errors {
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            padding: .9rem 1rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .import-create-alert {
            background: #ecfdf5;
            border: 1px solid rgba(34, 197, 94, 0.22);
            color: #166534;
        }

        .import-create-errors {
            background: #fef2f2;
            border: 1px solid rgba(239, 68, 68, 0.22);
            color: #991b1b;
        }

        .import-create-errors ul {
            margin: .35rem 0 0;
            padding-left: 1.1rem;
            font-weight: 700;
        }

        .import-create-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(320px, .75fr);
            gap: 1.15rem;
            align-items: start;
        }

        .import-upload-card,
        .import-helper-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .import-create-card-header {
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .import-create-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
        }

        .import-create-card-subtitle {
            margin: .25rem 0 0;
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .import-create-form {
            padding: 1.1rem;
        }

        .import-create-field {
            margin-bottom: 1rem;
        }

        .import-create-label {
            display: block;
            color: #334155;
            font-size: .76rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .45rem;
        }

        .import-create-input,
        .import-create-textarea {
            width: 100%;
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: .85rem;
            background: #ffffff;
            color: #0f172a;
            font-size: .9rem;
            font-weight: 700;
            padding: .72rem .85rem;
            box-shadow: none;
        }

        .import-create-input:focus,
        .import-create-textarea:focus {
            border-color: rgba(37, 99, 235, 0.45);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, 0.08);
            outline: 0;
        }

        .import-upload-zone {
            border: 2px dashed rgba(37, 99, 235, 0.28);
            border-radius: 1rem;
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
            padding: 1.2rem;
        }

        .import-upload-zone-title {
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
            margin-bottom: .25rem;
        }

        .import-upload-zone-text {
            color: #64748b;
            font-size: .85rem;
            font-weight: 600;
            line-height: 1.45;
            margin-bottom: .85rem;
        }

        .import-upload-zone .import-create-input {
            background: #ffffff;
        }

        .import-create-help {
            color: #64748b;
            font-size: .78rem;
            font-weight: 600;
            line-height: 1.45;
            margin-top: .4rem;
        }

        .import-create-error {
            display: block;
            margin-top: .4rem;
            color: #dc2626;
            font-size: .8rem;
            font-weight: 800;
        }

        .import-helper-stack {
            display: grid;
            gap: .9rem;
        }

        .import-helper-card {
            padding: 1rem;
        }

        .import-helper-label {
            color: #64748b;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .import-helper-title {
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
            margin-top: .35rem;
        }

        .import-helper-text {
            color: #64748b;
            font-size: .84rem;
            font-weight: 600;
            line-height: 1.5;
            margin: .45rem 0 0;
        }

        .import-helper-list {
            margin: .65rem 0 0;
            padding-left: 1.05rem;
            color: #475569;
            font-size: .84rem;
            font-weight: 700;
            line-height: 1.5;
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

        @media (max-width: 991.98px) {
            .import-create-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .import-create-page {
                padding-top: 5.75rem;
            }

            .import-create-header {
                align-items: stretch;
                flex-direction: column;
            }

            .import-create-actions,
            .import-form-actions {
                width: 100%;
            }

            .import-create-actions .import-create-btn,
            .import-form-actions .import-create-btn,
            .import-form-actions button {
                width: 100%;
            }
        }
    </style>

    <div class="import-create-page px-3 px-md-4 py-4">
        @if(session('success'))
            <div class="import-create-alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="import-create-errors">
                Please review the highlighted upload details.
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="import-create-breadcrumb">
            <a href="{{ route('import-batches.index') }}">Import Batches</a>
            <span>/</span>
            <span>Upload File</span>
        </div>

        <div class="import-create-header">
            <div>
                <h1 class="import-create-title">Upload Import File</h1>
                <p class="import-create-subtitle">
                    Upload a consolidated sales workbook and prepare it for batch processing.
                </p>
            </div>

            <div class="import-create-actions">
                <a href="{{ route('import-batches.index') }}" class="import-create-btn import-create-btn-secondary">
                    Back to Import Batches
                </a>
            </div>
        </div>

        <div class="import-create-layout">
            <section class="import-upload-card">
                <div class="import-create-card-header">
                    <h2 class="import-create-card-title">Upload Form</h2>
                    <p class="import-create-card-subtitle">
                        Select the source workbook, confirm the source type, and add optional batch notes.
                    </p>
                </div>

                <form action="{{ route('import-batches.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    data-loading="true"
                    data-loading-message="Uploading and preparing the import batch. Please wait..."
                    class="import-create-form">
                    @csrf

                    <div class="import-create-field">
                        <label for="import_file" class="import-create-label">Import File</label>
                        <div class="import-upload-zone">
                            <div class="import-upload-zone-title">Choose a workbook or CSV file</div>
                            <div class="import-upload-zone-text">
                                Keep the original consolidated sales file intact so the import processor can detect supported sheets.
                            </div>
                            <input type="file" name="import_file" id="import_file" class="import-create-input" required>
                        </div>
                        <div class="import-create-help">
                            Use the existing branch import workbook or CSV format. The file will be processed by the current import workflow.
                        </div>
                        @error('import_file')
                            <span class="import-create-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="import-create-field">
                        <label for="source_type" class="import-create-label">Source Type</label>
                        <input
                            type="text"
                            name="source_type"
                            id="source_type"
                            class="import-create-input"
                            value="{{ old('source_type', 'manual_upload') }}"
                        >
                        <div class="import-create-help">
                            Leave as manual_upload unless this batch came from a different approved source.
                        </div>
                        @error('source_type')
                            <span class="import-create-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="import-create-field">
                        <label for="notes" class="import-create-label">Notes</label>
                        <textarea
                            name="notes"
                            id="notes"
                            rows="4"
                            class="import-create-textarea"
                            placeholder="Add optional remarks about this upload batch..."
                        >{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="import-create-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="import-form-actions">
                        <button type="submit" class="import-create-btn import-create-btn-primary">Upload File</button>
                        <a href="{{ route('import-batches.index') }}" class="import-create-btn import-create-btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </section>

            <aside class="import-helper-stack">
                <article class="import-helper-card">
                    <div class="import-helper-label">Import Guidelines</div>
                    <div class="import-helper-title">Before uploading</div>
                    <ul class="import-helper-list">
                        <li>Use the approved consolidated sales workbook or CSV export.</li>
                        <li>Do not rename or remove sheets that the parser expects.</li>
                        <li>Upload one source file per import batch.</li>
                    </ul>
                </article>

                <article class="import-helper-card">
                    <div class="import-helper-label">Important Note</div>
                    <div class="import-helper-title">Review before parsing</div>
                    <p class="import-helper-text">
                        After upload, review detected sheets and batch details before running parse actions. Existing conflict checks and import safeguards still apply.
                    </p>
                </article>

                <article class="import-helper-card">
                    <div class="import-helper-label">Supported Format</div>
                    <div class="import-helper-title">Workbook or CSV</div>
                    <p class="import-helper-text">
                        This page only collects the file and batch notes. File validation, parsing, and conflict handling are still handled by the existing backend workflow.
                    </p>
                </article>
            </aside>
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
    </script>
</x-app-layout>
