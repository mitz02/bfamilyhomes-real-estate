<!DOCTYPE html>
<html lang="en">
@php
    $colors = [
        'payment_received' => ['#10b981', '#059669', '#d1fae5'],
        'payment_initiated' => ['#0d9488', '#0f766e', '#ccfbf1'],
        'withdrawal_requested' => ['#f5576c', '#dc2626', '#fee2e2'],
        'investment_initiated' => ['#3b82f6', '#2563eb', '#dbeafe'],
        'registration' => ['#6366f1', '#4f46e5', '#e0e7ff'],
        'upgrade_request' => ['#f59e0b', '#d97706', '#fef3c7'],
        'property_submitted' => ['#8b5cf6', '#7c3aed', '#ede9fe'],
        'inspection_booked' => ['#0ea5e9', '#0284c7', '#e0f2fe'],
        'new_contact_message' => ['#06b6d4', '#0891b2', '#cffafe'],
        'new_inquiry' => ['#14b8a6', '#0d9488', '#ccfbf1'],
    ];
    $palette = $colors[$type] ?? ['#6366f1', '#4f46e5', '#e0e7ff'];
    $headerFrom = $palette[0];
    $headerTo = $palette[1];
    $lightColor = $palette[2];
    $baseColor = $palette[0];
    $badgeText = str_replace('_', ' ', $type);
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
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
            background: linear-gradient(135deg, {{ $headerFrom }} 0%, {{ $headerTo }} 100%);
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
            font-size: 22px;
            margin-top: 0;
        }
        .content p {
            line-height: 1.6;
            font-size: 16px;
            color: #555555;
        }
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #ffffff;
            margin-bottom: 20px;
        }
        .alert-box {
            background-color: {{ $lightColor }};
            border-left: 4px solid {{ $baseColor }};
            padding: 18px 20px;
            margin: 20px 0;
            border-radius: 6px;
        }
        .alert-box p {
            margin: 0;
            font-size: 15px;
            color: #444444;
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
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, {{ $headerFrom }} 0%, {{ $headerTo }} 100%);
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
            <p>Admin Alert</p>
        </div>

        <div class="content">
            <span class="badge" style="background: {{ $baseColor }};">{{ $badgeText }}</span>

            <h2 style="color: {{ $baseColor }};">{{ $title }}</h2>

            <div class="alert-box">
                <p>{!! $body !!}</p>
            </div>

            @if (!empty($details))
                <table class="details-table" cellpadding="0" cellspacing="0">
                    @foreach ($details as $label => $value)
                        <tr>
                            <td>{{ $label }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif

            @if ($actionUrl)
                <div class="button-container">
                    <a href="{{ $actionUrl }}" class="button">{{ $actionText ?? 'View in Dashboard' }}</a>
                </div>
            @endif
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
