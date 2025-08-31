<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('imgproxy')) {
    function imgproxy(
        string $path,
        string $transform = 'rs:fit:::0/g:no',
        string $extension = 'jpg',
        string $gravity = 'no'
    ): string {
        $baseProxy = rtrim(Config::get('imgproxy.url'), '/');
        $baseAsset = rtrim(Config::get('imgproxy.base_asset_url'), '/');

        $keyHex  = Config::get('imgproxy.key');
        $saltHex = Config::get('imgproxy.salt');

        // full origin url
        $origin = $baseAsset . '/' . ltrim($path, '/');

        // url-safe base64 encode (tanpa padding)
        $encoded = rtrim(strtr(base64_encode($origin), '+/', '-_'), '=');

        // build path sesuai pola JS
        $unsignedPath = '/' . $transform . '/g:' . $gravity . '/' . $encoded . '.' . $extension;

        if (empty($keyHex) || empty($saltHex)) {
            return $baseProxy . '/insecure' . $unsignedPath;
        }

        $key  = hex2bin($keyHex);
        $salt = hex2bin($saltHex);

        // sign
        $digest = hash_hmac('sha256', $salt . $unsignedPath, $key, true);
        $signature = rtrim(strtr(base64_encode($digest), '+/', '-_'), '=');

        return $baseProxy . '/' . $signature . $unsignedPath;
    }
}
