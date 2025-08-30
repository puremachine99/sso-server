<?php

if (!function_exists('imgproxy')) {
    /**
     * Generate an ImgProxy URL (signed if key/salt exist, else plain).
     *
     * @param  string       $path       Path lokal (misal 'images/bg.gif')
     * @param  string|null  $transform  Resize/crop option (ex: '300x200,sc')
     * @return string
     */
    function imgproxy(string $path, ?string $transform = '100x200,sc'): string
    {
        $baseUrl = rtrim(config('services.imgproxy.url'), '/');
        $key     = config('services.imgproxy.key');
        $salt    = config('services.imgproxy.salt');

        // Buat full URL dari asset
        $origin = asset($path);

        // Encode biar https:// gak bikin path rusak
        $origin = rawurlencode($origin);

        $urlPart = "/{$transform}/plain/{$origin}";

        // Signed mode (kalau key & salt tersedia)
        if (!empty($key) && !empty($salt)) {
            $key  = base64_decode($key);
            $salt = base64_decode($salt);

            $signature = hash_hmac('sha256', $salt . $urlPart, $key, true);
            $signature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

            return "{$baseUrl}/{$signature}{$urlPart}";
        }

        // Fallback unsigned mode
        return "{$baseUrl}{$urlPart}";
    }
}
