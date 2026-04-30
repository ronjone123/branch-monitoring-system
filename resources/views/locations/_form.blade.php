<style>
    .location-form .form-label {
        font-weight: 700;
        color: var(--summary-text, #162033);
        margin-bottom: 0.45rem;
    }

    .location-form .form-control,
    .location-form .form-select {
        border-radius: 0.85rem;
        border: 1px solid var(--summary-border, #cfd9ea);
        padding: 0.8rem 0.95rem;
        box-shadow: none;
        color: var(--summary-text, #162033);
        background: #fff;
    }

    .location-form .form-control:focus,
    .location-form .form-select:focus {
        border-color: #7aa7e8;
        box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
    }

    .location-form .form-hint {
        font-size: 0.82rem;
        color: var(--summary-muted, #6b7280);
        margin-top: 0.35rem;
    }

    .location-form .field-card {
        background: #fff;
        border: 1px solid var(--summary-border, #cfd9ea);
        border-radius: 0.9rem;
        padding: 1rem;
        height: 100%;
    }

    .location-form .field-card-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--summary-muted, #6b7280);
        margin-bottom: 0.8rem;
    }

    .location-form .section-divider {
        margin: 0.25rem 0 0.25rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid #e7eef8;
    }

    .location-form .section-divider-title {
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--summary-blue, #0f3b78);
        margin-bottom: 0;
    }
</style>

<div class="location-form">
    <div class="section-divider">
        <p class="section-divider-title">Location Identity</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Location Code</div>
                <label for="code" class="form-label">Code</label>
                <input type="text" name="code" id="code" class="form-control"
                       value="{{ old('code', $location->code ?? '') }}" required>
                <div class="form-hint">Use the official short code for this location.</div>
                @error('code')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Location Name</div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $location->name ?? '') }}" required>
                <div class="form-hint">This name will be used in branch records and reporting filters.</div>
                @error('name')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Municipality</div>
                <label for="city_or_municipality" class="form-label">City / Municipality</label>
                <input type="text" name="city_or_municipality" id="city_or_municipality" class="form-control"
                       value="{{ old('city_or_municipality', $location->city_or_municipality ?? '') }}">
                <div class="form-hint">Optional city or municipality reference for this location.</div>
                @error('city_or_municipality')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Province</div>
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" id="province" class="form-control"
                       value="{{ old('province', $location->province ?? '') }}">
                <div class="form-hint">Optional province reference used for location grouping.</div>
                @error('province')
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
                            {{ old('status', $location->status ?? 'active') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Set whether this location is currently active in the system.</div>
                @error('status')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="section-divider mt-4">
        <p class="section-divider-title">Additional Notes</p>
    </div>

    <div class="col-12 p-0">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea name="remarks" id="remarks" rows="4" class="form-control">{{ old('remarks', $location->remarks ?? '') }}</textarea>
        <div class="form-hint">Optional notes for administrative reference.</div>
        @error('remarks')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>