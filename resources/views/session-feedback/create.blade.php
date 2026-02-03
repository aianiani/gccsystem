@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;

            /* Map to common names */
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-200: #e9ecef;
            --gray-600: var(--text-light);
            --gray-800: #343a40;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        html {
            zoom: 75% !important;
        }

        body {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%) !important;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            background: var(--hero-gradient);
            color: white;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 0.75rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(60px);
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
            line-height: 1.1;
            color: var(--yellow-maize);
        }

        .page-header p {
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .feedback-form-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            overflow: hidden;
            width: 100%;
            margin: 0;
        }

        .feedback-form-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .feedback-form-header h4 {
            font-size: 1.25rem;
            letter-spacing: -0.3px;
            margin-bottom: 0;
        }

        .feedback-form-body {
            padding: 1rem 1.25rem;
        }

        .appointment-summary {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--forest-green);
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
        }

        .appointment-summary:hover {
            background: var(--forest-green-lighter);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .appointment-summary h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .counselor-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
        }

        .counselor-info:hover {
            transform: scale(1.01);
            box-shadow: var(--shadow-sm);
        }

        .counselor-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--hero-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 3px solid white;
            transition: transform 0.3s ease;
        }

        .counselor-avatar:hover {
            transform: rotate(5deg) scale(1.05);
        }

        .session-metadata {
            padding: 0;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.65rem 0.85rem;
            background: white;
            border-radius: 10px;
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
            height: 100%;
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            border-color: var(--forest-green-light);
        }

        .info-item i {
            font-size: 1.25rem;
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        .info-item small {
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item strong {
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .info-item p {
            font-size: 0.9rem;
            color: var(--text-light);
            line-height: 1.5;
        }

        .rating-stars {
            display: flex;
            gap: 0.75rem;
            margin: 1.25rem 0;
            justify-content: center;
        }

        .star-btn {
            background: rgba(244, 208, 63, 0.1);
            border: 2px solid transparent;
            font-size: 2.5rem;
            color: #ddd;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            padding: 0.5rem;
            border-radius: 12px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (hover: hover) {
            .star-btn:hover {
                color: var(--yellow-maize);
                transform: scale(1.15) rotate(10deg);
                background: rgba(244, 208, 63, 0.2);
                border-color: var(--yellow-maize);
            }
        }

        .star-btn.active {
            color: var(--yellow-maize);
            transform: scale(1.1);
            background: rgba(244, 208, 63, 0.25);
            border-color: var(--yellow-maize);
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .form-control {
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--forest-green);
            box-shadow: 0 0 0 4px rgba(31, 122, 45, 0.1);
            transform: translateY(-1px);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        .btn-submit {
            background: var(--hero-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.15s ease;
            box-shadow: 0 6px 18px rgba(17, 94, 37, 0.06);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-cancel {
            background: var(--gray-200);
            color: var(--gray-800);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-right: 0.75rem;
            display: inline-block;
        }

        .btn-cancel:hover {
            background: var(--gray-600);
            color: white;
            text-decoration: none;
            border-color: var(--gray-600);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            text-decoration: none;
            transform: translateX(-3px);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Cleaned up redundant sidebar styles that are already in app.blade.php */

        /* NUCLEAR OPTION - Force full width everywhere */
        .main-dashboard-content *,
        .main-dashboard-content .full-width-container,
        .main-dashboard-content .page-header,
        .main-dashboard-content .feedback-form-card {
            box-sizing: border-box !important;
        }

        body,
        html {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
        }

        /* Custom full-width container - no Bootstrap constraints */
        .full-width-container {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: none !important;
        }

        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            max-width: none !important;
            width: 100% !important;
        }

        .main-dashboard-content {
            margin-left: 275px !important;
            padding: 1.5rem !important;
            width: auto !important;
            max-width: none !important;
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px !important;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
        }

        .main-dashboard-content .full-width-container {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: none !important;
        }

        /* Target the specific cards directly */
        .main-dashboard-content .page-header {
            margin: 0 0 0.75rem 0 !important;
            padding: 1rem 1.25rem !important;
            width: 100% !important;
            max-width: none !important;
        }

        .main-dashboard-content .feedback-form-card {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: none !important;
        }

        .main-dashboard-content .feedback-form-header {
            margin: 0 !important;
            width: 100% !important;
            max-width: none !important;
        }

        .main-dashboard-content .feedback-form-body {
            margin: 0 !important;
            padding: 0.75rem 1rem !important;
            width: 100% !important;
            max-width: none !important;
        }

        .main-dashboard-content .appointment-summary {
            margin: 0 0 1rem 0 !important;
            width: 100% !important;
            max-width: none !important;
        }

        /* Remove ANY container constraints */
        .container,
        .container-sm,
        .container-md,
        .container-lg,
        .container-xl,
        .container-xxl {
            max-width: none !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        @media (max-width: 767.98px) {
            /* Keep global zoom as per user request, but optimize touch targets */

            .star-btn {
                width: 75px;
                height: 75px;
                font-size: 3rem;
                margin-bottom: 0.5rem;
            }

            /* Disable hover transform on mobile to prevent click calc issues */
            .star-btn:hover {
                transform: none !important;
            }

            .star-btn.active {
                transform: none !important;
            }

            .rating-stars {
                gap: 0.5rem;
                flex-wrap: wrap;
                justify-content: center;
                margin: 1.5rem 0;
            }
        }
    </style>

    <div class="d-flex">
        @include('student.sidebar')

        <div class="main-dashboard-content flex-grow-1">
            <div class="full-width-container">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-2">
                                <i class="bi bi-star me-3"></i>
                                Session Feedback
                            </h1>
                            <p class="mb-0 opacity-75">Share your experience and help us improve our counseling services</p>
                        </div>
                        <a href="{{ route('appointments.completedWithNotes') }}" class="back-btn">
                            <i class="bi bi-arrow-left"></i>
                            Back to Session Notes
                        </a>
                    </div>
                </div>

                <div class="feedback-form-card">
                    <div class="feedback-form-header">
                        <h4 class="mb-0">
                            <i class="bi bi-calendar-check me-2"></i>
                            Provide Feedback for Your Session
                        </h4>
                    </div>
                    <div class="feedback-form-body">
                        <!-- Appointment Summary -->
                        <div class="appointment-summary">
                            <h5 class="mb-2">Session Details</h5>
                            <div class="row g-2">
                                <!-- Left Column: Counselor Info -->
                                <div class="col-md-3">
                                    <div class="counselor-info h-100">
                                        @if($appointment->counselor->avatar)
                                            <img src="{{ $appointment->counselor->avatar_url }}"
                                                alt="{{ $appointment->counselor->name }}" class="counselor-avatar"
                                                style="object-fit: cover;">
                                        @else
                                            <div class="counselor-avatar">
                                                {{ strtoupper(substr($appointment->counselor->name ?? 'C', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $appointment->counselor->name ?? 'Counselor' }}</h6>
                                            <p class="mb-0 text-muted small">{{ $appointment->counselor->email ??
                                                'counselor@example.com' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: Session Info -->
                                <div class="col-md-9">
                                    <div class="session-metadata">
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <i class="bi bi-calendar me-2 text-primary"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Date</small>
                                                        <strong>{{ $appointment->scheduled_at->format('F j, Y') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <i class="bi bi-clock me-2 text-primary"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Time</small>
                                                        <strong>{{ $appointment->scheduled_at->format('g:i A') }} -
                                                            {{ $appointment->scheduled_at->addMinutes(30)->format('g:i A') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <i class="bi bi-hash me-2 text-success"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Session Number</small>
                                                        <strong>{{ $sessionNumber }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($appointment->notes)
                                                <div class="col-12">
                                                    <div class="info-item">
                                                        <i class="bi bi-sticky me-2 text-warning"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Session Notes</small>
                                                            <p class="mb-0">{{ Str::limit($appointment->notes, 150) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback Form -->
                        <form action="{{ route('session-feedback.store', $appointment->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-star me-2"></i>
                                    How would you rate your counseling session?
                                </label>
                                <div class="rating-stars">
                                    <button type="button" class="star-btn" data-rating="1" title="Poor">
                                        <i class="bi bi-star"></i>
                                    </button>
                                    <button type="button" class="star-btn" data-rating="2" title="Fair">
                                        <i class="bi bi-star"></i>
                                    </button>
                                    <button type="button" class="star-btn" data-rating="3" title="Good">
                                        <i class="bi bi-star"></i>
                                    </button>
                                    <button type="button" class="star-btn" data-rating="4" title="Very Good">
                                        <i class="bi bi-star"></i>
                                    </button>
                                    <button type="button" class="star-btn" data-rating="5" title="Excellent">
                                        <i class="bi bi-star"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="rating" id="rating" required>
                                @error('rating')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="comments" class="form-label">
                                    <i class="bi bi-chat-text me-2"></i>
                                    Please share your thoughts about the session
                                </label>
                                <textarea name="comments" id="comments" class="form-control" rows="6"
                                    placeholder="Tell us about your experience with the counselor, what you found helpful, and any suggestions for improvement..."
                                    required>{{ old('comments') }}</textarea>
                                @error('comments')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('appointments.completedWithNotes') }}" class="btn-cancel">
                                    Cancel
                                </a>
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-send me-2"></i>
                                    Submit Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>             document.addEventListener('DOMContentLoaded', function () {
                    const starButtons = document.querySelectorAll('.star-btn'); const ratingInput = document.getElementById('rating'); let selectedRating = 0;
                    starButtons.forEach(button => {
                        function handleRating(e) {
                            // Prevent double firing on touch devices that emit both touch and click
                            if (e.type === 'touchstart') {
                                e.preventDefault();
                            }

                            const rating = parseInt(this.getAttribute('data-rating'));
                            selectedRating = rating;
                            ratingInput.value = rating;

                            // Update star display
                            starButtons.forEach((star, index) => {
                                if (index < rating) {
                                    star.classList.add('active');
                                    star.innerHTML = '<i class="bi bi-star-fill"></i>';
                                } else {
                                    star.classList.remove('active');
                                    star.innerHTML = '<i class="bi bi-star"></i>';
                                }
                            });

                            // Hide validation error if it exists
                            // The error is after the hidden input which is after .rating-stars
                            // Structure: .rating-stars -> input#rating -> .text-danger
                            const container = document.querySelector('.form-group .rating-stars').parentNode;
                            const errorMsg = container.querySelector('.text-danger');
                            if (errorMsg) {
                                errorMsg.style.display = 'none';
                            }
                        }

                        button.addEventListener('click', handleRating);
                        button.addEventListener('touchstart', handleRating, { passive: false });

                        // Hover effects (only for mouse)
                        button.addEventListener('mouseenter', function () {
                            // Simple check for touch capability might not be enough, but good heuristic
                            // A better way is to see if we recently had a touch event, but this is fine for now
                            if ('ontouchstart' in window || navigator.maxTouchPoints > 0) return;

                            const rating = parseInt(this.getAttribute('data-rating'));
                            starButtons.forEach((star, index) => {
                                if (index < rating) {
                                    star.innerHTML = '<i class="bi bi-star-fill"></i>';
                                }
                            });
                        });

                        button.addEventListener('mouseleave', function () {
                            if ('ontouchstart' in window || navigator.maxTouchPoints > 0) return;

                            starButtons.forEach((star, index) => {
                                if (index < selectedRating) {
                                    star.innerHTML = '<i class="bi bi-star-fill"></i>';
                                } else {
                                    star.innerHTML = '<i class="bi bi-star"></i>';
                                }
                            });
                        });
                    });
                });
            </script>
@endsection