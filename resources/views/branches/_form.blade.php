<style>
    .branch-form .form-label {
        font-weight: 700;
        color: var(--summary-text, #162033);
        margin-bottom: 0.45rem;
    }

    .branch-form .form-control,
    .branch-form .form-select {
        border-radius: 0.85rem;
        border: 1px solid var(--summary-border, #cfd9ea);
        padding: 0.8rem 0.95rem;
        box-shadow: none;
        color: var(--summary-text, #162033);
        background: #fff;
    }

    .branch-form .form-control:focus,
    .branch-form .form-select:focus {
        border-color: #7aa7e8;
        box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
    }

    .branch-form .form-hint {
        font-size: 0.82rem;
        color: var(--summary-muted, #6b7280);
        margin-top: 0.35rem;
    }

    .branch-form .field-card {
        background: #fff;
        border: 1px solid var(--summary-border, #cfd9ea);
        border-radius: 0.9rem;
        padding: 1rem;
        height: 100%;
    }

    .branch-form .field-card-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--summary-muted, #6b7280);
        margin-bottom: 0.8rem;
    }

    .branch-form .product-lines-box {
        border: 1px solid var(--summary-border, #cfd9ea);
        border-radius: 0.9rem;
        background: #fbfdff;
        padding: 1rem;
    }

    .branch-form .form-check {
        background: #fff;
        border: 1px solid #e3ebf7;
        border-radius: 0.8rem;
        padding: 0.75rem 0.9rem 0.75rem 2.2rem;
        min-height: 100%;
    }

    .branch-form .form-check-input {
        margin-top: 0.2rem;
    }

    .branch-form .form-check-label {
        color: var(--summary-text, #162033);
        font-weight: 600;
    }

    .branch-form .section-divider {
        margin: 0.25rem 0 0.25rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid #e7eef8;
    }

    .branch-form .section-divider-title {
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--summary-blue, #0f3b78);
        margin-bottom: 0;
    }
</style>

<div class="branch-form">
    <div class="section-divider">
        <p class="section-divider-title">Branch Assignment</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Business Unit</div>
                <label for="business_unit_id" class="form-label">Business Unit</label>
                <select name="business_unit_id" id="business_unit_id" class="form-select" required>
                    <option value="">Select Business Unit</option>
                    @foreach($businessUnits as $businessUnit)
                        <option value="{{ $businessUnit->id }}"
                            {{ old('business_unit_id', $branch->business_unit_id ?? '') == $businessUnit->id ? 'selected' : '' }}>
                            {{ $businessUnit->name }} ({{ $businessUnit->code }})
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Assign this branch to the correct business unit.</div>
                @error('business_unit_id')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Location</div>
                <label for="location_id" class="form-label">Location</label>
                <select name="location_id" id="location_id" class="form-select" required>
                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('location_id', $branch->location_id ?? '') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} ({{ $location->code }})
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Choose the location linked to this branch record.</div>
                @error('location_id')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Branch Identity</div>
                <label for="code" class="form-label">Branch Code</label>
                <input type="text" name="code" id="code" class="form-control"
                       value="{{ old('code', $branch->code ?? '') }}" required>
                <div class="form-hint">Use the official branch code used in operations and reporting.</div>
                @error('code')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Display Settings</div>
                <label for="display_name" class="form-label">Display Name</label>
                <input type="text" name="display_name" id="display_name" class="form-control"
                       value="{{ old('display_name', $branch->display_name ?? '') }}" required>
                <div class="form-hint">This name will appear in dashboards, reports, and filters.</div>
                @error('display_name')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Area Information</div>
                <label for="area_barangay" class="form-label">Area / Barangay</label>
                <input type="text" name="area_barangay" id="area_barangay" class="form-control"
                       value="{{ old('area_barangay', $branch->area_barangay ?? '') }}">
                <div class="form-hint">Optional area or barangay reference for the branch.</div>
                @error('area_barangay')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Spreadsheet Mapping</div>
                <label for="spreadsheet_sheet_name" class="form-label">Spreadsheet Sheet Name</label>
                <input type="text" name="spreadsheet_sheet_name" id="spreadsheet_sheet_name" class="form-control"
                       value="{{ old('spreadsheet_sheet_name', $branch->spreadsheet_sheet_name ?? '') }}">
                <div class="form-hint">Match the source workbook sheet name exactly if this branch uses imports.</div>
                @error('spreadsheet_sheet_name')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="section-divider mt-4">
        <p class="section-divider-title">Branch Status and Dates</p>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="field-card">
                <div class="field-card-title">Status</div>
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    @foreach(['active' => 'Active', 'inactive' => 'Inactive', 'closed' => 'Closed'] as $value => $label)
                        <option value="{{ $value }}"
                            {{ old('status', $branch->status ?? 'active') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Set the operating status of the branch record.</div>
                @error('status')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="field-card">
                <div class="field-card-title">Opening Date</div>
                <label for="opened_at" class="form-label">Opened Date</label>
                <input type="date" name="opened_at" id="opened_at" class="form-control"
                       value="{{ old('opened_at', isset($branch->opened_at) ? $branch->opened_at->format('Y-m-d') : '') }}">
                <div class="form-hint">Optional opening date for this branch.</div>
                @error('opened_at')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="field-card">
                <div class="field-card-title">Closure Date</div>
                <label for="closed_at" class="form-label">Closed Date</label>
                <input type="date" name="closed_at" id="closed_at" class="form-control"
                       value="{{ old('closed_at', isset($branch->closed_at) ? $branch->closed_at->format('Y-m-d') : '') }}">
                <div class="form-hint">Set only when a branch is formally closed.</div>
                @error('closed_at')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="section-divider mt-4">
        <p class="section-divider-title">Allowed Product Lines</p>
    </div>

    <div class="col-12 p-0">
        <label class="form-label d-block">Allowed Product Lines</label>

        <div class="product-lines-box">
            <div class="row">
                @php
                    $selectedProductLines = old(
                        'product_line_ids',
                        isset($branch) ? $branch->productLines->pluck('id')->toArray() : []
                    );
                @endphp

                @foreach($productLines as $productLine)
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="product_line_ids[]"
                                value="{{ $productLine->id }}"
                                id="product_line_{{ $productLine->id }}"
                                {{ in_array($productLine->id, $selectedProductLines) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="product_line_{{ $productLine->id }}">
                                {{ $productLine->name }} ({{ $productLine->code }})
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-hint">Choose which product lines are valid for this branch.</div>
        </div>

        @error('product_line_ids')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
        @error('product_line_ids.*')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="section-divider mt-4">
        <p class="section-divider-title">Additional Notes</p>
    </div>

    <div class="col-12 p-0">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea name="remarks" id="remarks" rows="4" class="form-control">{{ old('remarks', $branch->remarks ?? '') }}</textarea>
        <div class="form-hint">Optional notes for administrative or operational reference.</div>
        @error('remarks')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>