@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px;">
    <h1 class="fw-bold mb-4 university-brand d-flex align-items-center gap-2">
        <i class="bi bi-clock-history"></i> Session History Timeline
    </h1>
    @if($student)
        <div class="mb-4 d-flex align-items-center gap-3">
            <img src="{{ $student->avatar_url }}" alt="Avatar" class="rounded-circle border border-3" style="width: 60px; height: 60px; object-fit: cover; border-color: var(--primary);">
            <div>
                <h4 class="fw-bold mb-1" style="color: var(--primary);">{{ $student->name }}</h4>
                <div class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $student->email }}</div>
            </div>
        </div>
    @endif
    @if($sessionNotes->count())
        <ul class="timeline list-unstyled">
            @foreach($sessionNotes as $note)
                <li class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary">Session {{ $note->session_number }}</span>
                        <span class="text-muted small">{{ $note->appointment->scheduled_at->format('F j, Y') }}</span>
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
                        <span class="ms-2 small">
                            <strong>Attendance:</strong> {{ ucfirst($note->attendance) }}
                        </span>
                    </div>
                    <div class="bg-light p-3 rounded border mb-1">
                        <div class="mb-2"><strong>Note:</strong> {{ $note->note }}</div>
                        @if($note->attendance === 'missed' && $note->absence_reason)
                            <div class="text-danger small"><strong>Absence Reason:</strong> {{ $note->absence_reason }}</div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info">No session notes found for this student.</div>
    @endif
    <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary mt-3"><i class="bi bi-arrow-left"></i> Back to Session Notes</a>
</div>
@endsection 