@component('emails.layouts.base', [
    'title' => 'Reschedule Confirmed',
    'heading' => 'Reschedule Confirmed',
])
<h2>Hello {{ $recipient->name }},</h2>

<p>The rescheduled appointment has been confirmed.</p>

<div class="info-box">
    <p><strong>{{ $isStudent ? 'Counselor' : 'Student' }}:</strong> {{ $otherParty->name }}</p>
    <p><strong>Date:</strong> {{ $appointment->scheduled_at->format('F d, Y') }}</p>
    <p><strong>Time:</strong> {{ $appointment->scheduled_at->format('g:i A') }}</p>
    <p><strong>Type:</strong> {{ ucfirst($appointment->type) }}</p>
    <p><strong>Reference Number:</strong> {{ $appointment->reference_number }}</p>
</div>

<p>Please update your calendar with the new appointment time.</p>

<div class="button-center">
    <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">
        View Appointment Details
    </a>
</div>
@endcomponent