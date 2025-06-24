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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --light-bg: #f8fafc;
            --dark-bg: #1e293b;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            color: var(--text-primary);
            line-height: 1.6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        body::before,
        body::after {
            content: '';
            position: fixed;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: var(--primary-color);
            opacity: 0.05;
            z-index: -1;
            animation: float 6s ease-in-out infinite;
        }

        body::before {
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        body::after {
            bottom: -150px;
            right: -150px;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            background: white;
            border: none;
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn {
            font-weight: 600;
            border-radius: 16px;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            width: 100%;
            padding: 1.125rem;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            width: 100%;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        .alert {
            border: none;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        .alert-success {
            background: #f0fdf4;
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }

        .alert-info {
            background: #f0f9ff;
            color: #0c4a6e;
            border-left: 4px solid var(--info-color);
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background: transparent;
            border: 2px solid var(--border-color);
            border-right: none;
            border-radius: 16px 0 0 16px;
            color: var(--text-secondary);
            padding: 1rem 1.25rem;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 16px 16px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color);
        }

        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
        }

        .divider span {
            background: white;
            padding: 0 1.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-floating .form-control {
            height: 60px;
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }

        .form-floating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 1.25rem;
            pointer-events: none;
            border: 1px solid transparent;
            transform-origin: 0 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            color: var(--text-secondary);
        }

        .form-floating .form-control:focus ~ label,
        .form-floating .form-control:not(:placeholder-shown) ~ label {
            opacity: 0.65;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }

        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 2rem;
            }
            
            .card-header {
                padding: 2rem 1.5rem;
            }

            .login-container {
                max-width: 100%;
                margin: 0 1rem;
            }
        }

        /* Loading animation for button */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container fade-in">
        <div class="card">
            <div class="card-header">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-20 rounded-circle mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-people-fill fs-1 text-white"></i>
                </div>
                <h2 class="fw-bold mb-2">Welcome Back</h2>
                <p class="mb-0 opacity-75">Sign in to your account</p>
            </div>
            
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div>
                                <strong>Error!</strong> {!! session('error') !!}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div>
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                            <div>
                                <strong>Info!</strong> {{ session('info') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <div class="form-floating">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="Enter your email">
                        <label for="email">
                            <i class="bi bi-envelope me-2"></i>Email Address
                        </label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="Enter your password">
                        <label for="password">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 text-end">
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Forgot Password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary mb-3" id="loginBtn">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>

                <div class="divider">
                    <span>Don't have an account?</span>
                </div>

                <a href="{{ route('register') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person-plus me-2"></i>Create Account
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Form submission loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('btn-loading');
            btn.disabled = true;
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Add focus animations
        document.querySelectorAll('.form-control').forEach(function(input) {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>
</html> 