<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Import Batches</h2>
                <p class="text-muted mb-0">Track uploaded import files and processing status.</p>
            </div>
            <a href="{{ route('import-batches.create') }}" class="btn btn-primary">
                Upload New File
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Filename</th>
                                <th>Uploaded By</th>
                                <th>Source Type</th>
                                <th>Status</th>
                                <th>Imported At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($importBatches as $batch)
                                <tr>
                                    <td>#{{ $batch->id }}</td>
                                    <td>{{ $batch->original_filename }}</td>
                                    <td>{{ $batch->user->name ?? '-' }}</td>
                                    <td>{{ $batch->source_type ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $batch->status)) }}</span>
                                    </td>
                                    <td>{{ optional($batch->imported_at)->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('import-batches.show', $batch) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        No import batches found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($importBatches->hasPages())
                <div class="card-footer">
                    {{ $importBatches->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>