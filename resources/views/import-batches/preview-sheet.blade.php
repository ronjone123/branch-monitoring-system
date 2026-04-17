<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Sheet Preview</h2>
                <p class="text-muted mb-0">
                    Preview raw data for {{ $sheet->sheet_name }}
                </p>
            </div>
            <a href="{{ route('import-batches.show', $importBatch) }}" class="btn btn-outline-secondary">
                Back to Batch
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <strong>Sheet Name:</strong>
                        <div>{{ $preview['sheet_name'] }}</div>
                    </div>
                    <div class="col-md-3">
                        <strong>Highest Row:</strong>
                        <div>{{ $preview['highest_row'] }}</div>
                    </div>
                    <div class="col-md-3">
                        <strong>Highest Column:</strong>
                        <div>{{ $preview['highest_column'] }}</div>
                    </div>
                    <div class="col-md-3">
                        <strong>Detected Header Row:</strong>
                        <div>{{ $preview['header_row_number'] ?? '-' }}</div>
                    </div>
                    <div class="col-md-3">
                        <strong>Last Useful Column:</strong>
                        <div>{{ $preview['last_useful_column_letter'] ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Detected Headers</h5>
            </div>
            <div class="card-body">
                @if(!empty($preview['headers']))
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($preview['headers'] as $header)
                            <span class="badge bg-primary">{{ $header ?: '(blank)' }}</span>
                        @endforeach
                    </div>
                @else
                    <span class="text-muted">No header row detected yet.</span>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Header Mapping Preview</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Column</th>
                                <th>Raw Header</th>
                                <th>Clean Header</th>
                                <th>Usable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($preview['header_map'] as $header)
                                <tr @if($header['is_useful']) class="table-success" @endif>
                                    <td>{{ $header['column_letter'] }}</td>
                                    <td>{{ $header['raw_header'] ?? '-' }}</td>
                                    <td>{{ $header['clean_header'] ?? '-' }}</td>
                                    <td>
                                        @if($header['is_useful'])
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No header map available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Usable Headers Only</h5>
            </div>
            <div class="card-body">
                @if(!empty($preview['usable_header_map']))
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($preview['usable_header_map'] as $header)
                            <span class="badge bg-success">
                                {{ $header['column_letter'] }} - {{ $header['clean_header'] }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <span class="text-muted">No usable headers detected.</span>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">First 20 Rows</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle mb-0">
                        <tbody>
                            @foreach($preview['preview_rows'] as $rowNumber => $cells)
                                <tr @if($rowNumber === $preview['header_row_number']) class="table-warning" @endif>
                                    <th class="bg-light text-nowrap" style="width: 80px;">
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