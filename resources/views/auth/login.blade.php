@extends('layouts.auth')

@section('content')
<div class="login-container">
    <div class="login-grid">
        <!-- Left Panel - Branding -->
        <div class="login-brand">
            <div class="brand-content">
                <div class="brand-logo">
                    <div class="logo-icon">
                        @if(file_exists(public_path('assets/logo/logo.png')))
                            <img src="{{ asset('assets/logo/logo.png') }}" alt="Special Touch Logo" class="logo-img">
                        @else
                            <i class="fas fa-car"></i>
                        @endif
                    </div>
                    <div>
                        <div class="brand-name">Special Touch</div>
                        <div class="brand-sub">CAR CARE</div>
                    </div>
                </div>

                <div class="brand-middle">
                    <h1 class="brand-title">Welcome Back</h1>
                    <p class="brand-desc">Sign in to manage your workshop, track repairs, and serve your customers better.</p>

                    <div class="brand-features">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-check"></i></div>
                            <span>Workshop Management</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-check"></i></div>
                            <span>Customer Tracking</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-check"></i></div>
                            <span>Real-time Analytics</span>
                        </div>
                    </div>
                </div>

                <div class="brand-footer">
                    <p>&copy; 2024 Special Touch Car Care. All rights reserved.</p>
                </div>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="login-form-panel">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Sign In</h2>
                    <p>Enter your credentials to access your dashboard</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            required
                            autofocus
                            class="form-control @error('email') is-invalid @enderror"
                        >
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-input-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                class="form-control @error('password') is-invalid @enderror"
                            >
                            <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span class="label-text">Remember me</span>
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span class="btn-text">Sign In</span>
                        <span class="btn-loader" style="display:none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </form>

                <div class="form-footer">
                    <p>Don't have an account? <a href="#">Contact support</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    /* ===== Login Page Styles ===== */
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--surface, #F0F4F9);
        padding: 20px;
    }

    .login-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1100px;
        width: 100%;
        background: #FFFFFF;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(14, 32, 56, 0.16);
        overflow: hidden;
        min-height: 600px;
    }

    /* ===== Left Panel ===== */
    .login-brand {
        background: linear-gradient(135deg, #142B4C 0%, #0E2038 100%);
        padding: 48px 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .login-brand::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
        pointer-events: none;
    }

    .login-brand::after {
        content: '\f1b9';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        bottom: -30px;
        right: -30px;
        font-size: 180px;
        color: rgba(255,255,255,0.03);
        pointer-events: none;
    }

    .brand-content {
        position: relative;
        z-index: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .brand-logo .logo-icon {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,0.12);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: #fff;
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(4px);
        overflow: hidden;
        flex-shrink: 0;
    }

    .brand-logo .logo-icon .logo-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 8px;
    }

    .brand-logo .brand-name {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.02em;
        line-height: 1.1;
    }

    .brand-logo .brand-sub {
        color: rgba(255,255,255,0.5);
        font-size: 12px;
        font-weight: 400;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .brand-middle {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px 0;
    }

    .brand-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 36px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 8px;
        letter-spacing: -0.02em;
    }

    .brand-desc {
        color: rgba(255,255,255,0.6);
        font-size: 15px;
        line-height: 1.6;
        max-width: 340px;
        margin-bottom: 32px;
    }

    .brand-features {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255,255,255,0.7);
        font-size: 14px;
        font-weight: 400;
    }

    .feature-item .feature-icon {
        width: 24px;
        height: 24px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-item .feature-icon i {
        color: #5AA7E0;
        font-size: 12px;
    }

    .brand-footer {
        color: rgba(255,255,255,0.25);
        font-size: 12px;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }

    /* ===== Right Panel ===== */
    .login-form-panel {
        padding: 48px 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
    }

    .form-wrapper {
        width: 100%;
        max-width: 380px;
    }

    .form-header {
        margin-bottom: 32px;
    }

    .form-header h2 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #0E2038;
        margin: 0 0 6px;
    }

    .form-header p {
        color: #8A9BAE;
        font-size: 14px;
        margin: 0;
    }

    /* Alert */
    .alert {
        padding: 14px 18px;
        border-radius: 8px;
        background: #FEE2E2;
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .alert i {
        font-size: 16px;
    }

    /* Form */
    .login-form .form-group {
        margin-bottom: 20px;
    }

    .login-form .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #4A5B6E;
        margin-bottom: 6px;
    }

    .login-form .form-group label i {
        color: #8A9BAE;
        font-size: 14px;
        width: 16px;
    }

    .login-form .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E8EDF4;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: #0E2038;
        background: #F0F4F9;
        transition: all 0.3s ease;
    }

    .login-form .form-control:focus {
        outline: none;
        border-color: #5AA7E0;
        box-shadow: 0 0 0 4px rgba(90, 167, 224, 0.1);
        background: #fff;
    }

    .login-form .form-control.is-invalid {
        border-color: #EF4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .login-form .form-control::placeholder {
        color: #8A9BAE;
        font-weight: 400;
    }

    .error-message {
        display: block;
        color: #EF4444;
        font-size: 12px;
        font-weight: 500;
        margin-top: 4px;
    }

    /* Password Toggle */
    .password-input-wrapper {
        position: relative;
    }

    .password-input-wrapper .form-control {
        padding-right: 48px;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #8A9BAE;
        cursor: pointer;
        padding: 6px;
        font-size: 16px;
        transition: color 0.2s ease;
        border-radius: 4px;
    }

    .toggle-password:hover {
        color: #0E2038;
    }

    /* Form Options */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 24px 0 28px;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 13px;
        color: #4A5B6E;
        font-weight: 500;
        position: relative;
    }

    .checkbox-label input {
        display: none;
    }

    .checkbox-label .checkmark {
        width: 18px;
        height: 18px;
        border: 2px solid #E8EDF4;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .checkbox-label input:checked + .checkmark {
        background: #2D5F96;
        border-color: #2D5F96;
    }

    .checkbox-label input:checked + .checkmark::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        color: #fff;
        font-size: 11px;
    }

    .checkbox-label .label-text {
        user-select: none;
    }

    .forgot-link {
        font-size: 13px;
        color: #5AA7E0;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .forgot-link:hover {
        color: #2D5F96;
    }

    /* Login Button */
    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #142B4C 0%, #0E2038 100%);
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(20, 43, 76, 0.3);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .btn-login .btn-loader {
        font-size: 18px;
    }

    /* Form Footer */
    .form-footer {
        margin-top: 28px;
        text-align: center;
        font-size: 14px;
        color: #8A9BAE;
    }

    .form-footer a {
        color: #5AA7E0;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .form-footer a:hover {
        color: #2D5F96;
    }

    /* ===== Responsive ===== */
    @media (max-width: 992px) {
        .login-grid {
            grid-template-columns: 1fr;
            max-width: 480px;
            min-height: auto;
        }

        .login-brand {
            padding: 32px 28px;
            min-height: 200px;
        }

        .brand-title {
            font-size: 28px;
        }

        .brand-desc {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .brand-middle {
            padding: 16px 0;
        }

        .brand-footer {
            margin-top: 16px;
            padding-top: 16px;
        }

        .login-form-panel {
            padding: 32px 28px;
        }

        .form-header h2 {
            font-size: 24px;
        }

        .login-brand::after {
            font-size: 120px;
            bottom: -20px;
            right: -20px;
        }
    }

    @media (max-width: 480px) {
        .login-container {
            padding: 12px;
        }

        .login-brand {
            padding: 24px 20px;
            min-height: 160px;
        }

        .brand-logo .logo-icon {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }

        .brand-logo .brand-name {
            font-size: 20px;
        }

        .brand-title {
            font-size: 22px;
        }

        .brand-desc {
            font-size: 13px;
        }

        .login-form-panel {
            padding: 24px 18px;
        }

        .form-header h2 {
            font-size: 20px;
        }

        .form-header p {
            font-size: 13px;
        }

        .form-options {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== Password Toggle =====
        const toggleBtns = document.querySelectorAll('.toggle-password');
        toggleBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // ===== Form Submit Loading State =====
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        const btnText = loginBtn.querySelector('.btn-text');
        const btnLoader = loginBtn.querySelector('.btn-loader');

        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                loginBtn.disabled = true;
                btnText.textContent = 'Signing In...';
                btnLoader.style.display = 'inline-block';
            });
        }

        // ===== Input Focus Effects =====
        const inputs = document.querySelectorAll('.login-form .form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                const label = this.closest('.form-group')?.querySelector('label');
                if (label) label.style.color = '#2D5F96';
            });
            input.addEventListener('blur', function() {
                const label = this.closest('.form-group')?.querySelector('label');
                if (label) label.style.color = '';
            });
        });
    });
</script>
@endpush
