<div class="row g-3">
    <div class="col-md-6">
        <label for="product_line_id" class="form-label">Product Line</label>
        <select name="product_line_id" id="product_line_id" class="form-select">
            <option value="">No specific product line</option>
            @foreach($productLines as $productLine)
                <option value="{{ $productLine->id }}"
                    {{ old('product_line_id', $brand->product_line_id ?? '') == $productLine->id ? 'selected' : '' }}>
                    {{ $productLine->name }} ({{ $productLine->code }})
                </option>
            @endforeach
        </select>
        @error('product_line_id')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="code" class="form-label">Code</label>
        <input type="text" name="code" id="code" class="form-control"
               value="{{ old('code', $brand->code ?? '') }}">
        @error('code')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label for="name" class="form-label">Brand Name</label>
        <input type="text" name="name" id="name" class="form-control"
               value="{{ old('name', $brand->name ?? '') }}" required>
        @error('name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            @foreach(['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                <option value="{{ $value }}"
                    {{ old('status', $brand->status ?? 'active') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
</div>