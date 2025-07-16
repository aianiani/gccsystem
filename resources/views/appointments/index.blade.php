@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Appointments</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">Book Appointment</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Counselor</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->counselor->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->scheduled_at->format('Y-m-d H:i') }}</td>
                        <td>{{ ucfirst($appointment->status) }}</td>
                        <td>{{ $appointment->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 