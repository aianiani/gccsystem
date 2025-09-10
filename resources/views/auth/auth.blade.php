<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GCC System') }} - Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --danger: #ef4444;
            --success: #10b981;
            --border: #e5e7eb;
            --bg: #f8fafc;
            --shadow: 0 8px 32px 0 rgba(31, 41, 55, 0.10);
        }
        body {
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .auth-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 370px;
            padding: 2.5rem 2rem 2rem 2rem;
            position: relative;
            animation: fadeIn 0.7s cubic-bezier(.39,.575,.56,1.000);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-title {
            font-weight: 700;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-tabs {
            display: flex;
            border-radius: 999px;
            background: #f1f5f9;
            margin-bottom: 2rem;
            position: relative;
            height: 44px;
        }
        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 0.7rem 0;
            font-weight: 600;
            color: #64748b;
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            z-index: 1;
            transition: color 0.2s;
        }
        .auth-tab.active {
            color: #fff;
        }
        .auth-tab-indicator {
            position: absolute;
            top: 4px;
            left: 4px;
            width: calc(50% - 8px);
            height: 36px;
            background: var(--primary);
            border-radius: 999px;
            transition: transform 0.35s cubic-bezier(.39,.575,.56,1.000);
            z-index: 0;
        }
        .auth-tab-indicator.signup {
            transform: translateX(100%);
        }
        .auth-tab-indicator.login {
            transform: translateX(0);
        }
        .auth-form {
            transition: opacity 0.35s, transform 0.35s;
            will-change: opacity, transform;
        }
        .auth-form.hide {
            opacity: 0;
            pointer-events: none;
            position: absolute;
            left: 0; right: 0; top: 0;
            transform: translateY(30px) scale(0.98);
        }
        .auth-form.show {
            opacity: 1;
            pointer-events: auto;
            position: static;
            transform: translateY(0) scale(1);
        }
        .form-control {
            border-radius: 12px;
            border: 1.5px solid var(--border);
            padding: 0.9rem 1rem;
            font-size: 1rem;
            margin-bottom: 1.1rem;
            background: #f8fafc;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37,99,235,0.08);
            background: #fff;
        }
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        .auth-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.97rem;
            transition: color 0.2s;
        }
        .auth-link:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }
        .auth-btn {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 0.95rem 0;
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 0.5rem;
            margin-bottom: 0.7rem;
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px 0 rgba(37,99,235,0.08);
        }
        .auth-btn:hover, .auth-btn:focus {
            background: var(--primary-light);
            transform: translateY(-2px) scale(1.01);
        }
        .auth-footer {
            text-align: center;
            font-size: 0.97rem;
            margin-top: 0.7rem;
        }
        .auth-footer .auth-link {
            font-weight: 600;
        }
        .fade-in {
            animation: fadeIn 0.7s cubic-bezier(.39,.575,.56,1.000);
        }
        .invalid-feedback {
            display: block;
            font-size: 0.93rem;
            margin-top: -0.8rem;
            margin-bottom: 0.7rem;
        }
        .alert {
            border-radius: 10px;
            font-size: 0.97rem;
            margin-bottom: 1.1rem;
        }
    </style>
</head>
<body>
<div class="auth-card fade-in">
    <div class="auth-title">Login Form</div>
    <div class="auth-tabs position-relative mb-4">
        <div class="auth-tab-indicator login" id="tabIndicator"></div>
        <button class="auth-tab active" id="loginTab" type="button">Login</button>
        <button class="auth-tab" id="signupTab" type="button">Signup</button>
    </div>
    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="auth-form show" id="loginForm">
        @csrf
        @if(session('error'))
            <div class="alert alert-danger">{!! session('error') !!}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="mb-2 text-end">
            <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
        </div>
        <button type="submit" class="auth-btn">Login</button>
        <div class="auth-footer">
            Not a member? <a href="#" class="auth-link" id="toSignup">Signup now</a>
        </div>
    </form>
    <!-- Signup Form -->
    <form method="POST" action="{{ route('register') }}" class="auth-form hide" id="signupForm">
        @csrf
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="signupPassword" placeholder="Password" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <input type="password" class="form-control" name="password_confirmation" id="signupPasswordConfirm" placeholder="Confirm Password" required>
        <div class="mb-2 password-strength" id="passwordStrengthText" style="font-size:0.93rem;"></div>
        <button type="submit" class="auth-btn">Signup</button>
        <div class="auth-footer">
            Already have an account? <a href="#" class="auth-link" id="toLogin">Login</a>
        </div>
    </form>
</div>
<script>
    // Tab switching logic
    const loginTab = document.getElementById('loginTab');
    const signupTab = document.getElementById('signupTab');
    const tabIndicator = document.getElementById('tabIndicator');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const toSignup = document.getElementById('toSignup');
    const toLogin = document.getElementById('toLogin');

    function showLogin() {
        loginTab.classList.add('active');
        signupTab.classList.remove('active');
        tabIndicator.classList.remove('signup');
        tabIndicator.classList.add('login');
        loginForm.classList.remove('hide');
        loginForm.classList.add('show');
        signupForm.classList.remove('show');
        signupForm.classList.add('hide');
    }
    function showSignup() {
        signupTab.classList.add('active');
        loginTab.classList.remove('active');
        tabIndicator.classList.remove('login');
        tabIndicator.classList.add('signup');
        signupForm.classList.remove('hide');
        signupForm.classList.add('show');
        loginForm.classList.remove('show');
        loginForm.classList.add('hide');
    }
    loginTab.onclick = showLogin;
    signupTab.onclick = showSignup;
    toSignup.onclick = function(e){ e.preventDefault(); showSignup(); };
    toLogin.onclick = function(e){ e.preventDefault(); showLogin(); };

    // Password strength for signup
    const signupPassword = document.getElementById('signupPassword');
    const signupPasswordConfirm = document.getElementById('signupPasswordConfirm');
    const passwordStrengthText = document.getElementById('passwordStrengthText');
    if(signupPassword) {
        signupPassword.addEventListener('input', function() {
            const val = this.value;
            let strength = 0;
            if(val.length >= 8) strength++;
            if(/[A-Z]/.test(val)) strength++;
            if(/[0-9]/.test(val)) strength++;
            if(/[^A-Za-z0-9]/.test(val)) strength++;
            let text = '';
            let color = '';
            if(strength <= 1) { text = 'Weak password'; color = '#ef4444'; }
            else if(strength === 2) { text = 'Fair password'; color = '#f59e0b'; }
            else if(strength === 3) { text = 'Good password'; color = '#06b6d4'; }
            else { text = 'Strong password'; color = '#10b981'; }
            passwordStrengthText.textContent = text;
            passwordStrengthText.style.color = color;
        });
        signupPasswordConfirm.addEventListener('input', function() {
            if(this.value && signupPassword.value !== this.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    // Auto-hide alerts
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            alert.style.opacity = 0;
            setTimeout(()=>alert.remove(), 400);
        });
    }, 4000);
</script>
</body>
</html> 