<style>
    .product-line-form .form-label {
        font-weight: 700;
        color: var(--summary-text, #162033);
        margin-bottom: 0.45rem;
    }

    .product-line-form .form-control,
    .product-line-form .form-select {
        border-radius: 0.85rem;
        border: 1px solid var(--summary-border, #cfd9ea);
        padding: 0.8rem 0.95rem;
        box-shadow: none;
        color: var(--summary-text, #162033);
        background: #fff;
    }

    .product-line-form .form-control:focus,
    .product-line-form .form-select:focus {
        border-color: #7aa7e8;
        box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
    }

    .product-line-form .form-hint {
        font-size: 0.82rem;
        color: var(--summary-muted, #6b7280);
        margin-top: 0.35rem;
    }

    .product-line-form .field-card {
        background: #fff;
        border: 1px solid var(--summary-border, #cfd9ea);
        border-radius: 0.9rem;
        padding: 1rem;
        height: 100%;
    }

    .product-line-form .field-card-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--summary-muted, #6b7280);
        margin-bottom: 0.8rem;
    }

    .product-line-form .section-divider {
        margin: 0.25rem 0 0.25rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid #e7eef8;
    }

    .product-line-form .section-divider-title {
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--summary-blue, #0f3b78);
        margin-bottom: 0;
    }
</style>

<div class="product-line-form">
    <div class="section-divider">
        <p class="section-divider-title">Product Line Identity</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Product Line Code</div>
                <label for="code" class="form-label">Code</label>
                <input type="text" name="code" id="code" class="form-control"
                       value="{{ old('code', $productLine->code ?? '') }}" required>
                <div class="form-hint">Use the official short code for this product line.</div>
                @error('code')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Product Line Name</div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $productLine->name ?? '') }}" required>
                <div class="form-hint">This name will appear in branch setup, reports, and transaction references.</div>
                @error('name')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="section-divider mt-4">
        <p class="section-divider-title">Operational Status</p>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="field-card">
                <div class="field-card-title">Current Status</div>
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    @foreach(['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                        <option value="{{ $value }}"
                            {{ old('status', $productLine->status ?? 'active') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Set whether this product line is currently active in the system.</div>
                @error('status')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>