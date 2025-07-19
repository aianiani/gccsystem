<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Status Update</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .info-icon {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .reason-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
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
        <h1>📋 Registration Status Update</h1>
        <p>CMU Guidance and Counseling Center</p>
    </div>
    
    <div class="content">
        <div style="text-align: center;">
            <div class="info-icon">ℹ️</div>
        </div>
        
        <h2>Hello {{ $user->name }},</h2>
        
        <p>Thank you for your interest in the CMU Guidance and Counseling Center. We have reviewed your registration application and unfortunately, we are unable to approve your registration at this time.</p>
        
        <div class="reason-box">
            <h4>Reason for Rejection:</h4>
            <p>{{ $rejectionReason }}</p>
        </div>
        
        <p><strong>What happens next?</strong></p>
        <ul>
            <li>Your registration has been marked as rejected in our system</li>
            <li>You will not be able to access the counseling platform</li>
            <li>If you believe this decision was made in error, you may contact our support team</li>
        </ul>
        
        <p><strong>If you would like to reapply:</strong></p>
        <ol>
            <li>Please address the reason for rejection mentioned above</li>
            <li>Contact our support team for guidance</li>
            <li>Submit a new registration application</li>
        </ol>
        
        <p style="margin-top: 30px;">
            <strong>Contact Information:</strong><br>
            If you have any questions about this decision or need assistance, please contact our support team.
        </p>
        
        <p>We appreciate your understanding and hope to serve you in the future.</p>
        
        <p>Best regards,<br>
        <strong>CMU Guidance and Counseling Center Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} CMU Guidance and Counseling Center. All rights reserved.</p>
    </div>
</body>
</html> 