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

    .feedback-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        overflow: hidden;
    }

    .feedback-header {
        background: var(--forest-green-lighter);
        color: var(--forest-green);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-100);
        font-weight: 600;
    }

    .feedback-body {
        padding: 2rem;
    }

    .session-summary {
        background: var(--gray-50);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid var(--forest-green);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .student-avatar {
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

    .rating-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1rem 0;
        padding: 1rem;
        background: var(--yellow-maize-light);
        border-radius: 8px;
    }

    .stars {
        display: flex;
        gap: 0.25rem;
    }

    .star {
        font-size: 1.5rem;
        color: var(--yellow-maize);
    }

    .feedback-comments {
        background: var(--gray-50);
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1rem 0;
        border-left: 4px solid var(--forest-green);
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

    .status-badge {
        background: var(--forest-green);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="bi bi-star me-3"></i>
                    Session Feedback Details
                </h1>
                <p class="mb-0 opacity-75">Student feedback for your counseling session</p>
            </div>
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="feedback-card">
                <div class="feedback-header">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-check me-2"></i>
                        Session Feedback from {{ $feedback->appointment->student->name }}
                    </h4>
                </div>
                <div class="feedback-body">
                    <!-- Session Summary -->
                    <div class="session-summary">
                        <h5 class="mb-3">Session Details</h5>
                        <div class="student-info">
                            <div class="student-avatar">
                                {{ strtoupper(substr($feedback->appointment->student->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $feedback->appointment->student->name ?? 'Student' }}</h6>
                                <p class="mb-0 text-muted">{{ $feedback->appointment->student->email ?? 'student@example.com' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="bi bi-calendar me-2 text-primary"></i>
                                    <strong>Date:</strong> {{ $feedback->appointment->scheduled_at->format('F j, Y') }}
                                </p>
                                <p class="mb-2">
                                    <i class="bi bi-clock me-2 text-primary"></i>
                                    <strong>Time:</strong> {{ $feedback->appointment->scheduled_at->format('g:i A') }} - {{ $feedback->appointment->scheduled_at->addMinutes(30)->format('g:i A') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="bi bi-journal-text me-2 text-success"></i>
                                    <strong>Session Notes:</strong> {{ $feedback->appointment->sessionNotes->count() }} note(s)
                                </p>
                                @if($feedback->appointment->notes)
                                    <p class="mb-2">
                                        <i class="bi bi-sticky me-2 text-warning"></i>
                                        <strong>Appointment Notes:</strong> {{ Str::limit($feedback->appointment->notes, 100) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Rating Display -->
                    <div class="rating-display">
                        <div>
                            <h6 class="mb-1 fw-bold">Session Rating</h6>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }} star"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="ms-auto">
                            <span class="status-badge">{{ $feedback->rating }}/5 Stars</span>
                        </div>
                    </div>

                    <!-- Feedback Comments -->
                    <div class="feedback-comments">
                        <h6 class="mb-2 fw-bold">
                            <i class="bi bi-chat-text me-2"></i>
                            Student Comments
                        </h6>
                        <div class="mt-2">
                            {!! nl2br(e($feedback->comments)) !!}
                        </div>
                    </div>

                    <!-- Feedback Metadata -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p class="mb-1">
                                <i class="bi bi-calendar-event me-2 text-muted"></i>
                                <strong>Feedback Date:</strong> {{ $feedback->created_at->format('F j, Y g:i A') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">
                                <i class="bi bi-clock-history me-2 text-muted"></i>
                                <strong>Submitted:</strong> {{ $feedback->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <!-- Session Notes Summary -->
                    @if($feedback->appointment->sessionNotes->count() > 0)
                        <div class="mt-4">
                            <h6 class="mb-3 fw-bold">
                                <i class="bi bi-journal-text me-2"></i>
                                Session Notes Summary
                            </h6>
                            @foreach($feedback->appointment->sessionNotes as $sessionNote)
                                <div class="card mb-2">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-1">Session Note #{{ $sessionNote->id }}</h6>
                                            <small class="text-muted">{{ $sessionNote->created_at->format('F j, Y') }}</small>
                                        </div>
                                        @if($sessionNote->content)
                                            <p class="mb-1 small">{{ Str::limit($sessionNote->content, 150) }}</p>
                                        @endif
                                        @if($sessionNote->recommendations)
                                            <p class="mb-0 small text-muted">
                                                <strong>Recommendations:</strong> {{ Str::limit($sessionNote->recommendations, 100) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 