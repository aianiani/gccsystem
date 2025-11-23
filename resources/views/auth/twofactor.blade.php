<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GCC System') }} - Two-Factor Authentication</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
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
        .form-control:focus {
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
        
        /* OTP Input Styles */
        .otp-container {
            margin-bottom: 1rem;
        }
        .otp-inputs {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .otp-input {
            width: 56px;
            height: 64px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            background: white;
            color: #333;
            transition: all 0.3s ease;
            outline: none;
        }
        .otp-input:focus {
            border-color: #1e7e34;
            box-shadow: 0 0 0 3px rgba(30, 126, 52, 0.1);
            transform: scale(1.05);
        }
        .otp-input.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }
        .otp-input.filled {
            background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
            border-color: #1e7e34;
            color: #1e7e34;
        }
        .otp-help-text {
            text-align: center;
            margin-top: 0.5rem;
        }
        .otp-help-text i {
            margin-right: 0.25rem;
        }
        
        /* Button Loading State */
        .login-button {
            position: relative;
            overflow: hidden;
        }
        .btn-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Enhanced Timer Design */
        .timer-section {
            margin-bottom: 2rem;
            text-align: center;
        }
        .timer-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            border: 2px solid rgba(30, 126, 52, 0.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }
        .timer-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e7e34 0%, #28a745 100%);
            border-radius: 20px 20px 0 0;
        }
        .timer-icon {
            font-size: 2rem;
            color: #1e7e34;
            margin-bottom: 0.5rem;
            animation: pulse 2s ease-in-out infinite;
        }
        .timer-content {
            margin-bottom: 1rem;
        }
        .timer-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .timer-display {
            font-weight: 700;
            font-size: 2.2rem;
            color: #1e7e34;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
            text-shadow: 0 2px 4px rgba(30, 126, 52, 0.1);
        }
        .timer-display.expired {
            color: #dc3545;
            animation: shake 0.5s ease-in-out;
        }
        .timer-progress {
            height: 6px;
            background: rgba(30, 126, 52, 0.1);
            border-radius: 3px;
            overflow: hidden;
        }
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #1e7e34 0%, #28a745 100%);
            border-radius: 3px;
            transition: width 1s linear;
            width: 100%;
        }
        .progress-bar.expired {
            background: linear-gradient(90deg, #dc3545 0%, #c82333 100%);
        }
        
        /* Enhanced Button Styles */
        .resend-button, .back-to-signin-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .resend-button {
            width: 100%;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(30, 126, 52, 0.3);
        }
        .resend-button:hover:not([disabled]) {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 126, 52, 0.4);
        }
        .resend-button[disabled] {
            background: #6c757d;
            color: #adb5bd;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .resend-button[disabled] .btn-icon {
            animation: spin 1s linear infinite;
        }
        
        .back-to-signin-button {
            width: 100%;
            background: transparent;
            color: #6c757d;
            border-color: #e9ecef;
        }
        .back-to-signin-button:hover {
            background: #f8f9fa;
            color: #495057;
            border-color: #dee2e6;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-icon {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }
        .resend-button:hover:not([disabled]) .btn-icon {
            transform: rotate(180deg);
        }
        .back-to-signin-button:hover .btn-icon {
            transform: translateX(-2px);
        }
        
        .btn-countdown {
            font-size: 0.85rem;
            opacity: 0.8;
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        /* Animations */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .timer-container {
                padding: 1.25rem 1.5rem;
            }
            .timer-display {
                font-size: 1.8rem;
                letter-spacing: 3px;
            }
            .timer-icon {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .timer-container {
                padding: 1rem 1.25rem;
            }
            .timer-display {
                font-size: 1.5rem;
                letter-spacing: 2px;
            }
            .resend-button, .back-to-signin-button {
                padding: 0.75rem 1.25rem;
                font-size: 0.9rem;
            }
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
        .login-button:active { transform: translateY(0); }
        .login-button:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
        .info-card {
            background: #e8f5e8;
            border: 1px solid #b2dfdb;
            color: #155724;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            text-align: left;
            font-size: 1rem;
        }
        .timer-section {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .timer-display {
            font-weight: bold;
            font-size: 1.5rem;
            color: #1e7e34;
            letter-spacing: 2px;
        }
        .resend-btn[disabled] {
            opacity: 0.5;
            pointer-events: none;
        }
        @media (max-width: 768px) {
            .content-wrapper { padding: 2rem 1.5rem; }
            .brand-title { font-size: 2rem; }
            .form-section { padding: 2rem 1.5rem; }
            .back-button { padding: 0.5rem 1rem; font-size: 0.9rem; }
        }
        @media (max-width: 480px) {
            .content-wrapper { padding: 1.5rem 1rem; }
            .brand-title { font-size: 1.8rem; }
            .brand-subtitle { font-size: 1rem; }
            .form-section { padding: 1.5rem 1rem; }
            .back-button { top: 1rem; left: 1rem; }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <a href="{{ route('home') }}" class="back-button">
            <i class="bi bi-arrow-left"></i> Back to Home
        </a>
        <div class="content-wrapper">
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
                    <h2 class="form-title">Two-Factor Authentication</h2>
                    <p class="form-subtitle">Enter the 6-digit code sent to your email</p>
                </div>
                @if(session('info'))
                    <div class="info-card">{{ session('info') }}</div>
                @endif
                <div class="timer-section">
                    <div class="timer-container">
                        <div class="timer-icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div class="timer-content">
                            <div class="timer-label">Code expires in</div>
                            <div id="timer" class="timer-display">05:00</div>
                        </div>
                        <div class="timer-progress">
                            <div class="progress-bar" id="progress-bar"></div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('2fa.verify') }}" id="verify-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="otp-code" class="form-label">6-digit Verification Code</label>
                        <div class="otp-container">
                            <div class="otp-inputs">
                                <input type="text" class="otp-input @error('code') is-invalid @enderror" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="0" autocomplete="off" />
                                <input type="text" class="otp-input @error('code') is-invalid @enderror" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="1" autocomplete="off" />
                                <input type="text" class="otp-input @error('code') is-invalid @enderror" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="2" autocomplete="off" />
                                <input type="text" class="otp-input @error('code') is-invalid @enderror" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="3" autocomplete="off" />
                                <input type="text" class="otp-input @error('code') is-invalid @enderror" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="4" autocomplete="off" />
                                <input type="text" class="otp-input @error('code') is-invalid @enderror" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="5" autocomplete="off" />
                            </div>
                            <input type="hidden" name="code" id="otp-code" value="{{ old('code') }}" required />
                            <div class="otp-help-text">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> 
                                    You can paste the entire code or type each digit individually
                                </small>
                            </div>
                        </div>
                        @error('code')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="login-button" id="verify-btn">
                        <span class="btn-text">Verify Code</span>
                        <span class="btn-spinner d-none">
                            <i class="bi bi-arrow-clockwise spin"></i> Verifying...
                        </span>
                    </button>
                </form>
                <form method="POST" action="{{ route('2fa.resend') }}" id="resend-form" class="mt-4">
                    @csrf
                    <button type="submit" class="resend-button" id="resend-btn" disabled>
                        <span class="btn-icon">
                            <i class="bi bi-arrow-clockwise"></i>
                        </span>
                        <span class="btn-text">Resend Code</span>
                        <span class="btn-countdown d-none">
                            Resend available in <span id="resend-timer">05:00</span>
                        </span>
                    </button>
                </form>
                
                <div class="action-buttons mt-3">
                    <a href="{{ route('login') }}" class="back-to-signin-button">
                        <span class="btn-icon">
                            <i class="bi bi-arrow-left"></i>
                        </span>
                        <span class="btn-text">Back to Sign In</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Enhanced OTP Input Handling
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpHidden = document.getElementById('otp-code');
            const verifyBtn = document.getElementById('verify-btn');
            const btnText = document.querySelector('.btn-text');
            const btnSpinner = document.querySelector('.btn-spinner');
            
            // Initialize OTP inputs with old value if exists
            const oldValue = otpHidden.value;
            if (oldValue && oldValue.length === 6) {
                for (let i = 0; i < 6; i++) {
                    otpInputs[i].value = oldValue[i];
                    otpInputs[i].classList.add('filled');
                }
            }
            
            // Focus first empty input on load
            const firstEmpty = Array.from(otpInputs).find(input => !input.value);
            if (firstEmpty) {
                firstEmpty.focus();
            } else if (otpInputs[0]) {
                otpInputs[0].focus();
            }
            
            // Handle individual input
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value.replace(/\D/g, '').slice(0, 1);
                    e.target.value = value;
                    
                    if (value) {
                        e.target.classList.add('filled');
                        // Move to next input
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    } else {
                        e.target.classList.remove('filled');
                    }
                    
                    updateHiddenInput();
                    checkFormValidity();
                });
                
                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].classList.remove('filled');
                    }
                    
                    // Handle arrow keys
                    if (e.key === 'ArrowLeft' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                    if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });
                
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
                    
                    if (pastedData.length === 6) {
                        // Fill all inputs with pasted data
                        for (let i = 0; i < 6; i++) {
                            otpInputs[i].value = pastedData[i];
                            otpInputs[i].classList.add('filled');
                        }
                        updateHiddenInput();
                        checkFormValidity();
                        
                        // Focus last input
                        otpInputs[5].focus();
                        
                        // Show success feedback
                        showPasteFeedback();
                    } else if (pastedData.length > 0) {
                        // Partial paste - fill available inputs
                        for (let i = 0; i < Math.min(pastedData.length, 6); i++) {
                            otpInputs[i].value = pastedData[i];
                            otpInputs[i].classList.add('filled');
                        }
                        updateHiddenInput();
                        checkFormValidity();
                        
                        // Focus next empty input
                        const nextEmpty = Array.from(otpInputs).find(input => !input.value);
                        if (nextEmpty) {
                            nextEmpty.focus();
                        }
                    }
                });
                
                input.addEventListener('focus', function() {
                    // Select all text when focusing
                    this.select();
                });
            });
            
            function updateHiddenInput() {
                const code = Array.from(otpInputs).map(input => input.value).join('');
                otpHidden.value = code;
            }
            
            function checkFormValidity() {
                const code = otpHidden.value;
                const isValid = code.length === 6 && /^\d{6}$/.test(code);
                
                if (isValid) {
                    verifyBtn.disabled = false;
                    verifyBtn.style.opacity = '1';
                } else {
                    verifyBtn.disabled = true;
                    verifyBtn.style.opacity = '0.7';
                }
            }
            
            function showPasteFeedback() {
                // Create temporary success message
                const feedback = document.createElement('div');
                feedback.className = 'otp-feedback';
                feedback.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i> Code pasted successfully!';
                feedback.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    padding: 1rem 1.5rem;
                    border-radius: 8px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                    z-index: 1000;
                    animation: slideIn 0.3s ease;
                `;
                
                document.body.appendChild(feedback);
                
                setTimeout(() => {
                    feedback.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => feedback.remove(), 300);
                }, 2000);
            }
            
            // Enhanced form submission
            document.getElementById('verify-form').addEventListener('submit', function(e) {
                const code = otpHidden.value;
                
                if (code.length !== 6 || !/^\d{6}$/.test(code)) {
                    e.preventDefault();
                    showError('Please enter a valid 6-digit code');
                    return;
                }
                
                // Show loading state
                btnText.classList.add('d-none');
                btnSpinner.classList.remove('d-none');
                verifyBtn.disabled = true;
            });
            
            function showError(message) {
                // Remove existing error feedback
                const existingError = document.querySelector('.otp-error-feedback');
                if (existingError) {
                    existingError.remove();
                }
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'otp-error-feedback';
                errorDiv.innerHTML = `<i class="bi bi-exclamation-triangle-fill text-danger"></i> ${message}`;
                errorDiv.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    padding: 1rem 1.5rem;
                    border-radius: 8px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                    z-index: 1000;
                    animation: slideIn 0.3s ease;
                    border-left: 4px solid #dc3545;
                `;
                
                document.body.appendChild(errorDiv);
                
                setTimeout(() => {
                    errorDiv.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => errorDiv.remove(), 300);
                }, 3000);
            }
            
            // Add CSS animations
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
            
            // Initial form validity check
            checkFormValidity();
        });
        
        // Enhanced Timer and Button Logic
        let timer = 300; // 5 minutes in seconds
        let resendTimer = 300; // Resend timer (same as main timer)
        const timerDisplay = document.getElementById('timer');
        const progressBar = document.getElementById('progress-bar');
        const resendBtn = document.getElementById('resend-btn');
        const resendTimerDisplay = document.getElementById('resend-timer');
        const verifyBtn = document.getElementById('verify-btn');
        const btnText = resendBtn.querySelector('.btn-text');
        const btnCountdown = resendBtn.querySelector('.btn-countdown');
        
        function updateTimer() {
            const minutes = String(Math.floor(timer / 60)).padStart(2, '0');
            const seconds = String(timer % 60).padStart(2, '0');
            timerDisplay.textContent = `${minutes}:${seconds}`;
            
            // Update progress bar
            const progressPercentage = (timer / 300) * 100;
            progressBar.style.width = `${progressPercentage}%`;
            
            if (timer <= 0) {
                timerDisplay.textContent = 'Code expired';
                timerDisplay.classList.add('expired');
                progressBar.classList.add('expired');
                resendBtn.disabled = false;
                resendBtn.querySelector('.btn-text').textContent = 'Resend Code';
                btnCountdown.classList.add('d-none');
                btnText.classList.remove('d-none');
            } else {
                timer--;
                setTimeout(updateTimer, 1000);
            }
        }
        
        function updateResendTimer() {
            const minutes = String(Math.floor(resendTimer / 60)).padStart(2, '0');
            const seconds = String(resendTimer % 60).padStart(2, '0');
            resendTimerDisplay.textContent = `${minutes}:${seconds}`;
            
            if (resendTimer <= 0) {
                resendBtn.disabled = false;
                btnText.classList.remove('d-none');
                btnCountdown.classList.add('d-none');
                resendBtn.querySelector('.btn-text').textContent = 'Resend Code';
            } else {
                resendTimer--;
                setTimeout(updateResendTimer, 1000);
            }
        }
        
        // Handle resend button click
        resendBtn.addEventListener('click', function(e) {
            if (resendBtn.disabled) {
                e.preventDefault();
                return;
            }
            
            // Show loading state
            btnText.textContent = 'Sending...';
            btnText.classList.add('d-none');
            btnCountdown.classList.remove('d-none');
            resendBtn.disabled = true;
            
            // Reset timers
            timer = 300;
            resendTimer = 300;
            
            // Restart timers
            updateTimer();
            updateResendTimer();
            
            // Show success message
            setTimeout(() => {
                btnText.textContent = 'Code sent!';
                btnText.classList.remove('d-none');
                btnCountdown.classList.add('d-none');
                
                // Show toast notification
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'New verification code sent!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            }, 1000);
        });
        
        // Start timers
        updateTimer();
        updateResendTimer();
        
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