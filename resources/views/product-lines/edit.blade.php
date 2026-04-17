<x-app-layout>
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Edit Product Line</h2>
            <p class="text-muted mb-0">Update product line information.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('product-lines.update', $productLine) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('product-lines._form', ['productLine' => $productLine])

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Product Line</button>
                        <a href="{{ route('product-lines.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>