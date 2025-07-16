@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointment Details</h1>
    <div class="mb-3">
        <strong>Student:</strong> {{ $appointment->student->name ?? 'N/A' }}
    </div>
    <div class="mb-3">
        <strong>Date & Time:</strong> {{ $appointment->scheduled_at->format('Y-m-d H:i') }}
    </div>
    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($appointment->status) }}
    </div>
    <div class="mb-3">
        <strong>Notes:</strong> {{ $appointment->notes ?? 'None' }}
    </div>
    <div class="mb-3">
        <a href="{{ route('counselor.session_notes.create', $appointment->id) }}" class="btn btn-primary">Add Session Note</a>
    </div>
    <a href="{{ route('counselor.appointments.index') }}" class="btn btn-secondary">Back to Appointments</a>
</div>
@endsection 