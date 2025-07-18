@extends('layouts.app')

@section('content')
<style>
    .centered-session-note-container {
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>
<div class="centered-session-note-container">
    <div class="container" style="max-width: 700px;">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('counselor.appointments.index') }}" class="btn btn-outline-success">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h1 class="mb-4 fw-bold" style="color: var(--forest-green);"><i class="bi bi-journal-plus me-2"></i>Add Session Note</h1>
        <!-- Student & Appointment Details Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex align-items-center gap-4">
                <img src="{{ $appointment->student->avatar_url }}" alt="Avatar" class="rounded-circle border border-3" style="width: 70px; height: 70px; object-fit: cover; border-color: var(--forest-green);">
                <div>
                    <h5 class="fw-bold mb-1" style="color: var(--forest-green);">{{ $appointment->student->name }}</h5>
                    <div class="text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $appointment->student->email }}</div>
                    <div class="mb-1"><span class="badge bg-primary">Student</span></div>
                </div>
                <div class="ms-auto text-end">
                    <div class="mb-1"><i class="bi bi-calendar me-1"></i>{{ $appointment->scheduled_at->format('F j, Y') }}</div>
                    <div class="mb-1"><i class="bi bi-clock me-1"></i>{{ $appointment->scheduled_at->format('g:i A') }} – {{ $appointment->scheduled_at->copy()->addMinutes(30)->format('g:i A') }}</div>
                    <div><span class="badge bg-success">{{ ucfirst($appointment->status) }}</span></div>
                </div>
            </div>
        </div>
        @php
            $studentId = $appointment->student_id;
            $appointments = \App\Models\Appointment::where('student_id', $studentId)
                ->orderBy('scheduled_at')
                ->pluck('id')
                ->toArray();
            $nextSessionNumber = array_search($appointment->id, $appointments) !== false ? array_search($appointment->id, $appointments) + 1 : 1;
        @endphp
        <form action="{{ route('counselor.session_notes.store', $appointment->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Session Number</label>
                <div>
                    <span class="badge bg-primary">{{ $nextSessionNumber }}</span>
                </div>
                <input type="hidden" name="session_number" value="{{ $nextSessionNumber }}">
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Session Note</label>
                <textarea name="note" id="note" class="form-control" rows="5">{{ old('note') }}</textarea>
                @error('note')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="next_session" class="form-label">Next Session (optional)</label>
                <input type="datetime-local" name="next_session" id="next_session" class="form-control" value="{{ old('next_session') }}">
            </div>
            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i> Save Note</button>
            <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection 