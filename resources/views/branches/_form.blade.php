<div class="row g-3">
    <div class="col-md-6">
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
        @error('business_unit_id')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
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
        @error('location_id')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="code" class="form-label">Branch Code</label>
        <input type="text" name="code" id="code" class="form-control"
               value="{{ old('code', $branch->code ?? '') }}" required>
        @error('code')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="display_name" class="form-label">Display Name</label>
        <input type="text" name="display_name" id="display_name" class="form-control"
               value="{{ old('display_name', $branch->display_name ?? '') }}" required>
        @error('display_name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="area_barangay" class="form-label">Area / Barangay</label>
        <input type="text" name="area_barangay" id="area_barangay" class="form-control"
               value="{{ old('area_barangay', $branch->area_barangay ?? '') }}">
        @error('area_barangay')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="spreadsheet_sheet_name" class="form-label">Spreadsheet Sheet Name</label>
        <input type="text" name="spreadsheet_sheet_name" id="spreadsheet_sheet_name" class="form-control"
               value="{{ old('spreadsheet_sheet_name', $branch->spreadsheet_sheet_name ?? '') }}">
        @error('spreadsheet_sheet_name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            @foreach(['active' => 'Active', 'inactive' => 'Inactive', 'closed' => 'Closed'] as $value => $label)
                <option value="{{ $value }}"
                    {{ old('status', $branch->status ?? 'active') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="opened_at" class="form-label">Opened Date</label>
        <input type="date" name="opened_at" id="opened_at" class="form-control"
               value="{{ old('opened_at', isset($branch->opened_at) ? $branch->opened_at->format('Y-m-d') : '') }}">
        @error('opened_at')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
    <label class="form-label d-block">Allowed Product Lines</label>

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

    @error('product_line_ids')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    @error('product_line_ids.*')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    </div>

    <div class="col-md-4">
        <label for="closed_at" class="form-label">Closed Date</label>
        <input type="date" name="closed_at" id="closed_at" class="form-control"
               value="{{ old('closed_at', isset($branch->closed_at) ? $branch->closed_at->format('Y-m-d') : '') }}">
        @error('closed_at')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ old('remarks', $branch->remarks ?? '') }}</textarea>
        @error('remarks')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
</div>