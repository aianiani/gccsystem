<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Management App') }} - Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-black: #0a0a0a;
            --secondary-black: #1a1a1a;
            --tertiary-black: #2a2a2a;
            --primary-white: #ffffff;
            --light-gray: #f5f5f5;
            --medium-gray: #9ca3af;
            --dark-gray: #6b7280;
            --border-gray: #e5e7eb;
            --focus-gray: #374151;
            --error-red: #dc2626;
            --shadow-light: rgba(0, 0, 0, 0.04);
            --shadow-medium: rgba(0, 0, 0, 0.1);
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; padding: 0; }
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-weight: 400;
            line-height: 1.6;
            color: var(--primary-black);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .login-card {
            background: var(--primary-white);
            border-radius: 16px;
            box-shadow: 
                0 1px 3px var(--shadow-light),
                0 20px 40px var(--shadow-medium),
                0 0 0 1px rgba(0, 0, 0, 0.02);
            width: 100%;
            max-width: 400px;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-black) 0%, var(--tertiary-black) 100%);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .login-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--primary-black);
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.025em;
        }
        .login-subtitle {
            font-size: 0.875rem;
            color: var(--dark-gray);
            font-weight: 400;
            margin: 0;
        }
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--primary-black);
            margin-bottom: 0.5rem;
            letter-spacing: 0.01em;
        }
        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 0.9375rem;
            font-weight: 400;
            color: var(--primary-black);
            background: var(--primary-white);
            border: 1.5px solid var(--border-gray);
            border-radius: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: var(--focus-gray);
            box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);
            background: var(--primary-white);
        }
        .form-control.is-invalid {
            border-color: var(--error-red);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
        .form-control::placeholder {
            color: var(--medium-gray);
            font-weight: 400;
        }
        .password-group { position: relative; }
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--medium-gray);
            font-size: 1.125rem;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: color 0.2s ease;
        }
        .password-toggle:hover { color: var(--dark-gray); }
        .login-button {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--primary-white);
            background: var(--primary-black);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.01em;
            position: relative;
            overflow: hidden;
        }
        .login-button:hover {
            background: var(--secondary-black);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .login-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-gray);
        }
        .login-footer p {
            font-size: 0.875rem;
            color: var(--dark-gray);
            margin: 0;
        }
        .login-footer a {
            color: var(--primary-black);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }
        .login-footer a:hover {
            color: var(--secondary-black);
            text-decoration: underline;
        }
        .invalid-feedback {
            display: block;
            color: var(--error-red);
            font-size: 0.8125rem;
            font-weight: 400;
            margin-top: 0.375rem;
            line-height: 1.4;
        }
        @media (max-width: 480px) {
            .login-container { padding: 1rem 0.75rem; }
            .login-card { padding: 2rem 1.5rem; border-radius: 12px; }
            .login-title { font-size: 1.5rem; }
        }
        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        .form-control:focus-visible,
        .login-button:focus-visible {
            outline: 2px solid var(--focus-gray);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Create your account</h1>
                <p class="login-subtitle">Sign up to get started</p>
            </div>
            <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter your name" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Create a password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()" tabindex="-1">
                            <i class="bi bi-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <div class="password-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required>
                        <button type="button" class="password-toggle" onclick="togglePasswordConfirm()" tabindex="-1">
                            <i class="bi bi-eye" id="password-confirm-icon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="login-button">
                    Sign up
                </button>
            </form>
            <div class="login-footer">
                <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        }
        function togglePasswordConfirm() {
            const passwordInput = document.getElementById('password-confirm');
            const passwordIcon = document.getElementById('password-confirm-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        }
        // SweetAlert2 Toast Notification
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: @json(session('success')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @elseif(session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: @json(session('error')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @elseif(session('warning'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: @json(session('warning')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @elseif(session('info'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: @json(session('info')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        });
    </script>
</body>
</html> 