<style>
    .user-form .form-label {
        font-weight: 700;
        color: var(--summary-text, #162033);
        margin-bottom: 0.45rem;
    }

    .user-form .form-control,
    .user-form .form-select {
        border-radius: 0.85rem;
        border: 1px solid var(--summary-border, #cfd9ea);
        padding: 0.8rem 0.95rem;
        box-shadow: none;
        color: var(--summary-text, #162033);
        background: #fff;
    }

    .user-form .form-control:focus,
    .user-form .form-select:focus {
        border-color: #7aa7e8;
        box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
    }

    .user-form .form-hint {
        font-size: 0.82rem;
        color: var(--summary-muted, #6b7280);
        margin-top: 0.35rem;
    }

    .user-form .field-card {
        background: #fff;
        border: 1px solid var(--summary-border, #cfd9ea);
        border-radius: 0.9rem;
        padding: 1rem;
        height: 100%;
    }

    .user-form .field-card-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--summary-muted, #6b7280);
        margin-bottom: 0.8rem;
    }

    .user-form .section-divider {
        margin: 0.25rem 0 0.25rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid #e7eef8;
    }

    .user-form .section-divider-title {
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--summary-blue, #0f3b78);
        margin-bottom: 0;
    }
</style>

<div class="user-form">
    <div class="section-divider">
        <p class="section-divider-title">User Identity</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Full Name</div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $user->name ?? '') }}" required>
                <div class="form-hint">Use the user’s official name for account identification.</div>
                @error('name')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Email Address</div>
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email', $user->email ?? '') }}" required>
                <div class="form-hint">This email will be used for login and system identification.</div>
                @error('email')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="section-divider mt-4">
        <p class="section-divider-title">Access and Status</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Role Assignment</div>
                <label for="role_id" class="form-label">Role</label>
                <select name="role_id" id="role_id" class="form-select" required>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Assign the correct role to control system access and permissions.</div>
                @error('role_id')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Account Status</div>
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    @foreach(['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                        <option value="{{ $value }}"
                            {{ old('status', $user->status ?? 'active') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-hint">Set whether this user account is currently active in the system.</div>
                @error('status')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="section-divider mt-4">
        <p class="section-divider-title">Account Security</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Password</div>
                <label for="password" class="form-label">
                    Password {{ isset($user) && $user->exists ? '(leave blank to keep current)' : '' }}
                </label>
                <input type="password" name="password" id="password" class="form-control"
                       {{ isset($user) && $user->exists ? '' : 'required' }}>
                <div class="form-hint">
                    {{ isset($user) && $user->exists
                        ? 'Leave this blank if you do not want to change the current password.'
                        : 'Create a secure password for the new user account.' }}
                </div>
                @error('password')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="field-card">
                <div class="field-card-title">Password Confirmation</div>
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                       {{ isset($user) && $user->exists ? '' : 'required' }}>
                <div class="form-hint">Re-enter the password to confirm the account credentials.</div>
            </div>
        </div>
    </div>
</div>