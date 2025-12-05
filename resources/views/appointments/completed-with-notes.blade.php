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

    .appointment-card {
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .appointment-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .appointment-header {
        background: var(--forest-green-lighter);
        color: var(--forest-green);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        font-weight: 600;
    }

    .appointment-body {
        padding: 1.5rem;
    }

    .session-note {
        background: var(--gray-50);
        border-radius: 8px;
        padding: 1.25rem;
        margin-top: 1rem;
        border-left: 4px solid var(--forest-green);
    }

    .counselor-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background: var(--yellow-maize-light);
        border-radius: 8px;
    }

    .counselor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--forest-green);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--gray-600);
        background: var(--gray-50);
        border-radius: 12px;
        border: 2px dashed var(--gray-100);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--gray-600);
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .status-badge {
        background: var(--forest-green);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
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
                    <i class="bi bi-journal-text me-3"></i>
                    Completed Appointments with Session Notes
                </h1>
                <p class="mb-0 opacity-75">Review your completed counseling sessions and session notes</p>
            </div>
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    @if($completedAppointments->count() > 0)
        <div class="row">
            <div class="col-12">
                @foreach($completedAppointments as $appointment)
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-calendar-check me-2"></i>
                                    Counseling Session
                                </h5>
                                <span class="status-badge">Completed</span>
                            </div>
                        </div>
                        <div class="appointment-body">
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
                                    <p class="mb-0 text-muted small">{{ $appointment->counselor->email ?? 'counselor@example.com' }}</p>
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

                            @foreach($appointment->sessionNotes as $sessionNote)
                                <div class="session-note">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-1 fw-bold">
                                            <i class="bi bi-journal-text me-2"></i>
                                            Session Note #{{ $sessionNote->id }}
                                        </h6>
                                        <small class="text-muted">{{ $sessionNote->created_at->format('F j, Y g:i A') }}</small>
                                    </div>
                                    
                                    @if($sessionNote->session_number)
                                        <p class="mb-2">
                                            <strong>Session Number:</strong> {{ $sessionNote->session_number }}
                                        </p>
                                    @endif

                                    @if($sessionNote->session_status)
                                        <p class="mb-2">
                                            <strong>Session Status:</strong> 
                                            <span class="badge bg-{{ $sessionNote->session_status === 'completed' ? 'success' : ($sessionNote->session_status === 'ongoing' ? 'warning' : 'info') }}">
                                                {{ ucfirst($sessionNote->session_status) }}
                                            </span>
                                        </p>
                                    @endif

                                    @if($sessionNote->attendance)
                                        <p class="mb-2">
                                            <strong>Attendance:</strong> 
                                            <span class="badge bg-{{ $sessionNote->attendance === 'present' ? 'success' : 'danger' }}">
                                                {{ ucfirst($sessionNote->attendance) }}
                                            </span>
                                        </p>
                                    @endif

                                    @if($sessionNote->content)
                                        <div class="mb-3">
                                            <strong>Session Summary:</strong>
                                            <div class="mt-2 p-3 bg-white border rounded">
                                                @if(auth()->check() && auth()->user()->role === 'counselor')
                                                    {!! nl2br(e($sessionNote->content)) !!}
                                                @else
                                                    <div class="text-muted"><em>Private note — visible only to your counselor.</em></div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if($sessionNote->next_session)
                                        <div class="alert alert-info">
                                            <i class="bi bi-calendar-event me-2"></i>
                                            <strong>Next Session:</strong> {{ $sessionNote->next_session }}
                                        </div>
                                    @endif

                                    @if($sessionNote->recommendations)
                                        <div class="mb-3">
                                            <strong>Recommendations:</strong>
                                            <div class="mt-2 p-3 bg-light border rounded">
                                                {!! nl2br(e($sessionNote->recommendations)) !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <!-- Feedback Section -->
                            @php
                                $existingFeedback = \App\Models\SessionFeedback::where('appointment_id', $appointment->id)->first();
                            @endphp
                            <div class="mt-3 p-3 bg-light border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold">
                                            <i class="bi bi-star me-2"></i>
                                            Session Feedback
                                        </h6>
                                        @if($existingFeedback)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="d-flex">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star{{ $i <= $existingFeedback->rating ? '-fill' : '' }} text-warning"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-muted small">({{ $existingFeedback->rating }}/5)</span>
                                            </div>
                                            <p class="mb-0 text-muted small mt-1">{{ Str::limit($existingFeedback->comments, 100) }}</p>
                                        @else
                                            <p class="mb-0 text-muted small">No feedback provided yet</p>
                                        @endif
                                    </div>
                                    @if(!$existingFeedback)
                                        <a href="{{ route('session-feedback.create', $appointment->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-star me-1"></i>
                                            Provide Feedback
                                        </a>
                                    @else
                                        <span class="badge bg-success">Feedback Submitted</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-journal-x"></i>
            <h4 class="mb-3">No Completed Appointments with Session Notes</h4>
            <p class="mb-3">You don't have any completed appointments with session notes yet.</p>
            <p class="mb-0">Session notes will appear here once your counselor completes a session and adds notes.</p>
        </div>
    @endif
</div>
@endsection 