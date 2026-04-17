<x-app-layout>
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Branches</h2>
                <p class="text-muted mb-0">Manage branch master records.</p>
            </div>
            <a href="{{ route('branches.create') }}" class="btn btn-primary">
                Add Branch
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Display Name</th>
                                <th>Business Unit</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Sheet Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td>{{ $branch->code }}</td>
                                    <td>{{ $branch->display_name }}</td>
                                    <td>{{ $branch->businessUnit->name }}</td>
                                    <td>{{ $branch->location->name }}</td>
                                    <td>
                                        <span class="badge
                                            @if($branch->status === 'active') bg-success
                                            @elseif($branch->status === 'inactive') bg-warning text-dark
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($branch->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $branch->spreadsheet_sheet_name ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('branches.show', $branch) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                        <a href="{{ route('branches.edit', $branch) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('branches.update', $branch) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="closed">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Close this branch?')">
                                                Close
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        No branches found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($branches->hasPages())
                <div class="card-footer">
                    {{ $branches->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>