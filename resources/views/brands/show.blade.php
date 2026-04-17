<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Brand Details</h2>
                <p class="text-muted mb-0">View brand information.</p>
            </div>
            <a href="{{ route('brands.edit', $brand) }}" class="btn btn-primary">Edit Brand</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Product Line:</strong>
                        <div>{{ $brand->productLine->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Code:</strong>
                        <div>{{ $brand->code ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ $brand->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($brand->status) }}</div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>