<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding: 20px 0;
        }
        .email-header h1 {
            margin: 0;
            color: #333333;
        }
        .email-body {
            padding: 20px;
            color: #555555;
        }
        .email-body p {
            line-height: 1.6;
        }
        .reset-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .reset-button:hover {
            background-color: #218838;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="email-body">
            <p>Hello,</p>
            <p>We received a request to reset your password. Click the button below to reset it:</p>
            <a href="{{ $details['reset_link'] }}" class="reset-button">Reset Password</a>
            <p>If you did not request a password reset, please ignore this email or reply to let us know.</p>
            <p>Thank you,<br>The {{ config('app.name') }} Team</p>
        </div>
        <div class="email-footer">
            <p>If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
            <p><a href="{{ $details['reset_link'] }}">{{ $details['reset_link'] }}</a></p>
        </div>
    </div>
</body>
</html>
