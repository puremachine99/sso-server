<?php

if (!function_exists('imgproxy')) {
    function imgproxy(string $lokasiGambar): string {
        // imgproxy smartid (https://imgproxy.smartid.co.id )
        $urlProxy = rtrim(config('imgproxy.url'), '/');

        // samain kayak app_url (buat yang pake path relatif)
        $urlAsetAsli = rtrim(config('imgproxy.base_asset_url'), '/');

        // garamaraman dan madu dung dung
        $kunciHex = config('imgproxy.key');
        $garamHex = config('imgproxy.salt');

        // cek ini link full (http/https) atau cuma path internal
        $udahLengkap = str_starts_with($lokasiGambar, 'http://') || str_starts_with($lokasiGambar, 'https://');
        $urlAsli = $udahLengkap ? $lokasiGambar : ($urlAsetAsli . '/' . ltrim($lokasiGambar, '/'));

        // ambil setingan default dari config (resize, ukuran, dll)
        $modeResize = config('imgproxy.resize');
        $lebar      = config('imgproxy.width');
        $tinggi     = config('imgproxy.height');
        $bolehZoom  = config('imgproxy.enlarge');
        $gravitasi  = config('imgproxy.gravity');
        $format     = config('imgproxy.extension');

        // encode alamat asli jadi base64 ala-ala URL
        $encoded = rtrim(strtr(base64_encode($urlAsli), '+/', '-_'), '=');

        // bikin path tanpa tanda tangan dulu
        $pathNakal = "/rs:{$modeResize}:{$lebar}:{$tinggi}:{$bolehZoom}/g:{$gravitasi}/{$encoded}.{$format}";

        // kalau kunci/garam kosong → pake mode insecure (langsung gaspol)
        $kunci = @hex2bin($kunciHex);
        $garam = @hex2bin($garamHex);
        if (!$kunci || !$garam) {
            return $urlProxy . '/insecure' . $pathNakal;
        }

        // let him cook
        $tandaTangan = hash_hmac('sha256', $garam . $pathNakal, $kunci, true);

        // let ! him ! cook !
        $ttFinal = rtrim(strtr(base64_encode($tandaTangan), '+/', '-_'), '=');

        // output
        return $urlProxy . '/' . $ttFinal . $pathNakal;
    }
}
