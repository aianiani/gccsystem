@component('emails.layouts.base', [
    'title' => 'Appointment Rescheduled',
    'heading' => 'Appointment Rescheduled',
])
<h2>Hello {{ $recipient->name }},</h2>

<p>An appointment has been rescheduled. Please review the new details below.</p>

<div class="info-box">
    <p><strong>Previous Date:</strong> {{ $originalDate->format('F d, Y') }}</p>
    <p><strong>Previous Time:</strong> {{ $originalDate->format('g:i A') }}</p>
    <div class="divider"></div>
    <p><strong>New Date:</strong> {{ $appointment->scheduled_at->format('F d, Y') }}</p>
    <p><strong>New Time:</strong> {{ $appointment->scheduled_at->format('g:i A') }}</p>
    @if($rescheduleReason)
        <div class="divider"></div>
        <p><strong>Reason:</strong> {{ $rescheduleReason }}</p>
    @endif
</div>

@if($requiresConfirmation)
    <p>Please confirm if you can attend at the new time.</p>

    <div class="button-center">
        <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">
            Confirm Appointment
        </a>
    </div>
@else
    <p>This reschedule has been confirmed.</p>

    <div class="button-center">
        <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">
            View Appointment Details
        </a>
    </div>
@endif
@endcomponent