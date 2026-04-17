<x-app-layout>
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2 class="h4 mb-1">Sales Transactions</h2>
            <p class="text-muted mb-0">Browse imported sales transaction records.</p>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('sales-transactions.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-select">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="import_batch_id" class="form-label">Import Batch</label>
                            <select name="import_batch_id" id="import_batch_id" class="form-select">
                                <option value="">All Batches</option>
                                @foreach($importBatches as $batch)
                                    <option value="{{ $batch->id }}" {{ request('import_batch_id') == $batch->id ? 'selected' : '' }}>
                                        #{{ $batch->id }} - {{ $batch->original_filename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input
                                type="text"
                                name="customer_name"
                                id="customer_name"
                                class="form-control"
                                value="{{ request('customer_name') }}"
                            >
                        </div>

                        <div class="col-md-3">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input
                                type="text"
                                name="account_number"
                                id="account_number"
                                class="form-control"
                                value="{{ request('account_number') }}"
                            >
                        </div>

                        <div class="col-md-3">
                            <label for="date_from" class="form-label">Date From</label>
                            <input
                                type="date"
                                name="date_from"
                                id="date_from"
                                class="form-control"
                                value="{{ request('date_from') }}"
                            >
                        </div>

                        <div class="col-md-3">
                            <label for="date_to" class="form-label">Date To</label>
                            <input
                                type="date"
                                name="date_to"
                                id="date_to"
                                class="form-control"
                                value="{{ request('date_to') }}"
                            >
                        </div>

                        <div class="col-12 d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('sales-transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Transaction Records</h5>
                <span class="text-muted small">{{ $transactions->total() }} record(s)</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice Date</th>
                                <th>Account Number</th>
                                <th>Customer Name</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Terms</th>
                                <th>Branch</th>
                                <th>Import Batch</th>
                                <th>Row #</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ optional($transaction->invoice_date)->format('Y-m-d') ?? '-' }}</td>
                                    <td>{{ $transaction->account_number ?? '-' }}</td>
                                    <td>{{ $transaction->customer_name ?? '-' }}</td>
                                    <td>{{ $transaction->product ?? '-' }}</td>
                                    <td>
                                        {{ $transaction->amount !== null ? number_format((float) $transaction->amount, 2) : '-' }}
                                    </td>
                                    <td>{{ $transaction->terms ?? '-' }}</td>
                                    <td>{{ $transaction->branch->display_name ?? '-' }}</td>
                                    <td>#{{ $transaction->import_batch_id }}</td>
                                    <td>{{ $transaction->source_row_number ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('sales-transactions.show', $transaction) }}"
                                        class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">
                                        No sales transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($transactions->hasPages())
                <div class="card-footer">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>