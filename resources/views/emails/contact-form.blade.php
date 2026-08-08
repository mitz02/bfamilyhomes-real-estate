<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }
        .logo-container {
            margin-bottom: 15px;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
        }
        .header p {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
        }
        .content h2 {
            color: #0891b2;
            font-size: 22px;
            margin-top: 0;
        }
        .content p {
            line-height: 1.6;
            font-size: 16px;
            color: #555555;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background: #fafafa;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            overflow: hidden;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .details-table td {
            padding: 12px 16px;
            font-size: 14px;
            border-bottom: 1px solid #eeeeee;
        }
        .details-table td:first-child {
            width: 40%;
            font-weight: 600;
            color: #777777;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .details-table td:last-child {
            color: #333333;
            font-weight: 500;
            word-break: break-word;
        }
        .message-box {
            background-color: #cffafe;
            border-left: 4px solid #06b6d4;
            padding: 18px 20px;
            margin: 20px 0;
            border-radius: 6px;
            font-size: 15px;
            color: #444444;
            line-height: 1.6;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="B-Family Homes Logo" class="logo">
            </div>
            <h1>B-Family Homes</h1>
            <p>New Contact Message</p>
        </div>

        <div class="content">
            <h2>Someone contacted you via the website contact form</h2>

            <table class="details-table" cellpadding="0" cellspacing="0">
                <tr>
                    <td>Name</td>
                    <td>{{ $data['name'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $data['email'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>{{ $data['phone'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td>{{ $data['subject'] ?? 'General Inquiry' }}</td>
                </tr>
                <tr>
                    <td>Sent At</td>
                    <td>{{ now()->format('M d, Y h:i A') }}</td>
                </tr>
            </table>

            <p style="font-weight: 600; color: #333333;">Message:</p>
            <div class="message-box">
                {{ $data['message'] ?? 'N/A' }}
            </div>

            <div class="button-container">
                <a href="{{ route('admin.inquiries') }}" class="button">View Inquiries</a>
            </div>
        </div>

        <div class="footer">
            <p><strong>B-Family Homes</strong></p>
            <p>Your trusted partner in finding the perfect home</p>
            <p style="margin-top: 15px; color: #999999; font-size: 12px;">
                This is an automated notification sent to the B-Family Homes admin team. Please do not reply to this email.
            </p>
            <p style="color: #999999; font-size: 12px;">
                &copy; {{ date('Y') }} B-Family Homes. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
