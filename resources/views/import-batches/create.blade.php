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
            --summary-info-bg: #eaf4ff;
            --summary-info-text: #175cd3;
        }

        body {
            background: var(--summary-bg);
        }

        .summary-shell {
            max-width: 1400px;
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
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--summary-text);
            line-height: 1.2;
        }

        .summary-stat-sub {
            color: var(--summary-muted);
            font-size: 0.85rem;
            margin-top: 0.35rem;
        }

        .form-panel {
            padding: 1.5rem;
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

        .upload-dropzone {
            border: 2px dashed #9dbce8;
            border-radius: 1rem;
            background: #f8fbff;
            padding: 1.5rem;
        }

        .upload-dropzone-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--summary-blue);
            margin-bottom: 0.35rem;
        }

        .upload-dropzone-sub {
            color: var(--summary-muted);
            font-size: 0.9rem;
            margin-bottom: 0.9rem;
        }

        .helper-box {
            background: var(--summary-info-bg);
            color: var(--summary-info-text);
            border: 1px solid #cfe1ff;
            border-radius: 0.9rem;
            padding: 1rem 1.1rem;
        }

        .helper-box-title {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-bottom: 0.45rem;
        }

        .helper-box ul {
            margin: 0;
            padding-left: 1.1rem;
        }

        .helper-box li {
            margin-bottom: 0.3rem;
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

        .text-danger.small {
            display: block;
            margin-top: 0.4rem;
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
        }
    </style>

    <div class="summary-shell page-with-fixed-nav px-3 px-md-4 py-4">
        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Upload Import File</div>
                    <div class="mt-2 text-white-50">
                        Upload an Excel or CSV file, define the source, and prepare the batch for processing.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Date</div>
                    <div class="summary-date-value">{{ now()->format('F d, Y') }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Accepted Files</div>
                    <div class="summary-stat-value">Excel / CSV</div>
                    <div class="summary-stat-sub">Upload spreadsheet files for batch processing</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Default Source Type</div>
                    <div class="summary-stat-value">Manual Upload</div>
                    <div class="summary-stat-sub">Can be changed before saving the batch</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-stat">
                    <div class="summary-stat-label">Next Step</div>
                    <div class="summary-stat-value">Parse Sheets</div>
                    <div class="summary-stat-sub">After upload, review and parse supported transaction sheets</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>Import Upload Form</h5>
                        <div class="summary-section-subtitle">
                            Provide the source file and optional notes for this import batch.
                        </div>
                    </div>

                    <div class="form-panel">
                        <form action="{{ route('import-batches.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="import_file" class="form-label">Import File</label>
                                <div class="upload-dropzone">
                                    <div class="upload-dropzone-title">Choose file to upload</div>
                                    <div class="upload-dropzone-sub">
                                        Supported file types include Excel and CSV formats used by your branch import workflow.
                                    </div>
                                    <input type="file" name="import_file" id="import_file" class="form-control" required>
                                </div>
                                @error('import_file')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="source_type" class="form-label">Source Type</label>
                                <input
                                    type="text"
                                    name="source_type"
                                    id="source_type"
                                    class="form-control"
                                    value="{{ old('source_type', 'manual_upload') }}"
                                >
                                @error('source_type')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea
                                    name="notes"
                                    id="notes"
                                    rows="4"
                                    class="form-control"
                                    placeholder="Add optional remarks about this upload batch..."
                                >{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-summary-primary">Upload File</button>
                                <a href="{{ route('import-batches.index') }}" class="btn btn-outline-secondary btn-summary-outline">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="helper-box mb-4">
                    <div class="helper-box-title">Upload Guidance</div>
                    <ul>
                        <li>Use the correct branch file format before uploading.</li>
                        <li>Review source type to match the upload origin.</li>
                        <li>Add notes when the batch needs special review.</li>
                        <li>After upload, inspect detected sheets and parsing results.</li>
                    </ul>
                </div>

                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>What Happens Next</h5>
                        <div class="summary-section-subtitle">
                            Expected workflow after the file is uploaded.
                        </div>
                    </div>

                    <div class="form-panel">
                        <div class="summary-stat mb-3">
                            <div class="summary-stat-label">Step 1</div>
                            <div class="summary-stat-value">Batch Created</div>
                            <div class="summary-stat-sub">The uploaded file is stored and registered as an import batch.</div>
                        </div>

                        <div class="summary-stat mb-3">
                            <div class="summary-stat-label">Step 2</div>
                            <div class="summary-stat-value">Sheets Reviewed</div>
                            <div class="summary-stat-sub">Detected sheets can be previewed and checked before parsing.</div>
                        </div>

                        <div class="summary-stat">
                            <div class="summary-stat-label">Step 3</div>
                            <div class="summary-stat-value">Transactions Parsed</div>
                            <div class="summary-stat-sub">Supported transaction sheets are parsed into the monitoring system.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>