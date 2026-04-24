<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Upload Import File</h2>
            <p class="text-muted mb-0">Upload an Excel or CSV file for processing.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('import-batches.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="import_file" class="form-label">Import File</label>
                        <input type="file" name="import_file" id="import_file" class="form-control" required>
                        @error('import_file')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
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

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Upload File</button>
                        <a href="{{ route('import-batches.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>