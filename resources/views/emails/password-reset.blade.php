<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
        }
        .content h2 {
            color: #f5576c;
            font-size: 24px;
            margin-top: 0;
        }
        .content p {
            line-height: 1.6;
            font-size: 16px;
            color: #555555;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 87, 108, 0.4);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #777777;
            font-size: 14px;
        }
        .footer p {
            margin: 5px 0;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e0e0e0, transparent);
            margin: 30px 0;
        }
        .note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #856404;
        }
        .security-note {
            background-color: #f8f9fa;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #555555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes Logo" class="logo">
            </div>
            <h1>B-Family Homes</h1>
        </div>
        
        <div class="content">
            <h2>Password Reset Request</h2>
            
            <p>Hi {{ $user->name }},</p>
            
            <p>We received a request to reset your password for your <strong>B-Family Homes</strong> account. Click the button below to create a new password:</p>
            
            <div class="button-container">
                <a href="{{ $resetUrl }}" class="button">Reset Password</a>
            </div>
            
            <div class="note">
                <strong>⏱️ Important:</strong> This password reset link will expire in <strong>60 minutes</strong> for security reasons.
            </div>
            
            <div class="security-note">
                <strong>🛡️ Security Note:</strong> If you didn't request a password reset, please ignore this email. Your password will remain unchanged and your account is secure.
            </div>
            
            <div class="divider"></div>
            
            <p style="font-size: 14px; color: #777777;">
                If the button doesn't work, copy and paste this link into your browser:<br>
                <a href="{{ $resetUrl }}" style="color: #f5576c; word-break: break-all;">{{ $resetUrl }}</a>
            </p>
        </div>
        
        <div class="footer">
            <p><strong>B-Family Homes</strong></p>
            <p>Your trusted partner in finding the perfect home</p>
            <p style="margin-top: 15px; color: #999999; font-size: 12px;">
                &copy; {{ date('Y') }} B-Family Homes. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

