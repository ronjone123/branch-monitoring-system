<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Add Location</h2>
            <p class="text-muted mb-0">Create a new location record.</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('locations.store') }}" method="POST">
                    @csrf
                    @include('locations._form', ['location' => new \App\Models\Location()])

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Location</button>
                        <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>