<x-app-layout>
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Edit Brand</h2>
            <p class="text-muted mb-0">Update brand information.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('brands.update', $brand) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('brands._form', ['brand' => $brand])

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Brand</button>
                        <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>