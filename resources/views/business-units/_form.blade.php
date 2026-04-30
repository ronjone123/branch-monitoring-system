<style>
    .business-unit-form .form-label {
        font-weight: 700;
        color: var(--summary-text, #162033);
        margin-bottom: 0.45rem;
    }

    .business-unit-form .form-control,
    .business-unit-form .form-select {
        border-radius: 0.85rem;
        border: 1px solid var(--summary-border, #cfd9ea);
        padding: 0.8rem 0.95rem;
        box-shadow: none;
        color: var(--summary-text, #162033);
        background: #fff;
    }

    .business-unit-form .form-control:focus,
    .business-unit-form .form-select:focus {
        border-color: #7aa7e8;
        box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
    }

    .business-unit-form .form-hint {
        font-size: 0.82rem;
        color: var(--summary-muted, #6b7280);
        margin-top: 0.35rem;
    }

    .business-unit-form .field-card {
        background: #fff;
        border: 1px solid var(--summary-border, #cfd9ea);
        border-radius: 0.9rem;
        padding: 1rem;
        height: 100%;
    }

    .business-unit-form .field-card-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--summary-muted, #6b7280);
        margin-bottom: 0.8rem;
    }

    .business-unit-form .section-divider {
        margin: 0.25rem 0 0.25rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid #e7eef8;
    }

    .business-unit-form .section-divider-title {
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--summary-blue, #0f3b78);
        margin-bottom: 0;
    }
</style>

<div class="business-unit-form">
    <div class="section-divider">
        <p class="section-divider-title">Business Unit Identity</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Unit Code</div>
                <label for="code" class="form-label">Code</label>
                <input type="text" name="code" id="code" class="form-control"
                       value="{{ old('code', $businessUnit->code ?? '') }}" required>
                <div class="form-hint">Use a short official code for this business unit.</div>
                @error('code')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Unit Name</div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $businessUnit->name ?? '') }}" required>
                <div class="form-hint">This name appears in reports, dashboards, and branch assignments.</div>
                @error('name')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-12">
            <div class="field-card">
                <div class="field-card-title">Description</div>
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $businessUnit->description ?? '') }}</textarea>
                <div class="form-hint">Optional background or purpose of this business unit.</div>
                @error('description')
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
                            {{ old('status', $businessUnit->status ?? 'active') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Set whether this business unit is currently active in operations.</div>
                @error('status')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>