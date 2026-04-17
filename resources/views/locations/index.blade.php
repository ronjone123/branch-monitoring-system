<x-app-layout>
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Locations</h2>
                <p class="text-muted mb-0">Manage location master records.</p>
            </div>
            <a href="{{ route('locations.create') }}" class="btn btn-primary">
                Add Location
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>City / Municipality</th>
                                <th>Province</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $location)
                                <tr>
                                    <td>{{ $location->code }}</td>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->city_or_municipality ?? '-' }}</td>
                                    <td>{{ $location->province ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $location->status === 'active' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($location->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('locations.show', $location) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                        <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No locations found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($locations->hasPages())
                <div class="card-footer">
                    {{ $locations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>