<x-app-layout>
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Edit Category</h2>
            <p class="text-muted mb-0">Update category information.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('categories._form', ['category' => $category])

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>