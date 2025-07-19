<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c59 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .success-icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background: #2d5016;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Registration Approved!</h1>
        <p>CMU Guidance and Counseling Center</p>
    </div>
    
    <div class="content">
        <div style="text-align: center;">
            <div class="success-icon">✅</div>
        </div>
        
        <h2>Hello {{ $user->name }},</h2>
        
        <p>Great news! Your registration for the CMU Guidance and Counseling Center has been <strong>approved</strong> by our administration team.</p>
        
        <p>Your account is now active and you can access all the features of our counseling platform, including:</p>
        
        <ul>
            <li>📅 Schedule appointments with counselors</li>
            <li>📝 Take mental health assessments</li>
            <li>💬 Chat with counselors</li>
            <li>📋 View your session notes and progress</li>
        </ul>
        
        <p><strong>Next Steps:</strong></p>
        <ol>
            <li>Log in to your account using your email and password</li>
            <li>Complete your profile information</li>
            <li>Browse available counselors and schedule your first appointment</li>
        </ol>
        
        <div style="text-align: center;">
            <a href="{{ route('login') }}" class="btn">Login to Your Account</a>
        </div>
        
        <p style="margin-top: 30px;">
            <strong>Important:</strong> If you have any questions or need assistance, please don't hesitate to contact our support team.
        </p>
        
        <p>Welcome to the CMU Guidance and Counseling Center family! We're here to support your mental health and well-being journey.</p>
        
        <p>Best regards,<br>
        <strong>CMU Guidance and Counseling Center Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} CMU Guidance and Counseling Center. All rights reserved.</p>
    </div>
</body>
</html> 