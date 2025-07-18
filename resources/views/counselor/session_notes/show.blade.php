@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i> Back</a>
        <h1 class="fw-bold mb-0 university-brand"><i class="bi bi-journal-text me-2"></i>Session Note Details</h1>
    </div>
    <div class="card mb-4 shadow-sm p-4">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <img src="{{ $note->appointment->student->avatar_url ?? '' }}" alt="Avatar" class="rounded-circle border border-3 flex-shrink-0" style="width: 80px; height: 80px; object-fit: cover; border-color: var(--primary);">
            <div class="flex-grow-1">
                <h4 class="fw-bold mb-1" style="color: var(--primary);">{{ $note->appointment->student->name ?? 'N/A' }}</h4>
                <div class="text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $note->appointment->student->email ?? '' }}</div>
                <span class="badge bg-primary">Student</span>
            </div>
            <div class="text-end ms-auto">
                <div class="mb-1"><i class="bi bi-calendar me-1"></i>{{ $note->appointment->scheduled_at->format('F j, Y') }}</div>
                <div class="mb-1"><i class="bi bi-clock me-1"></i>{{ $note->appointment->scheduled_at->format('g:i A') }} – {{ $note->appointment->scheduled_at->copy()->addMinutes(30)->format('g:i A') }}</div>
                <span class="badge bg-success">{{ ucfirst($note->appointment->status) }}</span>
            </div>
        </div>
    </div>
    <div class="card shadow-sm p-4 mb-4">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="mb-2 text-muted fw-semibold">Session Number</div>
                <div class="fs-5">{{ $note->session_number ?? '-' }}</div>
            </div>
            <div class="col-md-8">
                <div class="mb-2 text-muted fw-semibold">Session Note</div>
                <div class="bg-light p-3 rounded border" style="min-height: 80px; font-size: 1.08rem; color: var(--primary);">
                    {{ $note->note }}
                </div>
                <a href="{{ route('counselor.session_notes.edit', $note->id) }}" class="btn btn-outline-primary mt-3"><i class="bi bi-pencil"></i> Edit Session Note</a>
            </div>
        </div>
        @if($note->next_session)
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="mb-2 text-muted fw-semibold">Next Scheduled Session</div>
                    <div class="fs-6">{{ \Carbon\Carbon::parse($note->next_session)->format('F j, Y g:i A') }}</div>
                </div>
            </div>
        @endif
        <div class="row mt-4">
            <div class="col-md-12 d-flex gap-2 align-items-center">
                @php
                    $hasNextAppointment = \App\Models\Appointment::where('counselor_id', $note->counselor_id)
                        ->where('student_id', $note->appointment->student_id)
                        ->where('scheduled_at', $note->next_session)
                        ->exists();
                @endphp
                @if($note->next_session && !$hasNextAppointment)
                    <form action="{{ route('counselor.session_notes.create_next_appointment', $note->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">
                            <i class="bi bi-calendar-plus"></i> Automatically Set Next Appointment & Session
                        </button>
                    </form>
                    <span class="text-muted small ms-2">This will create Session {{ $note->session_number + 1 }} for this student.</span>
                @endif
                <form action="{{ route('counselor.session_notes.remind', $note->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-info"><i class="bi bi-bell"></i> Send Reminder</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 