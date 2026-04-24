<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">User Details</h2>
                <p class="text-muted mb-0">View user account information.</p>
            </div>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit User</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Name:</strong>
                        <div>{{ $user->name }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <div>{{ $user->email }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Role:</strong>
                        <div>{{ $user->role->name ?? '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($user->status) }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Created At:</strong>
                        <div>{{ $user->created_at?->format('Y-m-d H:i:s') ?? '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <strong>Updated At:</strong>
                        <div>{{ $user->updated_at?->format('Y-m-d H:i:s') ?? '-' }}</div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>