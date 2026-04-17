<x-app-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1">Sales Transaction Details</h2>
                <p class="text-muted mb-0">View full imported transaction information.</p>
            </div>
            <a href="{{ route('sales-transactions.index') }}" class="btn btn-outline-secondary">
                Back to Transactions
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Customer Name:</strong>
                                    <div>{{ $salesTransaction->customer_name ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <strong>Contact Number:</strong>
                                    <div>{{ $salesTransaction->contact_number ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <strong>Birth Date:</strong>
                                    <div>{{ optional($salesTransaction->birth_date)->format('Y-m-d') ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Address Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <strong>Brgy. / Sitio / Purok / Street:</strong>
                                <div>{{ $salesTransaction->street_address ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Municipality / City:</strong>
                                <div>{{ $salesTransaction->city_municipality ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Transaction Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <strong>Invoice Date:</strong>
                                <div>{{ optional($salesTransaction->invoice_date)->format('Y-m-d') ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Account Number:</strong>
                                <div>{{ $salesTransaction->account_number ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Sales Type:</strong>
                                <div>{{ $salesTransaction->sales_type ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Agent / Referral Name:</strong>
                                <div>{{ $salesTransaction->agent_referral_name ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Transaction Type:</strong>
                                <div>{{ $salesTransaction->transaction_type ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Receipt Number:</strong>
                                <div>{{ $salesTransaction->receipt_number ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Sales Source:</strong>
                                <div>{{ $salesTransaction->sales_source ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Branch (from sheet):</strong>
                                <div>{{ $salesTransaction->branch_name_from_sheet ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                            <strong>Unit Type:</strong>
                            <div>{{ $salesTransaction->unit_type ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Line:</strong>
                            <div>{{ $salesTransaction->product_line_name ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Category:</strong>
                            <div>{{ $salesTransaction->category_name_raw ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Brand:</strong>
                            <div>{{ $salesTransaction->brand_name_raw ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Model:</strong>
                            <div>{{ $salesTransaction->model ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Capacity:</strong>
                            <div>{{ $salesTransaction->capacity ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Description:</strong>
                            <div>{{ $salesTransaction->product_description ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Serial Number:</strong>
                            <div>{{ $salesTransaction->serial_number ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Engine Number:</strong>
                            <div>{{ $salesTransaction->engine_number ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Chassis Number:</strong>
                            <div>{{ $salesTransaction->chassis_number ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Parts Number:</strong>
                            <div>{{ $salesTransaction->parts_number ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Color:</strong>
                            <div>{{ $salesTransaction->color ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <strong>Stock Code:</strong>
                            <div>{{ $salesTransaction->stock_code ?? '-' }}</div>
                        </div>

                        <div class="col-md-12">
                            <strong>Remarks:</strong>
                            <div>{{ $salesTransaction->product_remarks ?? '-' }}</div>
                        </div>

                            <div class="col-md-6">
                                <strong>Terms:</strong>
                                <div>{{ $salesTransaction->terms ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Amount Information</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <strong>SRP / COD Amount:</strong>
                    <div>{{ $salesTransaction->srp_cod_amount !== null ? number_format((float) $salesTransaction->srp_cod_amount, 2) : '-' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Cash Amount:</strong>
                    <div>{{ $salesTransaction->cash_amount !== null ? number_format((float) $salesTransaction->cash_amount, 2) : '-' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Downpayment:</strong>
                    <div>{{ $salesTransaction->downpayment_amount !== null ? number_format((float) $salesTransaction->downpayment_amount, 2) : '-' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Promissory Note:</strong>
                    <div>{{ $salesTransaction->promissory_note_amount !== null ? number_format((float) $salesTransaction->promissory_note_amount, 2) : '-' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Gross Sales:</strong>
                    <div>{{ $salesTransaction->gross_sales_amount !== null ? number_format((float) $salesTransaction->gross_sales_amount, 2) : '-' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Commission Amount:</strong>
                    <div>{{ $salesTransaction->commission_amount !== null ? number_format((float) $salesTransaction->commission_amount, 2) : '-' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Monthly Amortization:</strong>
                    <div>{{ $salesTransaction->monthly_amortization !== null ? number_format((float) $salesTransaction->monthly_amortization, 2) : '-' }}</div>
                </div>

                <div class="col-md-6">
                    <strong>Terms:</strong>
                    <div>{{ $salesTransaction->terms ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Encoding and Update Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <strong>Pouching Date:</strong>
                                <div>{{ optional($salesTransaction->pouching_date)->format('Y-m-d') ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Encoded By:</strong>
                                <div>{{ $salesTransaction->encoded_by ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <strong>Date Last Updated:</strong>
                                <div>{{ optional($salesTransaction->date_last_updated)->format('Y-m-d') ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Raw Imported Row</h5>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0 small bg-light p-3 rounded">{{ json_encode($salesTransaction->raw_row_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Import Metadata</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Transaction ID:</strong> #{{ $salesTransaction->id }}</p>
                        <p><strong>Branch:</strong> {{ $salesTransaction->branch->display_name ?? '-' }}</p>
                        <p><strong>Import Batch:</strong> #{{ $salesTransaction->import_batch_id }}</p>
                        <p><strong>Import Sheet:</strong> {{ $salesTransaction->importBatchSheet->sheet_name ?? '-' }}</p>
                        <p><strong>Source Row Number:</strong> {{ $salesTransaction->source_row_number ?? '-' }}</p>
                        <p><strong>Created At:</strong> {{ $salesTransaction->created_at?->format('Y-m-d H:i:s') ?? '-' }}</p>
                        <p class="mb-0"><strong>Updated At:</strong> {{ $salesTransaction->updated_at?->format('Y-m-d H:i:s') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>