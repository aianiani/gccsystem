<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GCC System') }} - Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><radialGradient id="grad1" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1);stop-opacity:1" /><stop offset="100%" style="stop-color:rgba(255,255,255,0);stop-opacity:1" /></radialGradient></defs><circle cx="20" cy="20" r="2" fill="url(%23grad1)"/><circle cx="80" cy="40" r="3" fill="url(%23grad1)"/><circle cx="40" cy="80" r="2" fill="url(%23grad1)"/><circle cx="90" cy="90" r="2" fill="url(%23grad1)"/><circle cx="10" cy="60" r="2" fill="url(%23grad1)"/></svg>');
            animation: float 8s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .main-container {
            max-width: 900px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
            overflow: hidden;
        }

        .back-button {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 10;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            color: #1e7e34;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: #1e7e34;
            text-decoration: none;
        }

        .content-wrapper {
            padding: 3rem;
            text-align: center;
           

            
        }

        .logo-section {
            margin-bottom: 3rem;
        }

        .logo {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 15px 35px rgba(30, 126, 52, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: linear-gradient(135deg, #f8fdf9 0%, #e8f5e8 100%);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: left;
            border: 1px solid rgba(30, 126, 52, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(135deg, #ffd700 0%, #ffed4a 100%);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(30, 126, 52, 0.2);
        }

        .feature-number {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4a 100%);
            color: #1e7e34;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .feature-text {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            line-height: 1.4;
        }

        .form-section {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            margin-top: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 126, 52, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 400;
        }

        .tab-buttons {
            display: flex;
            margin-bottom: 2rem;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 0.25rem;
            position: relative;
        }

        .tab-button {
            flex: 1;
            padding: 0.875rem 1rem;
            text-align: center;
            font-weight: 600;
            color: #6c757d;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .tab-button.active {
            color: white;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
            box-shadow: 0 4px 15px rgba(30, 126, 52, 0.3);
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-select,
        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
            color: #333;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: #1e7e34;
            box-shadow: 0 0 0 3px rgba(30, 126, 52, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control::placeholder {
            color: #6c757d;
        }

        .password-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.1rem;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #1e7e34;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 1.1rem;
            height: 1.1rem;
            border: 2px solid #e9ecef;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            margin: 0;
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background-color: #1e7e34;
            border-color: #1e7e34;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #6c757d;
            cursor: pointer;
            user-select: none;
        }

        .forgot-password {
            font-size: 0.9rem;
            color: #1e7e34;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #155724;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(30, 126, 52, 0.3);
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 126, 52, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .signup-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .signup-link a {
            color: #1e7e34;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.375rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 2rem 1.5rem;
            }

            .brand-title {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .form-section {
                padding: 2rem 1.5rem;
            }

            .back-button {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .content-wrapper {
                padding: 1.5rem 1rem;
            }

            .brand-title {
                font-size: 1.8rem;
            }

            .brand-subtitle {
                font-size: 1rem;
            }

            .form-section {
                padding: 1.5rem 1rem;
            }

            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .back-button {
                top: 1rem;
                left: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <a href="{{ route('home') }}" class="back-button">
            <i class="bi bi-arrow-left"></i> Back to Home
        </a>

        <div class="content-wrapper" >
            <!-- Logo and Brand Section -->
            <div class="logo-section">
                <div class="logo">
                    <div class="logo-text">GCC</div>
                </div>
                <h1 class="brand-title">CMU Guidance and<br>Counseling Center</h1>
                <p class="brand-subtitle">Welcome to the Web-Based Appointment Scheduling and Counseling Information System. Schedule appointments, access resources, and connect with counselors easily.</p>
            </div>


            <!-- Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <h2 class="form-title">Login Portal</h2>
                    <p class="form-subtitle">Sign in to access counseling services</p>
                </div>

                <div class="tab-buttons">
                    <a href="#" class="tab-button active">Login</a>
                    <a href="{{ route('register') }}" class="tab-button">Sign Up</a>
                </div>

                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
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
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                    </div>

                    <button type="submit" class="login-button">
                        Login
                    </button>
                </form>

                <div class="signup-link">
                    Don't have an account? <a href="{{ route('register') }}">Sign up here</a>
                </div>
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