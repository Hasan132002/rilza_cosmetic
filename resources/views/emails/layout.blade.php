<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Rizla Cosmetics' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f9fafb;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 32px;
            font-weight: bold;
        }
        .logo {
            color: #ffffff;
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .content p {
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            background-color: #f3f4f6;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            background-color: #ec4899;
            color: #ffffff;
            border-radius: 50%;
            margin: 0 5px;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 30px 0;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">💄</div>
            <h1>Rizla Cosmetics</h1>
            <p style="color: #fce7f3; margin-top: 10px;">Premium Beauty & Cosmetics</p>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-links">
                <a href="#">f</a>
                <a href="#">📷</a>
                <a href="#">🐦</a>
            </div>

            <p><strong>Rizla Cosmetics</strong></p>
            <p>Premium Beauty Products | Trusted by Thousands</p>
            <p style="margin-top: 20px; font-size: 12px;">
                📧 info@rizla.com | 📞 +92 300 1234567<br>
                © {{ date('Y') }} Rizla Cosmetics. All rights reserved.
            </p>

            <div class="divider"></div>

            <p style="font-size: 12px; color: #9ca3af;">
                You're receiving this email because you have an account with Rizla Cosmetics.<br>
                <a href="#" style="color: #ec4899;">Unsubscribe</a> | <a href="#" style="color: #ec4899;">View in Browser</a>
            </p>
        </div>
    </div>
</body>
</html>
