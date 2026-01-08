@component('emails.layouts.base', [
    'title' => 'Verify Your Email Address',
    'heading' => 'Verify Your Email Address',
])
    <h2>Hello {{ $userName }},</h2>

    <p>Thank you for registering with the CMU Guidance & Counseling Center. To complete your registration, please verify your email address by clicking the button below:</p>

    <div class="button-center">
        <a href="{{ $verificationUrl }}" class="button">
            Verify Email Address
        </a>
    </div>

    <p style="font-size: 13px; color: #888;">
        If the button doesn't work, copy and paste this link into your browser:
    </p>
    <p style="word-break: break-all; font-size: 13px; color: #228B22;">
        {{ $verificationUrl }}
    </p>

    <div class="info-box" style="background-color: #fff9e6; border-color: #ffd700;">
        <p style="margin: 0; font-size: 14px; color: #856404;">
            <strong>Important:</strong> This verification link will expire in 60 minutes.
        </p>
    </div>

    <p style="font-size: 13px; color: #888;">
        If you did not create an account, you can safely ignore this email.
    </p>
@endcomponent
