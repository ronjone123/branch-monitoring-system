<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Branch Details</h2>
                <p class="text-muted mb-0">View branch information.</p>
            </div>
            <a href="{{ route('branches.edit', $branch) }}" class="btn btn-primary">Edit Branch</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Code:</strong>
                        <div>{{ $branch->code }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Display Name:</strong>
                        <div>{{ $branch->display_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Business Unit:</strong>
                        <div>{{ $branch->businessUnit->name }} ({{ $branch->businessUnit->code }})</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Location:</strong>
                        <div>{{ $branch->location->name }} ({{ $branch->location->code }})</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Area / Barangay:</strong>
                        <div>{{ $branch->area_barangay ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Spreadsheet Sheet Name:</strong>
                        <div>{{ $branch->spreadsheet_sheet_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($branch->status) }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Opened Date:</strong>
                        <div>{{ optional($branch->opened_at)->format('Y-m-d') ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Closed Date:</strong>
                        <div>{{ optional($branch->closed_at)->format('Y-m-d') ?? '-' }}</div>
                    </div>
                    <div class="col-12">
                        <strong>Allowed Product Lines:</strong>
                        <div class="mt-2">
                            @forelse($branch->productLines as $productLine)
                                <span class="badge bg-primary me-1">{{ $productLine->name }}</span>
                            @empty
                                <span class="text-muted">No allowed product lines assigned.</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-12">
                        <strong>Remarks:</strong>
                        <div>{{ $branch->remarks ?? '-' }}</div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>