@component('emails.layouts.base', [
    'title' => 'Appointment Approved',
    'heading' => 'Appointment Approved',
])
<h2>Hello {{ $student->name }},</h2>

<p>Great news! Your appointment request has been approved by {{ $counselor->name }}.</p>

<div class="info-box">
    <p><strong>Counselor:</strong> {{ $counselor->name }}</p>
    <p><strong>Date:</strong> {{ $appointment->scheduled_at->format('F d, Y') }}</p>
    <p><strong>Time:</strong> {{ $appointment->scheduled_at->format('g:i A') }}</p>
    <p><strong>Type:</strong> {{ ucfirst($appointment->type) }}</p>
    <p><strong>Reference Number:</strong> {{ $appointment->reference_number }}</p>
</div>

<p><strong>What to expect:</strong></p>
<ul>
    <li>Please arrive on time for your appointment</li>
    <li>Bring any relevant documents or notes</li>
    <li>Feel free to prepare questions you'd like to discuss</li>
</ul>

<div class="button-center">
    <a href="{{ url('/appointments/' . $appointment->id) }}" class="button">
        View Appointment Details
    </a>
</div>

<p style="font-size: 13px; color: #888;">
    If you need to reschedule or cancel, please do so at least 24 hours in advance.
</p>
@endcomponent