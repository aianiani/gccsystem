@extends('layouts.app')

@section('content')
<style>
    :root {
        --forest-green: #2d5016;
        --forest-green-light: #4a7c59;
        --forest-green-lighter: #e8f5e8;
        --yellow-maize: #f4d03f;
        --yellow-maize-light: #fef9e7;
        --white: #ffffff;
        --gray-50: #f8f9fa;
        --gray-100: #f1f3f4;
        --gray-600: #6c757d;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .page-header {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
    }

    .feedback-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        overflow: hidden;
    }

    .feedback-form-header {
        background: var(--forest-green-lighter);
        color: var(--forest-green);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-100);
        font-weight: 600;
    }

    .feedback-form-body {
        padding: 2rem;
    }

    .appointment-summary {
        background: var(--gray-50);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid var(--forest-green);
    }

    .counselor-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .counselor-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--forest-green);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .rating-stars {
        display: flex;
        gap: 0.5rem;
        margin: 1rem 0;
    }

    .star-btn {
        background: none;
        border: none;
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0.25rem;
    }

    .star-btn:hover,
    .star-btn.active {
        color: var(--yellow-maize);
        transform: scale(1.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--forest-green);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border: 1px solid var(--gray-100);
        border-radius: 8px;
        padding: 0.75rem;
        width: 100%;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--forest-green);
        box-shadow: 0 0 0 3px rgba(45, 80, 22, 0.1);
    }

    .btn-submit {
        background: var(--forest-green);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        background: var(--forest-green-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .btn-cancel {
        background: var(--gray-100);
        color: var(--gray-600);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-right: 1rem;
    }

    .btn-cancel:hover {
        background: var(--gray-600);
        color: white;
        text-decoration: none;
    }

    .back-btn {
        background: var(--forest-green);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-btn:hover {
        background: var(--forest-green-light);
        color: white;
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }
</style>

<div class="container-fluid py-4">
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

    <div class="row justify-content-center">
        <div class="col-lg-8">
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
                        <h5 class="mb-3">Session Details</h5>
                        <div class="counselor-info">
                            @if($appointment->counselor->avatar)
                                <img src="{{ $appointment->counselor->avatar_url }}" 
                                     alt="{{ $appointment->counselor->name }}" 
                                     class="counselor-avatar" 
                                     style="object-fit: cover;">
                            @else
                                <div class="counselor-avatar">
                                    {{ strtoupper(substr($appointment->counselor->name ?? 'C', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $appointment->counselor->name ?? 'Counselor' }}</h6>
                                <p class="mb-0 text-muted">{{ $appointment->counselor->email ?? 'counselor@example.com' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="bi bi-calendar me-2 text-primary"></i>
                                    <strong>Date:</strong> {{ $appointment->scheduled_at->format('F j, Y') }}
                                </p>
                                <p class="mb-2">
                                    <i class="bi bi-clock me-2 text-primary"></i>
                                    <strong>Time:</strong> {{ $appointment->scheduled_at->format('g:i A') }} - {{ $appointment->scheduled_at->addMinutes(30)->format('g:i A') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="bi bi-journal-text me-2 text-success"></i>
                                    <strong>Session Notes:</strong> {{ $appointment->sessionNotes->count() }} note(s)
                                </p>
                                @if($appointment->notes)
                                    <p class="mb-2">
                                        <i class="bi bi-sticky me-2 text-warning"></i>
                                        <strong>Appointment Notes:</strong> {{ Str::limit($appointment->notes, 100) }}
                                    </p>
                                @endif
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
                                Please share your thoughts about the session (minimum 10 characters)
                            </label>
                            <textarea 
                                name="comments" 
                                id="comments" 
                                class="form-control" 
                                rows="6" 
                                placeholder="Tell us about your experience with the counselor, what you found helpful, and any suggestions for improvement..."
                                required
                            >{{ old('comments') }}</textarea>
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
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const starButtons = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('rating');
    let selectedRating = 0;

    starButtons.forEach(button => {
        button.addEventListener('click', function() {
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
        });

        // Hover effects
        button.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            starButtons.forEach((star, index) => {
                if (index < rating) {
                    star.innerHTML = '<i class="bi bi-star-fill"></i>';
                }
            });
        });

        button.addEventListener('mouseleave', function() {
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