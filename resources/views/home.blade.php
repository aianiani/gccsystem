@extends('layouts.app')

@section('content')
<!-- Sticky Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top animate-fade-in">
    <div class="container">
        <a class="navbar-brand university-brand d-flex align-items-center gap-2" href="/">
            <img src="/images/cmu-logo.png" alt="CMU Logo" style="height: 40px;">
            <span>CMU Guidance and Counseling Center</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Counselors</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Chat</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Resources</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
            </ul>
            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill ms-lg-3 px-4">Sign In / Sign Up</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="homepage-hero position-relative animate-fade-in" style="background: linear-gradient(rgba(34,109,44,0.85),rgba(34,109,44,0.85)), url('/images/cmu-bg.jpg') center/cover no-repeat; min-height: 420px;">
    <div class="container py-5 text-center text-white">
        <h1 class="display-3 fw-bold mb-3 animate-slide-up">Empowering Students through Accessible Counseling</h1>
        <p class="lead mb-4 animate-fade-in" style="font-size:1.35rem;">Schedule an appointment, access guidance materials, or connect with a counselor – anytime, anywhere.</p>
        <div class="d-flex justify-content-center gap-3 animate-fade-in">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow">Book Appointment</a>
            <a href="{{ route('login') }}" class="btn btn-warning btn-lg rounded-pill px-4 text-white shadow" style="background: #f9b233; border: none;">Chat Now</a>
        </div>
    </div>
</div>

<!-- Feature Cards -->
<div class="container py-5 animate-fade-in">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-center p-4 h-100 feature-card">
                <div class="icon-circle mb-3"><i class="bi bi-calendar2-check display-5"></i></div>
                <h5 class="fw-bold mb-2">Easy Scheduling</h5>
                <p class="text-muted mb-0">Book appointments online with just a few clicks.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-4 h-100 feature-card">
                <div class="icon-circle mb-3"><i class="bi bi-chat-dots display-5"></i></div>
                <h5 class="fw-bold mb-2">Live Chat Support</h5>
                <p class="text-muted mb-0">Get immediate assistance through our real-time chat.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-4 h-100 feature-card">
                <div class="icon-circle mb-3"><i class="bi bi-shield-lock display-5"></i></div>
                <h5 class="fw-bold mb-2">Confidential</h5>
                <p class="text-muted mb-0">All sessions and communications are strictly confidential.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-4 h-100 feature-card">
                <div class="icon-circle mb-3"><i class="bi bi-journal-text display-5"></i></div>
                <h5 class="fw-bold mb-2">Self-Help Resources</h5>
                <p class="text-muted mb-0">Access guides and materials for personal growth.</p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer-dark py-4 mt-5 border-0 animate-fade-in">
    <div class="container text-center">
        <div class="mb-2 university-brand d-flex align-items-center justify-content-center gap-2">
            <img src="/images/cmu-logo.png" alt="CMU Logo" style="height: 32px;">
            <span>Central Mindanao University</span>
        </div>
        <div class="text-white-50 small">&copy; {{ date('Y') }} Central Mindanao University. All rights reserved.</div>
    </div>
</footer>
@endsection 