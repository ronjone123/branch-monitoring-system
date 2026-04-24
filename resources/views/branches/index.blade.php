<x-app-layout>
    <style>
        .branches-table th {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            white-space: nowrap;
            padding: 0.9rem 1rem;
        }

        .branches-table td {
            padding: 0.95rem 1rem;
            vertical-align: middle;
        }

        .branches-table .code-col,
        .branches-table .status-col,
        .branches-table .actions-col {
            white-space: nowrap;
        }

        .truncate-cell {
            max-width: 240px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .page-title-card {
            overflow: hidden;
        }

        .action-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 px-4 py-3 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 page-title-card mb-4">
            <div class="card-body bg-dark text-dark p-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <h2 class="h3 mb-1 fw-bold">Branches</h2>
                    <p class="mb-0 text-white-50">Manage branch master records.</p>
                </div>

                <div>
                    <a href="{{ route('branches.create') }}" class="btn btn-light rounded-pill px-4 fw-semibold">
                        Add Branch
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-semibold">Branch List</h5>
            </div>

            <div class="card-body pt-0 px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 branches-table">
                        <thead class="table-light">
                            <tr>
                                <th class="code-col">Code</th>
                                <th>Display Name</th>
                                <th>Business Unit</th>
                                <th>Location</th>
                                <th class="status-col">Status</th>
                                <th>Sheet Name</th>
                                <th class="text-end actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td class="code-col">
                                        <span class="badge rounded-pill text-bg-dark">
                                            {{ $branch->code }}
                                        </span>
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $branch->display_name }}
                                    </td>

                                    <td>
                                        {{ $branch->businessUnit->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $branch->location->name ?? '-' }}
                                    </td>

                                    <td class="status-col">
                                        <span class="badge rounded-pill
                                            @if($branch->status === 'active') text-bg-success
                                            @elseif($branch->status === 'inactive') text-bg-warning
                                            @else text-bg-danger
                                            @endif">
                                            {{ ucfirst($branch->status) }}
                                        </span>
                                    </td>

                                    <td class="truncate-cell" title="{{ $branch->spreadsheet_sheet_name ?? '-' }}">
                                        {{ $branch->spreadsheet_sheet_name ?? '-' }}
                                    </td>

                                    <td class="text-end actions-col">
                                        <div class="action-group">
                                            <a href="{{ route('branches.show', $branch) }}"
                                               class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                                View
                                            </a>

                                            <a href="{{ route('branches.edit', $branch) }}"
                                               class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                Edit
                                            </a>

                                            @if($branch->status !== 'closed')
                                                <form action="{{ route('branches.update', $branch) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="closed">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                        onclick="return confirm('Close this branch?')">
                                                        Close
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        No branches found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($branches->hasPages())
                <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                    {{ $branches->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>