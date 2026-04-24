<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="mx-auto" style="max-width: 1400px;">

            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body bg-dark text-dark p-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <div class="text-uppercase small opacity-75 mb-2">Sales Transaction Record</div>
                            <h2 class="fw-bold mb-1">{{ $salesTransaction->customer_name ?? '-' }}</h2>
                            <div class="d-flex flex-wrap gap-3 small opacity-75">
                                <span>Account #: {{ $salesTransaction->account_number ?? '-' }}</span>
                                <span>Receipt #: {{ $salesTransaction->receipt_number ?? '-' }}</span>
                                <span>Branch: {{ $salesTransaction->branch->display_name ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="badge bg-success fs-6 px-3 py-2 rounded-pill mb-2">
                                {{ $salesTransaction->sales_type ?? 'N/A' }}
                            </div>
                            <div>
                                <a href="{{ route('sales-transactions.index') }}" class="btn btn-light rounded-pill px-4">
                                    Back to Transactions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4">Customer Information</h5>

                                    <div class="mb-3">
                                        <div class="text-muted small">Customer Name</div>
                                        <div class="fw-semibold">{{ $salesTransaction->customer_name ?? '-' }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">Contact Number</div>
                                        <div class="fw-semibold">{{ $salesTransaction->contact_number ?? '-' }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">Birth Date</div>
                                        <div class="fw-semibold">{{ $salesTransaction->birth_date ?? '-' }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">Sales Source</div>
                                        <div class="fw-semibold">{{ $salesTransaction->sales_source ?? '-' }}</div>
                                    </div>

                                    <div>
                                        <div class="text-muted small">Transaction Type</div>
                                        <div class="fw-semibold">{{ $salesTransaction->transaction_type ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4">Address Information</h5>

                                    <div class="mb-3">
                                        <div class="text-muted small">Street / Sitio / Purok</div>
                                        <div class="fw-semibold">{{ $salesTransaction->street_address ?? '-' }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-muted small">Municipality / City</div>
                                        <div class="fw-semibold">{{ $salesTransaction->city_municipality ?? '-' }}</div>
                                    </div>

                                    <div>
                                        <div class="text-muted small">Branch</div>
                                        <div class="fw-semibold">{{ $salesTransaction->branch->display_name ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="fw-bold mb-0">Product Information</h5>
                                        <span class="badge bg-primary rounded-pill px-3 py-2">
                                            {{ $salesTransaction->unit_type ?? '-' }}
                                        </span>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-3">
                                            <div class="text-muted small">Line</div>
                                            <div class="fw-semibold">{{ $salesTransaction->product_line_name ?? '-' }}</div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text-muted small">Category</div>
                                            <div class="fw-semibold">{{ $salesTransaction->category_name_raw ?? '-' }}</div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text-muted small">Brand</div>
                                            <div class="fw-semibold">{{ $salesTransaction->brand_name_raw ?? '-' }}</div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text-muted small">Model</div>
                                            <div class="fw-semibold">{{ $salesTransaction->model ?? '-' }}</div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text-muted small">Serial Number</div>
                                            <div class="fw-semibold">{{ $salesTransaction->serial_number ?? '-' }}</div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text-muted small">Engine Number</div>
                                            <div class="fw-semibold">{{ $salesTransaction->engine_number ?? '-' }}</div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text-muted small">Chassis Number</div>
                                            <div class="fw-semibold">{{ $salesTransaction->chassis_number ?? '-' }}</div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="text-muted small">Stock Code</div>
                                            <div class="fw-semibold">{{ $salesTransaction->stock_code ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Financial Summary</h5>

                <div class="bg-light rounded-4 p-3 mb-3">
                    <div class="text-muted small">Promissory Note</div>
                    <div class="fs-4 fw-bold">₱{{ number_format((float) ($salesTransaction->promissory_note_amount ?? 0), 2) }}</div>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">SRP / COD</span>
                    <span class="fw-semibold">₱{{ number_format((float) ($salesTransaction->srp_cod_amount ?? 0), 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Cash</span>
                    <span class="fw-semibold">₱{{ number_format((float) ($salesTransaction->cash_amount ?? 0), 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Gross Sales</span>
                    <span class="fw-semibold">₱{{ number_format((float) ($salesTransaction->gross_sales_amount ?? 0), 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Downpayment</span>
                    <span class="fw-semibold">₱{{ number_format((float) ($salesTransaction->downpayment_amount ?? 0), 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Monthly Amortization</span>
                    <span class="fw-semibold">₱{{ number_format((float) ($salesTransaction->monthly_amortization ?? 0), 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Terms</span>
                    <span class="fw-semibold">{{ $salesTransaction->terms ?? '-' }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span class="text-muted">Commission</span>
                    <span class="fw-semibold">₱{{ number_format((float) ($salesTransaction->commission_amount ?? 0), 2) }}</span>
                </div>
            </div>
        </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Import Information</h5>

                            <div class="mb-3">
                                <div class="text-muted small">Import Batch</div>
                                <div class="fw-semibold">#{{ $salesTransaction->import_batch_id ?? '-' }}</div>
                            </div>

                            <div class="mb-3">
                                <div class="text-muted small">Sheet</div>
                                <div class="fw-semibold">{{ $salesTransaction->importBatchSheet->sheet_name ?? '-' }}</div>
                            </div>

                            <div class="mb-3">
                                <div class="text-muted small">Encoded By</div>
                                <div class="fw-semibold">{{ $salesTransaction->encoded_by ?? '-' }}</div>
                            </div>

                            <div>
                                <div class="text-muted small">Last Updated From Sheet</div>
                                <div class="fw-semibold">{{ $salesTransaction->date_last_updated ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Conflict History</h5>
                                <span class="badge bg-secondary rounded-pill">{{ $relatedConflicts->count() }}</span>
                            </div>

                            @forelse($relatedConflicts as $conflict)
                                <div class="border rounded-4 p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>#{{ $conflict->id }}</strong>
                                        <span class="badge bg-light text-dark border">
                                            {{ ucfirst($conflict->status) }}
                                        </span>
                                    </div>

                                    <div class="small text-muted mb-3">
                                        {{ $conflict->created_at?->format('Y-m-d H:i') }}
                                    </div>

                                    <a href="{{ route('import-conflicts.show', $conflict) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill w-100">
                                        View Conflict
                                    </a>
                                </div>
                            @empty
                                <div class="text-center text-muted py-3">
                                    No related conflicts found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>