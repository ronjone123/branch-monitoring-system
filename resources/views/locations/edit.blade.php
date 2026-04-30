<x-app-layout>
    <style>
        :root {
            --summary-blue: #0f3b78;
            --summary-blue-dark: #0b2f60;
            --summary-border: #cfd9ea;
            --summary-bg: #f4f7fb;
            --summary-card-bg: #ffffff;
            --summary-text: #162033;
            --summary-muted: #6b7280;
            --summary-info-bg: #eaf4ff;
            --summary-info-text: #175cd3;
        }

        body {
            background: var(--summary-bg);
        }

        .summary-shell {
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-with-fixed-nav {
            padding-top: 6.5rem;
        }

        .summary-hero {
            background: linear-gradient(135deg, var(--summary-blue-dark), var(--summary-blue));
            border-radius: 1.25rem;
            overflow: hidden;
            color: #fff;
            box-shadow: 0 18px 40px rgba(15, 59, 120, 0.12);
        }

        .summary-hero-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .summary-date-box {
            min-width: 220px;
            background: rgba(255, 255, 255, 0.10);
            border-left: 1px solid rgba(255, 255, 255, 0.15);
        }

        .summary-date-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.85;
            letter-spacing: 0.04em;
        }

        .summary-date-value {
            font-size: 1.2rem;
            font-weight: 800;
            margin-top: 0.35rem;
            text-align: center;
        }

        .summary-card {
            background: var(--summary-card-bg);
            border: 1px solid var(--summary-border);
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(15, 59, 120, 0.06);
            overflow: hidden;
        }

        .summary-section-header {
            background: var(--summary-blue);
            color: #fff;
            padding: 1rem 1.25rem;
        }

        .summary-section-header h5 {
            margin: 0;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 1rem;
            letter-spacing: 0.02em;
        }

        .summary-section-subtitle {
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.88rem;
            margin-top: 0.25rem;
        }

        .form-panel {
            padding: 1.5rem;
        }

        .btn-summary-primary {
            background: var(--summary-blue);
            border-color: var(--summary-blue);
            color: #fff;
            border-radius: 999px;
            font-weight: 700;
            padding: 0.7rem 1.2rem;
        }

        .btn-summary-primary:hover {
            background: var(--summary-blue-dark);
            border-color: var(--summary-blue-dark);
            color: #fff;
        }

        .btn-summary-outline {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.7rem 1.2rem;
        }

        .helper-box {
            background: var(--summary-info-bg);
            color: var(--summary-info-text);
            border: 1px solid #cfe1ff;
            border-radius: 0.9rem;
            padding: 1rem 1.1rem;
        }

        .helper-box-title {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-bottom: 0.45rem;
        }

        .helper-box ul {
            margin: 0;
            padding-left: 1.1rem;
        }

        .helper-box li {
            margin-bottom: 0.3rem;
        }

        .meta-card {
            background: #fff;
            border: 1px solid var(--summary-border);
            border-radius: 0.9rem;
            padding: 1rem 1.1rem;
        }

        .meta-label {
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--summary-muted);
            margin-bottom: 0.35rem;
            letter-spacing: 0.03em;
        }

        .meta-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--summary-text);
        }

        @media (max-width: 991.98px) {
            .summary-hero-title {
                font-size: 1.6rem;
            }

            .summary-date-box {
                min-width: 100%;
                border-left: 0;
                border-top: 1px solid rgba(255, 255, 255, 0.15);
            }
        }
    </style>

    <div class="summary-shell page-with-fixed-nav px-3 px-md-4 py-4">
        <div class="mb-4">
            <div class="summary-hero d-flex flex-column flex-lg-row justify-content-between align-items-stretch">
                <div class="flex-grow-1 p-4 p-lg-5">
                    <div class="summary-hero-title">Edit Location</div>
                    <div class="mt-2 text-white-50">
                        Update location identity, municipality, province, and operational status.
                    </div>
                </div>

                <div class="summary-date-box d-flex flex-column justify-content-center align-items-center px-4 py-4">
                    <div class="summary-date-label">Location Code</div>
                    <div class="summary-date-value">{{ $location->code ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>Edit Location Form</h5>
                        <div class="summary-section-subtitle">
                            Review and update the location information below.
                        </div>
                    </div>

                    <div class="form-panel">
                        <form action="{{ route('locations.update', $location) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('locations._form', ['location' => $location])

                            <div class="mt-4 d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-summary-primary">Update Location</button>
                                <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary btn-summary-outline">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="meta-card mb-4">
                    <div class="meta-label">Current Code</div>
                    <div class="meta-value">{{ $location->code ?? '-' }}</div>
                </div>

                <div class="meta-card mb-4">
                    <div class="meta-label">Current Name</div>
                    <div class="meta-value">{{ $location->name ?? '-' }}</div>
                </div>

                <div class="meta-card mb-4">
                    <div class="meta-label">Current Status</div>
                    <div class="meta-value">{{ ucfirst($location->status ?? 'active') }}</div>
                </div>

                <div class="helper-box mb-4">
                    <div class="helper-box-title">Edit Guidance</div>
                    <ul>
                        <li>Keep the location code stable if it is already used by branch records.</li>
                        <li>Review name, municipality, and province carefully before saving updates.</li>
                        <li>Status changes may affect location availability in admin forms and reporting.</li>
                    </ul>
                </div>

                <div class="summary-card">
                    <div class="summary-section-header">
                        <h5>Why Review Matters</h5>
                        <div class="summary-section-subtitle">
                            Location records affect branch assignment, reporting structure, and admin consistency.
                        </div>
                    </div>

                    <div class="form-panel">
                        <div class="mb-3">
                            <div class="fw-bold mb-1">Branch Mapping</div>
                            <div class="text-muted small">
                                Branches rely on valid location records for accurate master data setup.
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-bold mb-1">Reporting Impact</div>
                            <div class="text-muted small">
                                Location data helps organize system filters, groupings, and reporting structure.
                            </div>
                        </div>

                        <div>
                            <div class="fw-bold mb-1">Consistency</div>
                            <div class="text-muted small">
                                Standardized location records improve administrative accuracy across the platform.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>