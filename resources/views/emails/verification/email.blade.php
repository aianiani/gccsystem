@php
    $title = 'Verify Your Email Address';
@endphp

@component('emails.layouts.base', [
    'title' => $title,
    'heading' => 'Verify Your Email Address',
    'preheader' => 'CMU Guidance & Counseling Center',
    'intro' => 'Help us keep your account secure by confirming your email address.',
])
    <p style="margin-top: 0; margin-bottom: 16px;">
        Hello <strong>{{ $userName }}</strong>,
    </p>

    <p style="margin-bottom: 16px;">
        Thank you for registering with our CMU Guidance & Counseling Center platform. To complete your registration and activate your account, please verify your email address by clicking the button below:
    </p>

    <p style="text-align: center; margin: 20px 0;">
        <a href="{{ $verificationUrl }}" class="button-primary">
            Verify Email Address
        </a>
    </p>

    <p style="margin-bottom: 12px;">
        If the button above doesn’t work, you can copy and paste this link into your browser:
    </p>
    <p style="word-break: break-all; color: #2d5016; font-size: 13px; margin-bottom: 18px;">
        {{ $verificationUrl }}
    </p>

    <div style="background-color: #fef9e7; border-radius: 10px; padding: 14px 16px; border: 1px solid #f4d03f; margin-bottom: 18px; font-size: 13px; color: #92400e;">
        <strong>Important:</strong>
        This verification link will expire in 60 minutes. If you don’t verify your email within this time, you’ll need to request a new verification email.
    </div>

    <p style="margin-bottom: 0;">
        If you did not create an account with us, you can safely ignore this email.
    </p>
@endcomponent
