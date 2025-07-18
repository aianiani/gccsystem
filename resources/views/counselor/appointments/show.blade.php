@extends('layouts.app')

@section('content')
<style>
    .appointment-dashboard-header {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 2rem 2rem 1.5rem 2rem;
        margin-bottom: 0;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
    }
    .appointment-dashboard-header .title {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .appointment-dashboard-header .badge {
        font-size: 1.1rem;
        padding: 0.7em 1.2em;
        border-radius: 999px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(44,62,80,0.08);
    }
    .appointment-card {
        background: white;
        border-radius: 0 0 16px 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        padding: 2.5rem 2rem 2rem 2rem;
        margin-bottom: 2rem;
    }
    .appointment-section-title {
        color: var(--forest-green);
        font-weight: 700;
        margin-bottom: 1.2rem;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .appointment-avatar {
        border: 3px solid var(--yellow-maize);
        box-shadow: 0 2px 8px rgba(244, 208, 63, 0.08);
    }
    .list-group-item {
        border: none;
        border-bottom: 1px solid var(--gray-100);
        background: transparent;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    .btn {
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.01em;
    }
    .btn-success, .btn-warning, .btn-danger, .btn-primary, .btn-secondary {
        box-shadow: 0 1px 3px var(--shadow-sm);
    }
    .btn-outline-primary {
        border: 1.5px solid var(--forest-green);
        color: var(--forest-green);
        background: transparent;
    }
    .btn-outline-primary:hover {
        background: var(--forest-green-light);
        color: white;
    }
    .text-muted {
        color: var(--gray-600) !important;
    }
    @media (max-width: 600px) {
        .appointment-dashboard-header, .appointment-card {
            padding: 1.2rem 0.7rem;
        }
    }
</style>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('counselor.appointments.index') }}" class="btn btn-secondary mb-3" style="border-radius: 999px; min-width: 0; display: inline-flex; align-items: center; gap: 0.5rem;"><i class="bi bi-arrow-left"></i> Back to Appointments</a>
            <div class="appointment-dashboard-header mb-0">
                <div class="title">
                    <i class="bi bi-calendar-event fs-2"></i>
                    Appointment Details
                </div>
                <span class="badge {{
                    $appointment->status === 'completed' ? 'bg-success' :
                    ($appointment->status === 'cancelled' ? 'bg-danger' :
                    ($appointment->status === 'rescheduled_pending' ? 'bg-warning text-dark' :
                    ($appointment->status === 'declined' ? 'bg-danger' :
                    ($appointment->status === 'accepted' ? 'bg-primary' : 'bg-secondary'))))
                }} text-capitalize">
                    {{ str_replace('_', ' ', $appointment->status) }}
                </span>
            </div>
            <div class="appointment-card">
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        <img src="{{ $appointment->student->avatar_url ?? asset('images/logo.jpg') }}" alt="Avatar" class="rounded-circle border shadow-sm mb-2 appointment-avatar" width="80" height="80">
                        <div class="fw-bold">{{ $appointment->student->name ?? 'N/A' }}</div>
                        <div class="text-muted small">{{ $appointment->student->email ?? '' }}</div>
                    </div>
                    <div class="col-md-9">
                        <div class="mb-2">
                            <i class="bi bi-clock me-2 text-primary"></i>
                            <strong>Date & Time:</strong>
                            @php
                                $start = $appointment->scheduled_at;
                                $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                                    ->where('start', $start)
                                    ->first();
                                $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                            @endphp
                            {{ $start->format('l, F j, Y') }}<br>
                            <span class="ms-4">{{ $start->format('h:i A') }} – {{ $end->format('h:i A') }}</span>
                        </div>
                        @if($appointment->status === 'rescheduled_pending' && $appointment->rescheduled_from)
                            <div class="mb-2">
                                <i class="bi bi-arrow-repeat me-2 text-warning"></i>
                                <strong>Previous Time:</strong> {{ \Carbon\Carbon::parse($appointment->rescheduled_from)->format('l, F j, Y h:i A') }}
                            </div>
                        @endif
                        <div class="mb-2">
                            <i class="bi bi-chat-left-text me-2 text-info"></i>
                            <strong>Notes:</strong> {{ $appointment->notes ?? 'None' }}
                        </div>
                    </div>
                </div>

                @if($appointment->status === 'completed')
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="appointment-section-title"><i class="bi bi-journal-text text-success"></i>Session Notes</div>
                        @if($appointment->sessionNotes && $appointment->sessionNotes->count())
                            <ul class="list-group mb-3">
                                @foreach($appointment->sessionNotes as $note)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold">{{ $note->created_at->format('M d, Y h:i A') }}</div>
                                            <div>{{ $note->content }}</div>
                                        </div>
                                        <a href="{{ route('counselor.session_notes.edit', [$appointment->id, $note->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted mb-2">No session notes yet.</div>
                        @endif
                        <a href="{{ route('counselor.session_notes.create', $appointment->id) }}" class="btn btn-success"><i class="bi bi-plus-circle me-1"></i> Add Session Note</a>
                    </div>
                </div>
                @endif

                <div class="d-flex flex-wrap gap-2 mt-4">
                    @if($appointment->status === 'pending')
                        <form method="POST" action="{{ route('counselor.appointments.accept', $appointment->id) }}" onsubmit="return confirm('Accept this appointment?');" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Accept</button>
                        </form>
                        <a href="{{ route('counselor.appointments.reschedule', $appointment->id) }}" class="btn btn-warning"><i class="bi bi-arrow-repeat me-1"></i> Reschedule</a>
                        <form method="POST" action="{{ route('counselor.appointments.decline', $appointment->id) }}" onsubmit="return confirm('Decline this appointment?');" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle me-1"></i> Decline</button>
                        </form>
                    @else
                        <a href="{{ route('counselor.appointments.reschedule', $appointment->id) }}" class="btn btn-warning"><i class="bi bi-arrow-repeat me-1"></i> Reschedule</a>
                        <form method="POST" action="{{ route('counselor.appointments.cancel', $appointment->id) }}" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                            @csrf
                            <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                        </form>
                    @endif
                    <a href="mailto:{{ $appointment->student->email }}" class="btn btn-outline-primary"><i class="bi bi-envelope me-1"></i> Message Student</a>
                </div>

                @if($appointment->status === 'completed' && (!$appointment->sessionNotes || $appointment->sessionNotes->count() === 0))
                    <div class="mt-4 mb-3">
                        <a href="{{ route('counselor.session_notes.create', $appointment->id) }}" class="btn btn-success"><i class="bi bi-plus-circle me-1"></i> Add Session Note</a>
                    </div>
                @endif

                <div class="row mb-2 mt-4">
                    <div class="col-12">
                        <div class="appointment-section-title"><i class="bi bi-clock-history text-secondary"></i>Appointment History</div>
                        @if($appointment->activityLogs && $appointment->activityLogs->count())
                            <ul class="list-group mb-3">
                                @foreach($appointment->activityLogs as $log)
                                    <li class="list-group-item small">
                                        <span class="fw-semibold">{{ $log->created_at->format('M d, Y h:i A') }}:</span>
                                        {{ $log->description }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted mb-2">No history available.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 