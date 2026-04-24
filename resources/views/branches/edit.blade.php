<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Edit Branch</h2>
            <p class="text-muted mb-0">Update branch information.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('branches.update', $branch) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('branches._form', ['branch' => $branch])

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Branch</button>
                        <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>