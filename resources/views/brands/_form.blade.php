<style>
    .brand-form .form-label {
        font-weight: 700;
        color: var(--summary-text, #162033);
        margin-bottom: 0.45rem;
    }

    .brand-form .form-control,
    .brand-form .form-select {
        border-radius: 0.85rem;
        border: 1px solid var(--summary-border, #cfd9ea);
        padding: 0.8rem 0.95rem;
        box-shadow: none;
        color: var(--summary-text, #162033);
        background: #fff;
    }

    .brand-form .form-control:focus,
    .brand-form .form-select:focus {
        border-color: #7aa7e8;
        box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
    }

    .brand-form .form-hint {
        font-size: 0.82rem;
        color: var(--summary-muted, #6b7280);
        margin-top: 0.35rem;
    }

    .brand-form .field-card {
        background: #fff;
        border: 1px solid var(--summary-border, #cfd9ea);
        border-radius: 0.9rem;
        padding: 1rem;
        height: 100%;
    }

    .brand-form .field-card-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--summary-muted, #6b7280);
        margin-bottom: 0.8rem;
    }

    .brand-form .section-divider {
        margin: 0.25rem 0 0.25rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid #e7eef8;
    }

    .brand-form .section-divider-title {
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--summary-blue, #0f3b78);
        margin-bottom: 0;
    }
</style>

<div class="brand-form">
    <div class="section-divider">
        <p class="section-divider-title">Brand Identity</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Product Line Assignment</div>
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
                <div class="form-hint">Optionally assign this brand to a specific product line.</div>
                @error('product_line_id')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Brand Code</div>
                <label for="code" class="form-label">Code</label>
                <input type="text" name="code" id="code" class="form-control"
                       value="{{ old('code', $brand->code ?? '') }}">
                <div class="form-hint">Optional short code used for internal grouping or reporting.</div>
                @error('code')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-8">
            <div class="field-card">
                <div class="field-card-title">Brand Name</div>
                <label for="name" class="form-label">Brand Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $brand->name ?? '') }}" required>
                <div class="form-hint">Use a clear and consistent brand name for imports and reports.</div>
                @error('name')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="field-card">
                <div class="field-card-title">Current Status</div>
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    @foreach(['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                        <option value="{{ $value }}"
                            {{ old('status', $brand->status ?? 'active') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Set whether this brand is currently active in the system.</div>
                @error('status')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>