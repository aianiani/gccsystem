@component('emails.layouts.base', [
    'title' => 'Registration Status Update',
    'heading' => 'Registration Status Update',
])
    <h2>Hello {{ $user->name }},</h2>

    <p>Thank you for your interest in the CMU Guidance and Counseling Center. After reviewing your registration application, we're unable to approve your registration at this time.</p>

    <div class="info-box" style="background-color: #fff9e6; border-color: #ffd700;">
        <p style="margin: 0 0 5px 0;"><strong>Reason for Rejection:</strong></p>
        <p style="margin: 0;">{{ $rejectionReason }}</p>
    </div>

    <p><strong>What happens next?</strong></p>
    <ul>
        <li>Your registration has been marked as rejected in our system</li>
        <li>You will not be able to access the counseling platform at this time</li>
        <li>If you believe this decision was made in error, you may contact our support team</li>
    </ul>

    <p><strong>If you would like to reapply:</strong></p>
    <ol>
        <li>Carefully review the reason for rejection shared above</li>
        <li>Contact our support team if you need clarification or guidance</li>
        <li>Submit a new registration application once you are ready</li>
    </ol>

    <p style="font-size: 13px; color: #888;">
        If you have any questions about this decision or need assistance, please contact our support team.
    </p>
@endcomponent
