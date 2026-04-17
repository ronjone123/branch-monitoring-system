<div class="row g-3">
    <div class="col-md-6">
        <label for="code" class="form-label">Code</label>
        <input type="text" name="code" id="code" class="form-control"
               value="{{ old('code', $location->code ?? '') }}" required>
        @error('code')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control"
               value="{{ old('name', $location->name ?? '') }}" required>
        @error('name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="city_or_municipality" class="form-label">City / Municipality</label>
        <input type="text" name="city_or_municipality" id="city_or_municipality" class="form-control"
               value="{{ old('city_or_municipality', $location->city_or_municipality ?? '') }}">
        @error('city_or_municipality')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="province" class="form-label">Province</label>
        <input type="text" name="province" id="province" class="form-control"
               value="{{ old('province', $location->province ?? '') }}">
        @error('province')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            @foreach(['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                <option value="{{ $value }}"
                    {{ old('status', $location->status ?? 'active') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ old('remarks', $location->remarks ?? '') }}</textarea>
        @error('remarks')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
</div>