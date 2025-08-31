<?php

if (!function_exists('imgproxy')) {
    /**
     * Generate signed imgproxy URL (encoded-url mode + extension suffix).
     *
     * @param string      $path       Relative path (e.g. 'images/bg-login.jpg') atau absolute URL.
     * @param string      $transform  e.g. 'rs:fit:::0'
     * @param string|null $extension  e.g. 'jpg'. Kalau null, diambil dari $path (fallback 'jpg').
     * @param string      $gravity    e.g. 'no', 'ce', dll.
     */
    function imgproxy(
        string $path,
        string $transform = 'rs:fit:::0',
        ?string $extension = null,
        string $gravity = 'no'
    ): string {
        $baseProxy = rtrim(config('imgproxy.url'), '/');
        $baseAsset = rtrim((string) config('imgproxy.base_asset_url'), '/');

        $keyHex  = (string) config('imgproxy.key');
        $saltHex = (string) config('imgproxy.salt');

        // Tentukan origin: kalau $path sudah absolute URL, pakai as-is. Kalau tidak, prefix pakai base_asset_url.
        $isAbsolute = str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
        $origin = $isAbsolute ? $path : ($baseAsset . '/' . ltrim($path, '/'));

        // Tentukan extension: kalau null, ambil dari $path; fallback 'jpg'
        if ($extension === null) {
            $guessed = pathinfo(parse_url($origin, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION);
            $extension = $guessed !== '' ? strtolower($guessed) : 'jpg';
        }

        // URL-safe base64 tanpa padding, dari FULL origin URL
        $encoded = rtrim(strtr(base64_encode($origin), '+/', '-_'), '=');

        // Bangun unsigned path (encoded-url mode)
        // Format: /<transform>/g:<gravity>/<encoded>.<ext>
        $unsignedPath = '/' . trim($transform, '/') . '/g:' . $gravity . '/' . $encoded . '.' . $extension;

        // Kalau key/salt kosong atau hex2bin gagal → insecure
        $key  = @hex2bin($keyHex);
        $salt = @hex2bin($saltHex);
        if (!$key || !$salt) {
            // minimal tetap balikin URL yang bisa dicoba
            return $baseProxy . '/insecure' . $unsignedPath;
        }

        // Signature = base64url( HMAC_SHA256( key, salt + unsignedPath ) )
        $digest = hash_hmac('sha256', $salt . $unsignedPath, $key, true);
        $signature = rtrim(strtr(base64_encode($digest), '+/', '-_'), '=');

        return $baseProxy . '/' . $signature . $unsignedPath;
    }
}
