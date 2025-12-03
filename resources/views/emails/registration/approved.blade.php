@php
    $title = 'Registration Approved';
@endphp

@component('emails.layouts.base', [
    'title' => $title,
    'heading' => 'Registration Approved 🎉',
    'preheader' => 'Your CMU GCC account is now active',
    'intro' => 'You can now access the CMU Guidance & Counseling Center online services.',
])
    <div style="text-align: center; margin-bottom: 20px;">
        <div style="font-size: 44px; color: #28a745; margin-bottom: 6px;">✅</div>
    </div>

    <h2 style="margin-top: 0; margin-bottom: 12px; font-size: 20px; color: #1f2933;">
        Hello {{ $user->name }},
    </h2>

    <p style="margin-bottom: 14px;">
        Great news! Your registration for the <strong>CMU Guidance and Counseling Center</strong> has been
        <strong>approved</strong> by our administration team.
    </p>

    <p style="margin-bottom: 14px;">
        Your account is now active and you can access all the features of our counseling platform, including:
    </p>

    <ul style="padding-left: 18px; margin-top: 0; margin-bottom: 14px;">
        <li>📅 Schedule appointments with counselors</li>
        <li>📝 Take mental health assessments</li>
        <li>💬 Chat with counselors</li>
        <li>📋 View your session notes and track your progress</li>
    </ul>

    <p style="margin-top: 6px; margin-bottom: 10px;"><strong>Next steps:</strong></p>
    <ol style="padding-left: 18px; margin-top: 0; margin-bottom: 18px;">
        <li>Log in to your account using your registered email and password</li>
        <li>Complete your profile information</li>
        <li>Browse available counselors and schedule your first appointment</li>
    </ol>

    <p style="text-align: center; margin: 20px 0;">
        <a href="{{ route('login') }}" class="button-primary">
            Login to Your Account
        </a>
    </p>

    <p style="margin-top: 20px; margin-bottom: 12px; font-size: 13px;">
        <strong>Need help?</strong> If you have any questions or need assistance, please don’t hesitate to contact our support team.
    </p>

    <p style="margin-bottom: 0;">
        Welcome to the CMU Guidance and Counseling Center family. We’re here to support your mental health and well‑being journey.
    </p>

    <p style="margin-top: 18px; margin-bottom: 0;">
        Best regards,<br>
        <strong>CMU Guidance & Counseling Center Team</strong>
    </p>
@endcomponent
