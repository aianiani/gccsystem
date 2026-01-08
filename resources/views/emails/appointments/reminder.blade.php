@component('emails.layouts.base', [
    'title' => 'Appointment Reminder',
    'heading' => 'Upcoming Appointment Reminder',
])
<h2>Hello {{ $user->name }},</h2>

<p>This is a friendly reminder about your upcoming counseling appointment.</p>

<div class="info-box">
    <p><strong>{{ $isStudent ? 'Counselor' : 'Student' }}:</strong> {{ $otherParty->name }}</p>
    <p><strong>Date:</strong> {{ $appointment->scheduled_at->format('F d, Y') }}</p>
    <p><strong>Time:</strong> {{ $appointment->scheduled_at->format('g:i A') }}</p>
    <p><strong>Type:</strong> {{ ucfirst($appointment->type) }}</p>
    <p><strong>Reference Number:</strong> {{ $appointment->reference_number }}</p>
</div>

@if($isStudent)
    <p><strong>Preparation tips:</strong></p>
    <ul>
        <li>Arrive on time for your appointment</li>
        <li>Bring any relevant documents or notes</li>
        <li>Prepare questions you'd like to discuss</li>
    </ul>
@endif

<div class="button-center">
    <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">
        View Appointment Details
    </a>
</div>

<p style="font-size: 13px; color: #888;">
    If you need to reschedule or cancel, please do so as soon as possible.
</p>
@endcomponent