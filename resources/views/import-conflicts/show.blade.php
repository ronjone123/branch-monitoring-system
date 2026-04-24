<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Import Conflict Details</h2>
                <p class="text-muted mb-0">Compare existing and incoming row data.</p>
            </div>
            <a href="{{ route('import-conflicts.index') }}" class="btn btn-outline-secondary">
                Back to Conflicts
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Conflict Metadata</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>ID:</strong> #{{ $importConflict->id }}</p>
                        <p><strong>Batch:</strong> #{{ $importConflict->import_batch_id }}</p>
                        <p><strong>Sheet:</strong> {{ $importConflict->importBatchSheet->sheet_name ?? '-' }}</p>
                        <p><strong>Branch:</strong> {{ $importConflict->branch->display_name ?? '-' }}</p>
                        <p><strong>Source Row Number:</strong> {{ $importConflict->source_row_number ?? '-' }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($importConflict->status) }}</p>
                        <p><strong>Existing Transaction ID:</strong> {{ $importConflict->existing_sales_transaction_id ?? '-' }}</p>
                        <p><strong>Created At:</strong> {{ $importConflict->created_at?->format('Y-m-d H:i:s') ?? '-' }}</p>
                        <p class="mb-0"><strong>Notes:</strong> {{ $importConflict->notes ?? '-' }}</p>
                    <div class="mt-4 d-flex flex-wrap gap-2">
                            @if($importConflict->status === 'pending')
                                <form action="{{ route('import-conflicts.accept-update', $importConflict) }}" method="POST"
                                    onsubmit="return confirm('Apply incoming row data to the existing sales transaction?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Accept Incoming Update
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'reviewed')
                                <form action="{{ route('import-conflicts.mark-reviewed', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Mark Reviewed
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'ignored')
                                <form action="{{ route('import-conflicts.mark-ignored', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        Mark Ignored
                                    </button>
                                </form>
                            @endif

                            @if($importConflict->status !== 'resolved')
                                <form action="{{ route('import-conflicts.mark-resolved', $importConflict) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-info btn-sm">
                                        Mark Resolved
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('import-conflicts.destroy', $importConflict) }}" method="POST"
                                onsubmit="return confirm('Delete this conflict permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Delete Conflict
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Field Comparison</h5>
                    </div>

                    <div class="card-body border-bottom bg-light">
                        <strong>
                            Changed Fields:
                            {{ collect($comparisonRows)->where('changed', true)->count() }}
                        </strong>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
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
                                        <tr class="{{ $row['changed'] ? 'table-warning' : '' }}">
                                            <td>{{ $row['column'] }}</td>
                                            <td>{{ $row['label'] }}</td>
                                            <td>{{ $row['existing'] !== null && $row['existing'] !== '' ? $row['existing'] : '-' }}</td>
                                            <td>{{ $row['incoming'] !== null && $row['incoming'] !== '' ? $row['incoming'] : '-' }}</td>
                                            <td>
                                                @if($row['changed'])
                                                    <span class="badge bg-warning text-dark">Changed</span>
                                                @else
                                                    <span class="badge bg-light text-dark border">Same</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                No comparison data found.
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