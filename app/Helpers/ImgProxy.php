<?php

if (!function_exists('imgproxy')) {
    function imgproxy(string $path): string {
        $baseProxy = rtrim(config('imgproxy.url'), '/');
        $baseAsset = rtrim(config('imgproxy.base_asset_url'), '/');
        $keyHex    = config('imgproxy.key');
        $saltHex   = config('imgproxy.salt');

        // Build origin URL (full)
        $isAbsolute = str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
        $origin = $isAbsolute ? $path : ($baseAsset . '/' . ltrim($path, '/'));

        // Ambil default transform dari config
        $resize    = config('imgproxy.resize');
        $width     = config('imgproxy.width');
        $height    = config('imgproxy.height');
        $enlarge   = config('imgproxy.enlarge');
        $gravity   = config('imgproxy.gravity');
        $extension = config('imgproxy.extension');

        // Encode origin → urlsafe base64
        $encoded = rtrim(strtr(base64_encode($origin), '+/', '-_'), '=');

        // Path unsigned
        $unsignedPath = "/rs:{$resize}:{$width}:{$height}:{$enlarge}/g:{$gravity}/{$encoded}.{$extension}";

        // Kalau key/salt kosong → insecure
        $key  = @hex2bin($keyHex);
        $salt = @hex2bin($saltHex);
        if (!$key || !$salt) {
            return $baseProxy . '/insecure' . $unsignedPath;
        }

        // Signature
        $digest = hash_hmac('sha256', $salt . $unsignedPath, $key, true);
        $signature = rtrim(strtr(base64_encode($digest), '+/', '-_'), '=');

        return $baseProxy . '/' . $signature . $unsignedPath;
    }
}
