Reset password akun SmartID Portal

Halo{{ isset($userName) && $userName ? ' '.$userName : '' }},

Kami menerima permintaan untuk mereset password akun kamu.
Buka link berikut untuk membuat password baru (berlaku {{ $expiryMinutes ?? 60 }} menit):

{{ $resetUrl }}

Jika kamu tidak meminta reset password, abaikan email ini.
Bantuan: support@smartid.or.id

© {{ date('Y') }} SmartID Portal - https://devportal.smartid.or.id
