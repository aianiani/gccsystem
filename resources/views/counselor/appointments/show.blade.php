@extends('layouts.app')

@section('content')
<style>
    /* Dashboard theme variables - matching dashboard exactly */
    :root {
        --primary-green: #1f7a2d; /* Dashboard forest green */
        --primary-green-2: #13601f; /* darker stop */
        --accent-green: #2e7d32;
        --light-green: #eaf5ea;
        --accent-orange: #FFCB05;
        --text-dark: #16321f;
        --text-light: #6c757d;
        --bg-light: #f6fbf6;
        --shadow: 0 10px 30px rgba(0,0,0,0.08);

        /* Map dashboard-specific names to homepage palette for compatibility */
        --forest-green: var(--primary-green);
        --forest-green-dark: var(--primary-green-2);
        --forest-green-light: var(--accent-green);
        --forest-green-lighter: var(--light-green);
        --yellow-maize: var(--accent-orange);
        --yellow-maize-light: #fef9e7;
        --white: #ffffff;
        --gray-50: var(--bg-light);
        --gray-100: #eef6ee;
        --gray-600: var(--text-light);
        --danger: #dc3545;
        --warning: #ffc107;
        --success: #28a745;
        --info: #17a2b8;
        --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
        --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
    }

    /* Apply the same page zoom used on the homepage */
    .home-zoom {
        zoom: 0.85;
    }
    @supports not (zoom: 1) {
        .home-zoom {
            transform: scale(0.85);
            transform-origin: top center;
        }
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-dashboard-content {
        background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
        min-height: 100vh;
        padding: 1rem 1.5rem;
    }

    .main-dashboard-inner {
        max-width: 1180px;
        margin: 0 auto;
    }

    .appointment-dashboard-header {
        background: var(--hero-gradient);
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 2rem;
        margin-bottom: 0;
        box-shadow: var(--shadow-sm);
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
        font-size: 1rem;
        padding: 0.5em 1em;
        border-radius: 999px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .appointment-card {
        background: var(--white);
        border-radius: 0 0 12px 12px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    .info-section {
        background: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--gray-100);
        box-shadow: var(--shadow-sm);
    }
    .appointment-section-title {
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 1.2rem;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--forest-green);
    }
    .appointment-avatar {
        border: 3px solid var(--yellow-maize);
        box-shadow: var(--shadow-sm);
    }
    .info-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--gray-100);
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: var(--text-light);
        width: 200px;
        flex-shrink: 0;
    }
    .info-value {
        color: var(--text-dark);
        flex: 1;
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
        transition: all 0.3s ease;
    }
    .btn-success, .btn-warning, .btn-danger, .btn-primary, .btn-secondary {
        box-shadow: var(--shadow-sm);
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .btn-outline-primary {
        border: 1.5px solid var(--forest-green);
        color: var(--forest-green);
        background: transparent;
    }
    .btn-outline-primary:hover {
        background: var(--forest-green);
        color: white;
    }
    .text-muted {
        color: var(--gray-600) !important;
    }
    .reference-number {
        background: var(--light-green);
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 0;
        text-align: center;
        border: 1px solid var(--gray-100);
    }
    .reference-number strong {
        color: var(--text-dark);
        font-size: 1.1rem;
    }
    @media (max-width: 600px) {
        .appointment-dashboard-header, .appointment-card, .info-section {
            padding: 1.2rem;
        }
        .info-label {
            width: 150px;
        }
    }
</style>
<div class="home-zoom">
<div class="main-dashboard-content">
    <div class="main-dashboard-inner">
        <a href="{{ route('counselor.appointments.index') }}" class="btn btn-secondary mb-3" style="border-radius: 8px; display: inline-flex; align-items: center; gap: 0.5rem;"><i class="bi bi-arrow-left"></i> Back to Appointments</a>
        
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
            <!-- Reference Number -->
            <div class="reference-number mb-4">
                <strong>Reference Number: {{ $appointment->reference_number }}</strong>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex flex-wrap gap-2 mb-4">
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

            <!-- Appointment Details -->
            <div class="info-section">
                <div class="appointment-section-title"><i class="bi bi-calendar-event"></i>Appointment Details</div>
                @php
                    $start = $appointment->scheduled_at;
                    $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                        ->where('start', $start)
                        ->first();
                    $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                @endphp
                <div class="info-row">
                    <div class="info-label">Date & Time:</div>
                    <div class="info-value">
                        {{ $start->format('l, F j, Y') }}<br>
                        <span class="text-muted">{{ $start->format('h:i A') }} – {{ $end->format('h:i A') }}</span>
                    </div>
                </div>
                @if($appointment->status === 'rescheduled_pending' && $appointment->rescheduled_from)
                <div class="info-row">
                    <div class="info-label">Previous Time:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($appointment->rescheduled_from)->format('l, F j, Y h:i A') }}</div>
                </div>
                @endif
                @if($appointment->notes)
                <div class="info-row">
                    <div class="info-label">Notes:</div>
                    <div class="info-value">{{ $appointment->notes }}</div>
                </div>
                @endif
            </div>

            <!-- Student Information -->
            <div class="info-section">
                <div class="appointment-section-title"><i class="bi bi-person-circle"></i>Student Information</div>
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <img src="{{ $appointment->student->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($appointment->student->name) . '&background=1f7a2d&color=fff' }}" alt="Avatar" class="rounded-circle border shadow-sm mb-2 appointment-avatar" width="80" height="80">
                    </div>
                    <div class="col-md-9">
                        <div class="info-row">
                            <div class="info-label">Full Name:</div>
                            <div class="info-value"><strong>{{ $appointment->student->name ?? 'N/A' }}</strong></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Email:</div>
                            <div class="info-value">{{ $appointment->student->email ?? 'N/A' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Contact Number:</div>
                            <div class="info-value">{{ $appointment->student->contact_number ?? 'N/A' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">College:</div>
                            <div class="info-value">{{ $appointment->student->college ?? 'N/A' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Course:</div>
                            <div class="info-value">{{ $appointment->student->course ?? 'N/A' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Year Level:</div>
                            <div class="info-value">{{ $appointment->student->year_level ?? 'N/A' }}</div>
                        </div>
                        @if($appointment->student->address)
                        <div class="info-row">
                            <div class="info-label">Address:</div>
                            <div class="info-value">{{ $appointment->student->address }}</div>
                        </div>
                        @endif
                        @if($appointment->student->gender)
                        <div class="info-row">
                            <div class="info-label">Gender:</div>
                            <div class="info-value">{{ ucfirst($appointment->student->gender) }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Nature of Problem -->
            <div class="info-section">
                <div class="appointment-section-title"><i class="bi bi-question-circle"></i>Nature of Problem</div>
                <div class="info-row">
                    <div class="info-label">Category:</div>
                    <div class="info-value">{{ $appointment->nature_of_problem ?? 'N/A' }}</div>
                </div>
                @if($appointment->nature_of_problem === 'Other' && $appointment->nature_of_problem_other)
                <div class="info-row">
                    <div class="info-label">Details:</div>
                    <div class="info-value">{{ $appointment->nature_of_problem_other }}</div>
                </div>
                @endif
            </div>

            <!-- Guardian Information -->
            <div class="info-section">
                <div class="appointment-section-title"><i class="bi bi-people"></i>Guardian Information</div>
                <div class="info-row">
                    <div class="info-label">Guardian 1 Name:</div>
                    <div class="info-value"><strong>{{ $appointment->guardian1_name ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Guardian 1 Relationship:</div>
                    <div class="info-value">{{ $appointment->guardian1_relationship ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Guardian 1 Contact:</div>
                    <div class="info-value">{{ $appointment->guardian1_contact ?? 'N/A' }}</div>
                </div>
                @if($appointment->guardian2_name)
                <div class="info-row">
                    <div class="info-label">Guardian 2 Name:</div>
                    <div class="info-value"><strong>{{ $appointment->guardian2_name }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Guardian 2 Relationship:</div>
                    <div class="info-value">{{ $appointment->guardian2_relationship ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Guardian 2 Contact:</div>
                    <div class="info-value">{{ $appointment->guardian2_contact ?? 'N/A' }}</div>
                </div>
                @endif
            </div>

            <!-- Session Notes -->
            @if($appointment->status === 'completed')
            <div class="info-section">
                <div class="appointment-section-title"><i class="bi bi-journal-text"></i>Session Notes</div>
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
            @endif

            <!-- Appointment History -->
            <div class="info-section">
                <div class="appointment-section-title"><i class="bi bi-clock-history"></i>Appointment History</div>
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
@endsection 