@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Session Note</h1>
    <form action="{{ route('counselor.session_notes.store', $appointment->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="note" class="form-label">Session Note</label>
            <textarea name="note" id="note" class="form-control" rows="5" required>{{ old('note') }}</textarea>
            @error('note')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Save Note</button>
        <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 