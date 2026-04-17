<x-app-layout>
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Brands</h2>
                <p class="text-muted mb-0">Manage brand master records.</p>
            </div>
            <a href="{{ route('brands.create') }}" class="btn btn-primary">
                Add Brand
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product Line</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                                <tr>
                                    <td>{{ $brand->productLine->name ?? '-' }}</td>
                                    <td>{{ $brand->code ?? '-' }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        <span class="badge {{ $brand->status === 'active' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($brand->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('brands.show', $brand) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                        <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No brands found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($brands->hasPages())
                <div class="card-footer">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>