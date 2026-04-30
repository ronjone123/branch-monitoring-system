<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --summary-blue: #0f3b78;
            --summary-blue-dark: #0b2f60;
            --summary-border: #cfd9ea;
            --summary-bg: #f4f7fb;
            --summary-card-bg: #ffffff;
            --summary-text: #162033;
            --summary-muted: #6b7280;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #eef4fb 0%, #f8fbff 100%);
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif;
        }

        .login-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1180px;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            background: #fff;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(15, 59, 120, 0.14);
            border: 1px solid #dce7f5;
        }

        .login-brand-panel {
            background: linear-gradient(135deg, var(--summary-blue-dark), var(--summary-blue));
            color: #fff;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 680px;
        }

        .login-logo-wrap {
            margin-bottom: 2rem;
        }

        .login-logo {
            height: 64px;
            width: auto;
            display: block;
            background: rgba(255,255,255,0.12);
            padding: 0.5rem 0.75rem;
            border-radius: 1rem;
        }

        .login-brand-kicker {
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.72);
            margin-bottom: 0.9rem;
        }

        .login-brand-title {
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1.08;
            margin-bottom: 1rem;
        }

        .login-brand-subtitle {
            font-size: 1rem;
            color: rgba(255,255,255,0.82);
            line-height: 1.7;
            max-width: 520px;
        }

        .login-feature-list {
            margin-top: 2.25rem;
            display: grid;
            gap: 1rem;
        }

        .login-feature-item {
            display: flex;
            gap: 0.85rem;
            align-items: flex-start;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 1rem;
            padding: 1rem;
        }

        .login-feature-icon {
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            flex-shrink: 0;
        }

        .login-feature-title {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        .login-feature-text {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.76);
            line-height: 1.5;
        }

        .login-form-panel {
            background: #fff;
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form-wrap {
            width: 100%;
            max-width: 430px;
        }

        .login-form-kicker {
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--summary-blue);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.75rem;
        }

        .login-form-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--summary-text);
            margin-bottom: 0.5rem;
        }

        .login-form-subtitle {
            color: var(--summary-muted);
            font-size: 0.96rem;
            margin-bottom: 2rem;
        }

        .login-form-wrap label {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--summary-text);
        }

        .login-form-wrap input[type="email"],
        .login-form-wrap input[type="password"] {
            border-radius: 0.95rem !important;
            border: 1px solid var(--summary-border) !important;
            background: #fff !important;
            padding: 0.85rem 1rem !important;
            box-shadow: none !important;
            color: var(--summary-text) !important;
        }

        .login-form-wrap input[type="email"]:focus,
        .login-form-wrap input[type="password"]:focus {
            border-color: #7aa7e8 !important;
            box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08) !important;
        }

        .login-form-wrap input[type="checkbox"] {
            border-radius: 0.35rem;
            border-color: #b8c8dd;
        }

        .login-links {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1rem;
        }

        .login-links a {
            color: var(--summary-blue);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .login-links a:hover {
            color: var(--summary-blue-dark);
            text-decoration: underline;
        }

        .login-submit-btn {
            width: 100%;
            justify-content: center;
            border-radius: 999px !important;
            background: var(--summary-blue) !important;
            border: 1px solid var(--summary-blue) !important;
            color: #fff !important;
            padding: 0.9rem 1.2rem !important;
            font-size: 0.95rem;
            font-weight: 800 !important;
            letter-spacing: 0.01em;
            box-shadow: 0 10px 22px rgba(15, 59, 120, 0.14);
            margin-top: 1.5rem;
        }

        .login-submit-btn:hover {
            background: var(--summary-blue-dark) !important;
            border-color: var(--summary-blue-dark) !important;
        }

        .login-session-status {
            margin-bottom: 1rem;
        }

        @media (max-width: 991.98px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }

            .login-brand-panel {
                min-height: auto;
                padding: 2rem;
            }

            .login-form-panel {
                padding: 2rem 1.5rem;
            }

            .login-brand-title {
                font-size: 2rem;
            }

            .login-form-title {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-shell">
        <div class="login-wrapper">
            <div class="login-brand-panel">
                <div class="login-logo-wrap">
                    <img src="/images/logo.png" alt="RGC Logo" class="login-logo">
                </div>

                <div class="login-brand-kicker">Branch Monitoring System</div>
                <div class="login-brand-title">
                    Welcome back to your operations dashboard
                </div>
                <div class="login-brand-subtitle">
                    Monitor branch performance, review imported transactions, manage conflict records,
                    and keep reporting aligned in one centralized internal system.
                </div>

                <div class="login-feature-list">
                    <div class="login-feature-item">
                        <div class="login-feature-icon">1</div>
                        <div>
                            <div class="login-feature-title">Centralized Monitoring</div>
                            <div class="login-feature-text">
                                Track branch reporting, transaction summaries, and import activity in one place.
                            </div>
                        </div>
                    </div>

                    <div class="login-feature-item">
                        <div class="login-feature-icon">2</div>
                        <div>
                            <div class="login-feature-title">Import and Validation Workflow</div>
                            <div class="login-feature-text">
                                Upload files, review sheets, resolve conflicts, and validate imported transaction data.
                            </div>
                        </div>
                    </div>

                    <div class="login-feature-item">
                        <div class="login-feature-icon">3</div>
                        <div>
                            <div class="login-feature-title">Role-Based Access</div>
                            <div class="login-feature-text">
                                Give viewers, importers, admins, and super admins the tools they need securely.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login-form-panel">
                <div class="login-form-wrap">
                    <div class="login-form-kicker">Sign In</div>
                    <div class="login-form-title">Account Login</div>
                    <div class="login-form-subtitle">
                        Enter your credentials to access the system.
                    </div>

                    <div class="login-session-status">
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input
                                id="email"
                                class="block mt-2 w-full"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input
                                id="password"
                                class="block mt-2 w-full"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    name="remember"
                                >
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="login-links">
                            <div></div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        <x-primary-button class="login-submit-btn">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>