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
                    <form method="POST" action="{{ route('2fa.verify') }}">
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
                        <button type="submit" class="btn btn-primary w-100">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 