<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Product Line Details</h2>
                <p class="text-muted mb-0">View product line information.</p>
            </div>
            <a href="{{ route('product-lines.edit', $productLine) }}" class="btn btn-primary">Edit Product Line</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Code:</strong>
                        <div>{{ $productLine->code }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ $productLine->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($productLine->status) }}</div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('product-lines.index') }}" class="btn btn-outline-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>