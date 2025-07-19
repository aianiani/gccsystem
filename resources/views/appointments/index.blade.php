@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title mb-0"><i class="bi bi-calendar-check me-2"></i>My Appointments</h1>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Book Appointment
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($appointments->count())
        <div class="row g-4">
            @foreach($appointments as $appointment)
                @php
                    $start = $appointment->scheduled_at;
                    $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                        ->where('start', $start)
                        ->first();
                    $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex align-items-center gap-2" style="background: var(--primary-light); color: var(--primary);">
                            <img src="{{ $appointment->counselor->avatar_url }}" 
                                 alt="{{ $appointment->counselor->name }}" 
                                 class="rounded-circle" 
                                 style="width: 40px; height: 40px; object-fit: cover; border: 2px solid var(--primary);">
                            <span class="fw-bold">{{ $appointment->counselor->name ?? 'N/A' }}</span>
                            @php
                                // Get the session note for this appointment (if any)
                                $sessionNoteForThisAppointment = $appointment->sessionNotes->first();
                            @endphp
                            @if($sessionNoteForThisAppointment)
                                <span class="badge bg-primary ms-auto">Session {{ $sessionNoteForThisAppointment->session_number }}</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <i class="bi bi-clock me-1 text-primary"></i>
                                <span class="fw-semibold">{{ $start->format('M d, Y - g:i A') }} – {{ $end->format('g:i A') }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="badge 
                                    @if($appointment->status === 'pending') bg-warning text-dark
                                    @elseif($appointment->status === 'accepted') bg-success
                                    @elseif($appointment->status === 'completed') bg-primary
                                    @elseif($appointment->status === 'declined' || $appointment->status === 'cancelled') bg-danger
                                    @elseif($appointment->status === 'rescheduled_pending') bg-info text-dark
                                    @else bg-secondary
                                    @endif
                                    px-3 py-2 fs-6 shadow-sm">
                                    <i class="bi bi-info-circle me-1"></i>{{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                            <div class="mb-2">
                                @if($appointment->status === 'accepted')
                                    <span class="text-success"><i class="bi bi-journal-text me-1"></i>Your Appointment has been accepted, please proceed to GCC on {{ $start->format('M d, Y') }} at {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}.</span>
                                @elseif($appointment->status === 'completed')
                                    <span class="text-primary"><i class="bi bi-journal-text me-1"></i>Session completed.</span>
                                @elseif($appointment->status === 'declined')
                                    <span class="text-danger"><i class="bi bi-journal-text me-1"></i>Your appointment was declined. Please select another available slot or contact the GCC for assistance.</span>
                                @elseif($appointment->status === 'rescheduled_pending')
                                    <span class="text-info"><i class="bi bi-arrow-repeat me-1"></i>Your counselor has proposed a new slot. Please accept or decline below.</span>
                                    <form action="{{ route('appointments.acceptReschedule', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm me-2"><i class="bi bi-check-circle me-1"></i>Accept</button>
                                    </form>
                                    <form action="{{ route('appointments.declineReschedule', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-circle me-1"></i>Decline</button>
                                    </form>
                                @elseif($appointment->notes)
                                    <span class="text-muted"><i class="bi bi-journal-text me-1"></i>{{ Str::limit($appointment->notes, 60) }}</span>
                                @else
                                    <span class="text-muted"><i class="bi bi-journal-text me-1"></i>No notes</span>
                                @endif
                            </div>
                            
                            {{-- Display Session Notes for Completed Appointments --}}
                            @if($appointment->status === 'completed' && $appointment->sessionNotes->count() > 0)
                                <div class="mt-3 p-3 bg-light rounded border-start border-3 border-primary">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="bi bi-journal-text me-1"></i>Session Notes
                                    </h6>
                                    @foreach($appointment->sessionNotes as $sessionNote)
                                        <div class="mb-3">
                                            @if($sessionNote->session_number)
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="badge bg-primary me-2">Session {{ $sessionNote->session_number }}</span>
                                                </div>
                                            @endif
                                            <div class="bg-white p-3 rounded border">
                                                <p class="mb-0">{{ $sessionNote->note }}</p>
                                            </div>
                                            {{-- Show the session's own completion date if completed --}}
                                            @if($sessionNote->session_status === 'completed')
                                                <div class="mt-2">
                                                    <small class="text-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        <strong>Session Completed:</strong> {{ $sessionNote->appointment->scheduled_at->format('F j, Y g:i A') }}
                                                    </small>
                                                </div>
                                            @endif
                                            {{-- Show the next session date if it exists and is not completed --}}
                                            @if($sessionNote->next_session)
                                                @php
                                                    $sessionDate = \Carbon\Carbon::parse($sessionNote->next_session);
                                                    // Check if there is a session note for this appointment and date with status completed
                                                    $nextCompleted = $appointment->sessionNotes->where('session_number', $sessionNote->session_number + 1)
                                                        ->where('session_status', 'completed')
                                                        ->first();
                                                @endphp
                                                <div class="mt-2">
                                                    @if($sessionNote->session_status === 'expired')
                                                        <small class="text-danger">
                                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                                            <strong>Session Expired:</strong> {{ $sessionDate->format('F j, Y g:i A') }}
                                                        </small>
                                                    @elseif($sessionNote->session_status === 'missed')
                                                        <small class="text-warning">
                                                            <i class="bi bi-clock me-1"></i>
                                                            <strong>Session Missed:</strong> {{ $sessionDate->format('F j, Y g:i A') }}
                                                        </small>
                                                    @elseif($nextCompleted)
                                                        <small class="text-success">
                                                            <i class="bi bi-check-circle me-1"></i>
                                                            <strong>Session Completed:</strong> {{ $sessionDate->format('F j, Y g:i A') }}
                                                        </small>
                                                    @else
                                                        <small class="text-info">
                                                            <i class="bi bi-calendar-event me-1"></i>
                                                            <strong>Next Session:</strong> {{ $sessionDate->format('F j, Y g:i A') }}
                                                        </small>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    

                                </div>
                            @elseif($appointment->status === 'completed')
                                <div class="mt-3 p-3 bg-light rounded border-start border-3 border-secondary">
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        No session notes available yet. Your counselor will add notes after the session.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="d-flex flex-column align-items-center justify-content-center py-5">
            <i class="bi bi-calendar-x display-1 mb-3 text-secondary"></i>
            <h4 class="mb-2 text-muted">No appointments found.</h4>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary mt-2">
                <i class="bi bi-plus-circle me-1"></i> Book Your First Appointment
            </a>
        </div>
    @endif
</div>
@endsection 