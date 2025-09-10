@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-3">
                    <h2 class="h3 fw-bold mb-1">Resend Email Verification</h2>
                    <p class="text-muted mb-0">Enter your email address and we'll send you a new verification link.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info" role="alert">
                        {{ session('info') }}
                    </div>
                @endif

                <form action="{{ route('verification.resend') }}" method="POST" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Enter your email address"
                               value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Send Verification Link</button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="link-primary text-decoration-none">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection