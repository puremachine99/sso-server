<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="color-scheme" content="light dark">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password Akun SmartID</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: #f6f8fb;
            color: #111;
        }

        a {
            color: #0B57D0;
        }

        .wrapper {
            width: 100%;
            padding: 24px;
            background: #f6f8fb;
        }

        .container {
            max-width: 560px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            padding: 24px;
        }

        .logo {
            text-align: center;
            margin-bottom: 16px;
        }

        .logo img {
            max-height: 36px;
        }

        h1 {
            font-size: 20px;
            margin: 16px 0;
        }

        p {
            line-height: 1.6;
            margin: 12px 0;
        }

        .btn-wrap {
            text-align: center;
            margin: 24px 0;
        }

        .btn {
            background: #0B57D0;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .meta {
            font-size: 12px;
            color: #666;
            margin-top: 24px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 24px;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background: #0b0f14;
                color: #e6e6e6;
            }

            .container {
                background: #11161c;
            }

            .meta,
            .footer {
                color: #aaa;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="logo">
                    <img src="{{ asset('images/artboard-2.png') }}" alt="SmartID" style="max-height:36px;">
            </div>

            <h1><strong>Permintaan Reset Password Akun SmartID</strong></h1>

            <p>Halo{{ isset($userName) && $userName ? ' ' . $userName : '' }},</p>
            <p>Kami menerima permintaan untuk mengatur ulang password akun SmartID Anda.</p>
            <p>Jika benar Anda yang meminta, silakan klik tombol di bawah untuk membuat kata sandi baru:</p>

            <div class="btn-wrap" style="text-align:center; margin:24px 0;">
                <a href="{{ $resetUrl }}" target="_blank" rel="noopener"
                    style="background:#0B57D0; 
              color:#ffffff !important; 
              text-decoration:none; 
              display:inline-block; 
              padding:12px 20px; 
              border-radius:8px; 
              font-weight:600; 
              font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif; 
              font-size:14px; 
              line-height:20px;">
                    Reset Password
                </a>
            </div>


            <p><strong>Keamanan:</strong> Link ini berlaku selama <strong>{{ $expiryMinutes ?? 60 }} menit</strong> dan
                hanya bisa <strong>digunakan sekali.</strong></p>
            <p>Jika Anda tidak merasa meminta reset password, silakan segera hubungi <a
                    href="mailto:ai.it@smartid.co.id">ai.it@smartid.co.id</a>.</p>

            <div class="meta">
                Link langsung: <a href="{{ $resetUrl }}" target="_blank" rel="noopener">{{ $resetUrl }}</a>
            </div>

            <div class="footer">
                © 2025 SmartID
            </div>
        </div>
    </div>
</body>

</html>
