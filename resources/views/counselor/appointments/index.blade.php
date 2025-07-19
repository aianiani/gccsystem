@extends('layouts.app')

@section('content')
{{-- Remove the sidebar include --}}
{{-- @include('counselor.sidebar') --}}

<div class="d-flex justify-content-end mb-3" style="margin-top: 20px;">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-success">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
</div>
<style>
    .centered-appointments-container {
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .main-content { margin-left: 0; width: 100%; max-width: 900px; }
    .appointments-header {
        background: linear-gradient(135deg, #2d5016 0%, #4a7c59 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
    }
    .appointment-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px 0 rgba(0,0,0,0.06);
        border: 1px solid #f1f3f4;
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .appointment-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .status-badge {
        border-radius: 12px;
        padding: 0.25rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        display: inline-block;
    }
    .status-pending { background: #ffc107; color: #2d5016; }
    .status-completed { background: #28a745; }
    .status-cancelled { background: #dc3545; }
    .status-upcoming { background: #17a2b8; }
    .status-accepted { background: #0d6efd; }
    .status-declined { background: #6c757d; }
    .action-btn {
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.95rem;
        font-weight: 500;
        margin-right: 0.5rem;
        transition: background 0.2s, color 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .action-btn.view { background: #2d5016; color: #fff; }
    .action-btn.view:hover { background: #4a7c59; }
    .action-btn.edit { background: #f4d03f; color: #2d5016; }
    .action-btn.edit:hover { background: #f1c40f; }
    .action-btn.cancel { background: #dc3545; color: #fff; }
    .action-btn.cancel:hover { background: #b52a37; }
    .action-btn.complete { background: #28a745; color: #fff; }
    .action-btn.complete:hover { background: #218838; }
    .action-btn.notes { background: #17a2b8; color: #fff; }
    .action-btn.notes:hover { background: #138496; }
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px dashed #f1f3f4;
        margin-top: 2rem;
    }
    .empty-state i { font-size: 2rem; color: #6c757d; margin-bottom: 1rem; }
    @media (max-width: 991.98px) { .main-content { max-width: 100%; } }
    @media (max-width: 767.98px) { .main-content { margin-left: 0; } }
</style>
<div class="centered-appointments-container">
    <div class="main-content">
        <div class="container-fluid py-4">
            <div class="appointments-header d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
                <div>
                    <h1 class="mb-2 fw-bold d-flex align-items-center" style="gap: 0.75rem;">
                        <i class="bi bi-calendar-event" style="font-size: 2rem;"></i>
                        My Appointments
                    </h1>
                    <p class="mb-0">Manage and review all your counseling appointments here.</p>
                </div>
                <a href="{{ route('counselor.session_notes.index') }}" class="action-btn edit">
                    <i class="bi bi-journal-text"></i> Go to Session Notes
                </a>
            </div>
            <!-- Filter/Search -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-3">
                    <input type="text" name="student" class="form-control" placeholder="Search by student" value="{{ request('student') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-funnel"></i> Filter</button>
                </div>
            </form>
            {{-- Removed All Appointments card as requested --}}
            <!-- Appointments List -->
            @forelse($appointments as $appointment)
                @if($appointment->status !== 'cancelled')
                    @php
                        $start = $appointment->scheduled_at;
                        $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                            ->where('start', $start)
                            ->first();
                        $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                    @endphp
                    <div class="appointment-card">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $appointment->student->avatar_url }}" 
                                     alt="{{ $appointment->student->name }}" 
                                     class="rounded-circle" 
                                     style="width: 48px; height: 48px; object-fit: cover; border: 2px solid #2d5016;">
                                <div>
                                    <h5 class="mb-1 fw-bold" style="color: #2d5016;">{{ $appointment->student->name ?? 'N/A' }}</h5>
                                    <div class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> {{ $start->format('M d, Y - g:i A') }} – {{ $end->format('g:i A') }}
                                    </div>
                                </div>
                                @php
                                    // Get the session note for this appointment (if any)
                                    $sessionNoteForThisAppointment = $appointment->sessionNotes->first();
                                @endphp
                                @if($sessionNoteForThisAppointment)
                                    <span class="badge bg-primary ms-2">Session {{ $sessionNoteForThisAppointment->session_number }}</span>
                                @endif
                            </div>
                            <div>
                                <span class="status-badge status-{{ $appointment->status }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @if($appointment->status === 'pending')
                                <div class="btn-group" role="group">
                                    <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="action-btn view"><i class="bi bi-eye"></i> View</a>
                                    <form action="{{ route('counselor.appointments.accept', $appointment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn complete"><i class="bi bi-check-circle"></i> Accept</button>
                                    </form>
                                    <form action="{{ route('counselor.appointments.decline', $appointment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn cancel"><i class="bi bi-x-circle"></i> Decline</button>
                                    </form>
                                </div>
                            @endif
                            @if($appointment->status === 'accepted')
                                <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="action-btn view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('counselor.appointments.edit', $appointment->id) }}" class="action-btn edit">
                                    <i class="bi bi-calendar2-week"></i> Reschedule
                                </a>
                                <form action="{{ route('counselor.appointments.complete', $appointment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="action-btn complete"><i class="bi bi-check-circle"></i> Mark Complete</button>
                                </form>
                            @endif
                            @if($appointment->status === 'completed')
                                <a href="{{ route('counselor.session_notes.create', $appointment->id) }}" class="action-btn notes">
                                    <i class="bi bi-journal-plus"></i> Add/View Session Notes
                                </a>
                                @if($sessionNoteForThisAppointment)
                                    <a href="{{ route('counselor.session_notes.show', $sessionNoteForThisAppointment->id) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View Session Note
                                    </a>
                                @endif
                                <form action="{{ route('counselor.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn cancel" onclick="return confirm('Are you sure you want to permanently delete this appointment?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                            @if($appointment->status === 'declined')
                                <form action="{{ route('counselor.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn cancel" onclick="return confirm('Are you sure you want to permanently delete this appointment?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                            @if(in_array($appointment->status, ['rescheduled_pending', 'accepted', 'declined']) && $appointment->previous_scheduled_at)
                                <div class="mt-2 reschedule-status-card small d-flex align-items-center gap-2" style="background: #f8fafc; border: 1px solid #bee5eb; border-radius: 10px; padding: 1rem;">
                                    <i class="bi bi-arrow-repeat me-2 fs-4 text-info"></i>
                                    <div>
                                        @if($appointment->status === 'rescheduled_pending')
                                            <strong>Waiting for student approval for the new rescheduled date.</strong><br>
                                        @elseif($appointment->status === 'accepted')
                                            <strong>The student has <span class="text-success">accepted</span> the new rescheduled date.</strong><br>
                                        @elseif($appointment->status === 'declined')
                                            <strong>The student has <span class="text-danger">declined</span> the new rescheduled date.</strong><br>
                                        @endif
                                        <span>Old date and time: <b>{{ $appointment->previous_scheduled_at ? $appointment->previous_scheduled_at->format('F j, Y \\a\\t g:i A') : 'N/A' }}</b></span><br>
                                        <span>Rescheduled date and time: <b>{{ $appointment->scheduled_at->format('F j, Y \\a\\t g:i A') }}</b></span>
                                    </div>
                                    <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-outline-primary btn-sm ms-auto"><i class="bi bi-eye me-1"></i> View</a>
                                </div>
                            @endif
                        </div>
                        @if($appointment->notes && $appointment->status !== 'completed' && $appointment->status !== 'accepted' && $appointment->status !== 'declined')
                            <div class="mt-2 text-muted small"><i class="bi bi-journal-text"></i> Notes: {{ Str::limit($appointment->notes, 80) }}</div>
                        @endif
                        @if($appointment->status === 'accepted')
                            <div class="mt-2 text-success small"><i class="bi bi-journal-text"></i> This appointment has been accepted.</div>
                        @endif
                        @if($appointment->status === 'completed')
                            <div class="mt-2 text-primary small"><i class="bi bi-journal-text"></i> Session notes available.</div>
                        @endif
                        @if($appointment->status === 'declined')
                            <div class="mt-2 text-danger small"><i class="bi bi-journal-text"></i> Your appointment was declined. Please select another available slot or contact the GCC for assistance.</div>
                        @endif
                    </div>
                @endif
            @empty
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <p class="mb-0">No appointments found. Try adjusting your filters or create a new appointment.</p>
                </div>
            @endforelse
            {{-- Pagination controls --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $appointments->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection 