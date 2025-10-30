<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
        }
        .header {
            background: #2196f3;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .credentials {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: #2196f3;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Our Service Platform!</h1>
        </div>
        
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            
            <p>Your account has been created successfully. Here are your login credentials:</p>
            
            <div class="credentials">
                <h3>Your Login Credentials:</h3>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Temporary Password:</strong> <code style="font-size: 18px; background: #f4f4f4; padding: 5px 10px; border-radius: 4px;">{{ $tempPassword }}</code></p>
            </div>

            <div class="warning">
                <strong>Important Security Notice:</strong>
                <p>For security reasons, please change your password immediately after logging in for the first time.</p>
            </div>

            <p>To activate your account and ensure the security of your information, please verify your email address by clicking the button below:</p>
            
            <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
            
            <p>If the button above doesn't work, copy and paste this link into your browser:</p>
            <p><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>
            
            <p><strong>What happens next?</strong></p>
            <ol>
                <li>Click the verification link above</li>
                <li>Login with your credentials</li>
                <li>Change your temporary password</li>
                <li>Start using your account!</li>
            </ol>
            
            <p>If you did not create an account, no further action is required.</p>
            
            <p>Best regards,<br>
            The Support Team</p>
        </div>
    </div>
</body>
</html>