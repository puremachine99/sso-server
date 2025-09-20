<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="color-scheme" content="light dark">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>
  <style>
    body { margin:0; padding:0; font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif; background:#f6f8fb; color:#111; }
    a { color:#0B57D0; }
    .wrapper { width:100%; padding:24px; background:#f6f8fb; }
    .container { max-width:560px; margin:0 auto; background:#fff; border-radius:12px; padding:24px; }
    .logo { text-align:center; margin-bottom:16px; }
    .logo img { max-height:36px; }
    h1 { font-size:20px; margin:16px 0; }
    p { line-height:1.6; margin:12px 0; }
    .btn-wrap { text-align:center; margin:24px 0; }
    .btn { background:#0B57D0; color:#fff; text-decoration:none; display:inline-block; padding:12px 20px; border-radius:8px; font-weight:600; }
    .meta { font-size:12px; color:#666; margin-top:24px; }
    .footer { text-align:center; font-size:12px; color:#888; margin-top:24px; }
    @media (prefers-color-scheme: dark) {
      body { background:#0b0f14; color:#e6e6e6; }
      .container { background:#11161c; }
      .meta, .footer { color:#aaa; }
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="container">
      <div class="logo">
        {{-- Ganti URL logo ini --}}
        <img src="https://devportal.smartid.or.id/assets/logo-smartid.png" alt="SmartID Portal" onerror="this.style.display='none'">
      </div>

      <h1>Reset password akun SmartID Portal</h1>

      <p>Halo{{ isset($userName) && $userName ? ' '.$userName : '' }},</p>
      <p>Kami menerima permintaan untuk mereset password akun kamu. Klik tombol di bawah untuk membuat password baru.</p>

      <div class="btn-wrap">
        <a class="btn" href="{{ $resetUrl }}" target="_blank" rel="noopener">Reset password</a>
      </div>

      <p><strong>Keamanan:</strong> Link ini berlaku selama {{ $expiryMinutes ?? 60 }} menit dan hanya bisa digunakan sekali.</p>
      <p>Kalau kamu tidak meminta reset password, abaikan email ini—akunmu tetap aman.</p>

      <div class="meta">
        Link langsung: <a href="{{ $resetUrl }}" target="_blank" rel="noopener">{{ $resetUrl }}</a><br>
        Butuh bantuan? Hubungi: <a href="mailto:support@smartid.or.id">support@smartid.or.id</a>
      </div>

      <div class="footer">
        © {{ date('Y') }} SmartID Portal · <a href="https://devportal.smartid.or.id" target="_blank" rel="noopener">devportal.smartid.or.id</a>
      </div>
    </div>
  </div>
</body>
</html>
