<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved</title>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            color: #10b981;
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
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
        .success-badge {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .success-badge h3 {
            color: #065f46;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .success-badge p {
            color: #047857;
            margin: 5px 0;
            font-size: 14px;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 30px 0;
        }
        .feature {
            flex: 1;
            min-width: 45%;
            padding: 15px;
            background-color: #f0fdf4;
            border-radius: 8px;
            text-align: center;
        }
        .feature-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .feature h4 {
            color: #065f46;
            font-size: 16px;
            margin: 10px 0;
        }
        .feature p {
            font-size: 13px;
            color: #047857;
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
            <h2>🎉 Congratulations, {{ $user->name }}!</h2>
            
            <div class="success-badge">
                <h3>✅ Your {{ $accountType }} Account Has Been Approved!</h3>
                <p>You now have full access to all {{ $accountType }} features on B-Family Homes.</p>
            </div>
            
            <p>Great news! Your account has been reviewed and approved by our admin team. You can now login and start using your {{ $accountType }} account.</p>
            
            @if($accountType === 'Agent')
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🏘️</div>
                    <h4>List Properties</h4>
                    <p>Add and manage property listings</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">📅</div>
                    <h4>Manage Bookings</h4>
                    <p>Handle property inspections</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">💰</div>
                    <h4>Track Sales</h4>
                    <p>Monitor your transactions</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">📊</div>
                    <h4>Analytics</h4>
                    <p>View performance insights</p>
                </div>
            </div>
            @elseif($accountType === 'Investor')
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">💼</div>
                    <h4>Browse Investments</h4>
                    <p>Explore investment opportunities</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">💎</div>
                    <h4>Make Investments</h4>
                    <p>Invest in properties</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">📈</div>
                    <h4>Track Returns</h4>
                    <p>Monitor your investments</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">🎯</div>
                    <h4>Portfolio</h4>
                    <p>Manage your portfolio</p>
                </div>
            </div>
            @endif
            
            <div class="button-container">
                <a href="{{ route('login') }}" class="button">Login to Your Account</a>
            </div>
            
            <div class="divider"></div>
            
            <p style="font-size: 14px; color: #777777; text-align: center;">
                If you have any questions or need assistance, feel free to contact our support team.
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

