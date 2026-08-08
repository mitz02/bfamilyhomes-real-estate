<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to B-Family Homes</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
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
        .features {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            text-align: center;
        }
        .feature {
            flex: 1;
            padding: 15px;
        }
        .feature-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .feature h3 {
            color: #667eea;
            font-size: 18px;
            margin: 10px 0;
        }
        .feature p {
            font-size: 14px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes Logo" class="logo">
            </div>
            <h1>Welcome to B-Family Homes!</h1>
        </div>
        
        <div class="content">
            <h2>Your account is now active! 🎉</h2>
            
            <p>Hi {{ $user->name }},</p>
            
            <p>Congratulations! Your email has been verified and your account is now fully activated. You can now access all the features of <strong>B-Family Homes</strong>.</p>
            
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🔍</div>
                    <h3>Browse Properties</h3>
                    <p>Explore our extensive collection of properties</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">💼</div>
                    <h3>Investment Opportunities</h3>
                    <p>Discover lucrative real estate investments</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">🤝</div>
                    <h3>Expert Support</h3>
                    <p>Get assistance from our professional agents</p>
                </div>
            </div>
            
            <div class="button-container">
                <a href="{{ route('home') }}" class="button">Start Exploring</a>
            </div>
            
            <p style="margin-top: 30px;">If you have any questions or need assistance, feel free to contact our support team at any time.</p>
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

