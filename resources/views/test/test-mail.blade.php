<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appName }} - Email Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header {
            background: #0056D2;
            padding: 20px;
            text-align: center;
            color: #ffffff;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            color: #333333;
            line-height: 1.5;
        }
        .footer {
            background: #f0f0f0;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        .btn {
            display: inline-block;
            background: #0056D2;
            color: white;
            padding: 10px 20px;
            margin-top: 15px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .preview-text {
            display: none;
            max-height: 0;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <span class="preview-text">{{ $previewText }}</span>
    <div class="email-wrapper">
        <div class="header">{{ $appName }}</div>
        <div class="content">
            <p>Halo,</p>
            <p>{{ $bodyMessage }}</p>
            <p>Email ini hanya untuk pengujian, tidak perlu melakukan tindakan apapun.</p>
            <a href="{{ config('app.url') }}" class="btn">Kunjungi Portal</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $appName }}. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>
