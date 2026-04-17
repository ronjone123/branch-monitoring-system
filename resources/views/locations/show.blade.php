<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Location Details</h2>
                <p class="text-muted mb-0">View location information.</p>
            </div>
            <a href="{{ route('locations.edit', $location) }}" class="btn btn-primary">Edit Location</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Code:</strong>
                        <div>{{ $location->code }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ $location->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>City / Municipality:</strong>
                        <div>{{ $location->city_or_municipality ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Province:</strong>
                        <div>{{ $location->province ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($location->status) }}</div>
                    </div>
                    <div class="col-12">
                        <strong>Remarks:</strong>
                        <div>{{ $location->remarks ?? '-' }}</div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>