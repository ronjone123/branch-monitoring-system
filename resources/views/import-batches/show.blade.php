<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h2 class="h4 mb-1">Import Batch Details</h2>
                <p class="text-muted mb-0">Review import metadata, sheets, and errors.</p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <form action="{{ route('import-batches.parse-all', $importBatch) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        Parse All Transaction Sheets
                    </button>
                </form>

                <a href="{{ route('import-batches.index') }}" class="btn btn-outline-secondary">
                    Back to List
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Batch Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>ID:</strong> #{{ $importBatch->id }}</p>
                        <p><strong>Original Filename:</strong> {{ $importBatch->original_filename }}</p>
                        <p><strong>Stored Filename:</strong> {{ $importBatch->stored_filename ?? '-' }}</p>
                        <p><strong>Uploaded By:</strong> {{ $importBatch->user->name ?? '-' }}</p>
                        <p><strong>Source Type:</strong> {{ $importBatch->source_type ?? '-' }}</p>
                        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $importBatch->status)) }}</p>
                        <p><strong>Total Sheets:</strong> {{ $importBatch->total_sheets }}</p>
                        <p><strong>Supported Sheets:</strong> {{ $importBatch->supported_sheets }}</p>
                        <p><strong>Total Rows:</strong> {{ $importBatch->total_rows }}</p>
                        <p><strong>Valid Rows:</strong> {{ $importBatch->valid_rows }}</p>
                        <p><strong>Invalid Rows:</strong> {{ $importBatch->invalid_rows }}</p>
                        <p><strong>Imported Rows:</strong> {{ $importBatch->imported_rows }}</p>
                        <p><strong>Skipped Rows:</strong> {{ $importBatch->skipped_rows }}</p>
                        <p><strong>Duplicate Rows:</strong> {{ $importBatch->duplicate_rows }}</p>
                        <p><strong>Conflict Rows:</strong> {{ $importBatch->conflict_rows }}</p>
                        <p><strong>Imported At:</strong> {{ optional($importBatch->imported_at)->format('Y-m-d H:i:s') ?? '-' }}</p>
                        <p class="mb-0"><strong>Notes:</strong> {{ $importBatch->notes ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Sheet Tracking</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sheet Name</th>
                                        <th>Type</th>
                                        <th>Branch</th>
                                        <th>Status</th>
                                        <th>Total Rows</th>
                                        <th>Imported</th>
                                        <th>Valid</th>
                                        <th>Duplicate</th>
                                        <th>Conflict</th>
                                        <th>Notes</th>
                                        <th style="min-width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($importBatch->sheets as $sheet)
                                        <tr>
                                            <td>{{ $sheet->sheet_name }}</td>
                                            <td>{{ ucfirst($sheet->sheet_type) }}</td>
                                            <td>{{ $sheet->branch->display_name ?? '-' }}</td>
                                            <td>{{ ucfirst($sheet->status) }}</td>
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
                                                           class="btn btn-sm btn-outline-primary">
                                                            Preview
                                                        </a>

                                                        <form action="{{ route('import-batches.sheets.parse', [$importBatch, $sheet]) }}"
                                                              method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success w-100">
                                                                Parse
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('import-batch-sheets.reset', $sheet) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Reset parsed data for this sheet?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
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
                                            <td colspan="11" class="text-center py-4 text-muted">
                                                No sheet records yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Import Errors</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
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
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                No import errors yet.
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
</x-app-layout>