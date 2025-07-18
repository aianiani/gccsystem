@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1050px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="fw-bold mb-0 university-brand d-flex align-items-center gap-3">
            <i class="bi bi-journal-text" style="font-size: 2rem;"></i> Session Notes
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
            <a href="{{ route('counselor.appointments.index') }}" class="btn btn-success">
                <i class="bi bi-calendar-event me-1"></i> Go to Appointments
            </a>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-center mb-3">
                <div class="col-auto">
                    <input type="text" name="student" class="form-control" placeholder="Filter by student name" value="{{ request('student') }}" style="max-width: 250px;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Filter</button>
                </div>
                @if(request('student'))
                <div class="col-auto">
                    <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
                @endif
            </form>
            <div class="mb-3 d-flex flex-wrap gap-2">
                <a href="{{ route('counselor.session_notes.index', array_merge(request()->except('filter'), ['filter' => null])) }}" class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
                <a href="{{ route('counselor.session_notes.index', array_merge(request()->except('filter'), ['filter' => 'upcoming'])) }}" class="btn btn-sm {{ request('filter') === 'upcoming' ? 'btn-primary' : 'btn-outline-primary' }}">Upcoming</a>
                <a href="{{ route('counselor.session_notes.index', array_merge(request()->except('filter'), ['filter' => 'past'])) }}" class="btn btn-sm {{ request('filter') === 'past' ? 'btn-primary' : 'btn-outline-primary' }}">Past</a>
            </div>
            <div class="table-responsive">
                @php
                    $grouped = $sessionNotes->groupBy('appointment_id');
                @endphp
                @forelse($grouped as $appointmentId => $notes)
                    @php $appointment = $notes->first()->appointment; @endphp
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img src="{{ $appointment->student->avatar_url }}" alt="Avatar" class="rounded-circle border border-2 flex-shrink-0" style="width: 40px; height: 40px; object-fit: cover; border-color: var(--primary);">
                            <div>
                                <span class="fw-semibold" style="color: var(--primary);">{{ $appointment->student->name }}</span>
                                <span class="text-muted ms-2">({{ $appointment->scheduled_at->format('F j, Y') }})</span>
                            </div>
                        </div>
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="align-middle text-center">
                                    <th>Session #</th>
                                    <th>Status</th>
                                    <th>Attendance</th>
                                    <th class="text-start">Note</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notes as $note)
                                    <tr class="align-middle text-center">
                                        <td><span class="badge bg-primary">{{ $note->session_number ?? '-' }}</span></td>
                                        <td>
                                            @php
                                                $status = $note->session_status;
                                                $statusMap = [
                                                    'scheduled' => ['label' => 'Scheduled', 'class' => 'bg-info text-dark', 'icon' => 'calendar-event'],
                                                    'completed' => ['label' => 'Completed', 'class' => 'bg-success', 'icon' => 'check-circle'],
                                                    'missed' => ['label' => 'Missed', 'class' => 'bg-warning text-dark', 'icon' => 'clock'],
                                                    'expired' => ['label' => 'Expired', 'class' => 'bg-danger', 'icon' => 'exclamation-triangle'],
                                                ];
                                            @endphp
                                            @if(isset($statusMap[$status]))
                                                <span class="badge {{ $statusMap[$status]['class'] }} d-inline-flex align-items-center gap-1 px-2 py-2">
                                                    <i class="bi bi-{{ $statusMap[$status]['icon'] }}"></i> {{ $statusMap[$status]['label'] }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('counselor.session_notes.update', $note->id) }}" method="POST" class="d-flex align-items-center gap-2 justify-content-center mb-0">
                                                @csrf
                                                @method('PATCH')
                                                <select name="attendance" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                                    <option value="unknown" {{ $note->attendance === 'unknown' ? 'selected' : '' }}>Unknown</option>
                                                    <option value="attended" {{ $note->attendance === 'attended' ? 'selected' : '' }}>Attended</option>
                                                    <option value="missed" {{ $note->attendance === 'missed' ? 'selected' : '' }}>Missed</option>
                                                </select>
                                                @if($note->attendance === 'missed')
                                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#absenceReasonModal{{ $note->id }}">
                                                        <i class="bi bi-exclamation-triangle"></i> Reason
                                                    </button>
                                                @endif
                                            </form>
                                            @if($note->attendance === 'missed')
                                                <!-- Absence Reason Modal -->
                                                <div class="modal fade" id="absenceReasonModal{{ $note->id }}" tabindex="-1" aria-labelledby="absenceReasonModalLabel{{ $note->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('counselor.session_notes.update', $note->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="absenceReasonModalLabel{{ $note->id }}">Absence Reason</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <textarea name="absence_reason" class="form-control" rows="3" placeholder="Enter reason for absence...">{{ $note->absence_reason }}</textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Save Reason</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-start">
                                            @if(trim($note->note) === '')
                                                <span class="badge bg-warning text-dark">Empty – needs completion</span>
                                            @else
                                                <span class="text-muted">{{ Str::limit($note->note, 60) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{ $note->appointment->scheduled_at->format('F j, Y') }}</td>
                                        <td class="text-nowrap">{{ $note->appointment->scheduled_at->format('g:i A') }} &ndash; {{ $note->appointment->scheduled_at->copy()->addMinutes(30)->format('g:i A') }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                                <a href="{{ route('counselor.session_notes.show', $note->id) }}" class="btn btn-outline-primary btn-sm" title="View"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('counselor.session_notes.timeline', $note->appointment->student->id) }}" class="btn btn-outline-secondary btn-sm" title="Timeline"><i class="bi bi-clock-history"></i></a>
                                                @if($note->session_status !== 'completed')
                                                    <a href="{{ route('counselor.session_notes.edit', $note->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                                    <form action="{{ route('counselor.session_notes.complete', $note->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm" title="Mark Completed"><i class="bi bi-check-circle"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                            <i class="bi bi-journal-x" style="font-size: 2.5rem; color: var(--primary);"></i>
                            <div class="mt-2">No session notes found.</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 