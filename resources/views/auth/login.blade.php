<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Management App') }} - Login</title>

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

        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

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

        .password-group {
            position: relative;
        }

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

        .password-toggle:hover {
            color: var(--dark-gray);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 1rem;
            height: 1rem;
            border: 1.5px solid var(--border-gray);
            border-radius: 3px;
            background: var(--primary-white);
            cursor: pointer;
            margin: 0;
            transition: all 0.2s ease;
        }

        .form-check-input:checked {
            background-color: var(--primary-black);
            border-color: var(--primary-black);
        }

        .form-check-label {
            font-size: 0.875rem;
            color: var(--dark-gray);
            font-weight: 400;
            cursor: pointer;
            user-select: none;
        }

        .forgot-password {
            font-size: 0.875rem;
            color: var(--dark-gray);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--primary-black);
            text-decoration: underline;
        }

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

        /* Responsive design */
        @media (max-width: 480px) {
            .login-container {
                padding: 1rem 0.75rem;
            }

            .login-card {
                padding: 2rem 1.5rem;
                border-radius: 12px;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        /* Loading state */
        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Focus visible for accessibility */
        .form-control:focus-visible,
        .login-button:focus-visible,
        .form-check-input:focus-visible {
            outline: 2px solid var(--focus-gray);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Welcome back</h1>
                <p class="login-subtitle">Sign in to your account to continue</p>
            </div>

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input 
                        id="email" 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-group">
                        <input 
                            id="password" 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" 
                            placeholder="Enter your password"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()" tabindex="-1">
                            <i class="bi bi-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="login-button">
                    Sign in
                </button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="{{ route('register') }}">Create account</a></p>
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