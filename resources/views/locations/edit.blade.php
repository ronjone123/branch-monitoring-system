<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Edit Location</h2>
            <p class="text-muted mb-0">Update location information.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('locations.update', $location) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('locations._form', ['location' => $location])

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Location</button>
                        <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>