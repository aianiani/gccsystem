@php
    $title = 'Registration Status Update';
@endphp

@component('emails.layouts.base', [
    'title' => $title,
    'heading' => 'Registration Status Update',
    'preheader' => 'Your registration could not be approved',
    'intro' => 'We appreciate your interest in the CMU Guidance & Counseling Center.',
])
    <div style="text-align: center; margin-bottom: 20px;">
        <div style="font-size: 44px; color: #dc3545; margin-bottom: 6px;">ℹ️</div>
    </div>

    <h2 style="margin-top: 0; margin-bottom: 12px; font-size: 20px; color: #1f2933;">
        Hello {{ $user->name }},
    </h2>

    <p style="margin-bottom: 14px;">
        Thank you for your interest in the <strong>CMU Guidance and Counseling Center</strong>.
        After reviewing your registration application, we’re unable to approve your registration at this time.
    </p>

    <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 10px; padding: 14px 16px; margin: 18px 0;">
        <h4 style="margin: 0 0 6px 0; font-size: 15px;">Reason for Rejection</h4>
        <p style="margin: 0;">{{ $rejectionReason }}</p>
    </div>

    <p style="margin-bottom: 10px;"><strong>What happens next?</strong></p>
    <ul style="padding-left: 18px; margin-top: 0; margin-bottom: 14px;">
        <li>Your registration has been marked as rejected in our system</li>
        <li>You will not be able to access the counseling platform at this time</li>
        <li>If you believe this decision was made in error, you may contact our support team</li>
    </ul>

    <p style="margin-bottom: 10px;"><strong>If you would like to reapply:</strong></p>
    <ol style="padding-left: 18px; margin-top: 0; margin-bottom: 18px;">
        <li>Carefully review the reason for rejection shared above</li>
        <li>Contact our support team if you need clarification or guidance</li>
        <li>Submit a new registration application once you are ready</li>
    </ol>

    <p style="margin-top: 18px; margin-bottom: 12px; font-size: 13px;">
        <strong>Contact information:</strong><br>
        If you have any questions about this decision or need assistance, please contact our support team.
    </p>

    <p style="margin-bottom: 0;">
        We appreciate your understanding and hope to be able to serve you in the future.
    </p>

    <p style="margin-top: 18px; margin-bottom: 0;">
        Best regards,<br>
        <strong>CMU Guidance & Counseling Center Team</strong>
    </p>
@endcomponent
