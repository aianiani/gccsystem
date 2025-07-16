@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Two-Factor Authentication</div>
                <div class="card-body">
                    @if(session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif
                    <div class="mb-3 text-center">
                        <span id="timer" class="fw-bold fs-5">05:00</span>
                    </div>
                    <form method="POST" action="{{ route('2fa.verify') }}" id="verify-form">
                        @csrf
                        <div class="mb-3">
                            <label for="code" class="form-label">Enter the 6-digit code sent to your email</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required autofocus maxlength="6" pattern="\d{6}">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="verify-btn">Verify</button>
                    </form>
                    <form method="POST" action="{{ route('2fa.resend') }}" id="resend-form" class="mt-3 text-center">
                        @csrf
                        <button type="submit" class="btn btn-link" id="resend-btn" disabled>Resend Code</button>
                    </form>
                    <script>
                        let timer = 300; // 5 minutes in seconds
                        const timerDisplay = document.getElementById('timer');
                        const resendBtn = document.getElementById('resend-btn');
                        const verifyBtn = document.getElementById('verify-btn');
                        function updateTimer() {
                            const minutes = String(Math.floor(timer / 60)).padStart(2, '0');
                            const seconds = String(timer % 60).padStart(2, '0');
                            timerDisplay.textContent = `${minutes}:${seconds}`;
                            if (timer <= 0) {
                                resendBtn.disabled = false;
                                verifyBtn.disabled = false; // Optionally keep enabled
                                timerDisplay.textContent = 'Code expired';
                            } else {
                                timer--;
                                setTimeout(updateTimer, 1000);
                            }
                        }
                        updateTimer();
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 