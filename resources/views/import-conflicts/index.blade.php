<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <h2 class="h4 mb-1">Import Conflicts</h2>
            <p class="text-muted mb-0">Review changed sales rows detected during import.</p>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('import-conflicts.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="import_batch_id" class="form-label">Import Batch</label>
                            <select name="import_batch_id" id="import_batch_id" class="form-select">
                                <option value="">All Batches</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ request('import_batch_id') == $batch->id ? 'selected' : '' }}>
                                        #{{ $batch->id }} - {{ $batch->original_filename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-select">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>
                                    All Statuses
                                </option>

                                @foreach(['pending', 'reviewed', 'ignored', 'resolved'] as $status)
                                    <option value="{{ $status }}"
                                        {{ request('status', 'pending') === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('import-conflicts.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Conflict Records</h5>
                <span class="text-muted small">{{ $conflicts->total() }} conflict(s)</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Batch</th>
                                <th>Sheet</th>
                                <th>Branch</th>
                                <th>Source Row</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($conflicts as $conflict)
                                <tr>
                                    <td>#{{ $conflict->id }}</td>
                                    <td>#{{ $conflict->import_batch_id }}</td>
                                    <td>{{ $conflict->importBatchSheet->sheet_name ?? '-' }}</td>
                                    <td>{{ $conflict->branch->display_name ?? '-' }}</td>
                                    <td>{{ $conflict->source_row_number ?? '-' }}</td>
                                    <td>
                                        <span class="badge
                                            {{ $conflict->status === 'pending' ? 'bg-warning text-dark' : '' }}
                                            {{ $conflict->status === 'reviewed' ? 'bg-success' : '' }}
                                            {{ $conflict->status === 'ignored' ? 'bg-secondary' : '' }}
                                            {{ $conflict->status === 'resolved' ? 'bg-primary' : '' }}">
                                            {{ ucfirst($conflict->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $conflict->notes ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('import-conflicts.show', $conflict) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        No import conflicts found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($conflicts->hasPages())
                <div class="card-footer">
                    {{ $conflicts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>