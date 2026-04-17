<x-app-layout>
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Product Lines</h2>
                <p class="text-muted mb-0">Manage product line master records.</p>
            </div>
            <a href="{{ route('product-lines.create') }}" class="btn btn-primary">
                Add Product Line
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
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productLines as $productLine)
                                <tr>
                                    <td>{{ $productLine->code }}</td>
                                    <td>{{ $productLine->name }}</td>
                                    <td>
                                        <span class="badge {{ $productLine->status === 'active' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($productLine->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('product-lines.show', $productLine) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                        <a href="{{ route('product-lines.edit', $productLine) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No product lines found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($productLines->hasPages())
                <div class="card-footer">
                    {{ $productLines->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>