<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Category Details</h2>
                <p class="text-muted mb-0">View category information.</p>
            </div>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Edit Category</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Product Line:</strong>
                        <div>{{ $category->productLine->name }} ({{ $category->productLine->code }})</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Code:</strong>
                        <div>{{ $category->code ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ $category->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($category->status) }}</div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>