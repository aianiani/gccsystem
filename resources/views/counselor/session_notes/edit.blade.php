@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h1 class="mb-4 fw-bold" style="color: var(--forest-green);"><i class="bi bi-pencil me-2"></i>Edit Session Note</h1>
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex align-items-center gap-4">
            <img src="{{ $note->appointment->student->avatar_url }}" alt="Avatar" class="rounded-circle border border-3" style="width: 60px; height: 60px; object-fit: cover; border-color: var(--forest-green);">
            <div>
                <h5 class="fw-bold mb-1" style="color: var(--forest-green);">{{ $note->appointment->student->name }}</h5>
                <div class="text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $note->appointment->student->email }}</div>
                <div class="mb-1"><span class="badge bg-primary">Session {{ $note->session_number }}</span></div>
            </div>
            <div class="ms-auto text-end">
                <div class="mb-1"><i class="bi bi-calendar me-1"></i>{{ $note->appointment->scheduled_at->format('F j, Y') }}</div>
                <div class="mb-1"><i class="bi bi-clock me-1"></i>{{ $note->appointment->scheduled_at->format('g:i A') }} – {{ $note->appointment->scheduled_at->copy()->addMinutes(30)->format('g:i A') }}</div>
                <div><span class="badge bg-info text-dark">{{ ucfirst($note->session_status) }}</span></div>
            </div>
        </div>
    </div>
    @if(trim($note->note) === '')
        <div class="alert alert-warning mb-3">
            This session note is empty. Please fill it out and save to complete the session.
        </div>
    @endif
    <form action="{{ route('counselor.session_notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="note" class="form-label fw-bold">Session Note</label>
            <textarea name="note" id="note" class="form-control" rows="5">{{ old('note', $note->note) }}</textarea>
            @error('note')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="attendance" class="form-label fw-bold">Attendance</label>
            <select name="attendance" id="attendance" class="form-select">
                <option value="unknown" {{ $note->attendance === 'unknown' ? 'selected' : '' }}>Unknown</option>
                <option value="attended" {{ $note->attendance === 'attended' ? 'selected' : '' }}>Attended</option>
                <option value="missed" {{ $note->attendance === 'missed' ? 'selected' : '' }}>Missed</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="next_session" class="form-label">Next Session (optional)</label>
            <input type="datetime-local" name="next_session" id="next_session" class="form-control" value="{{ old('next_session', $note->next_session ? $note->next_session->format('Y-m-d\TH:i') : '') }}">
        </div>
        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i>Save Changes</button>
        <a href="{{ route('counselor.session_notes.show', $note->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 