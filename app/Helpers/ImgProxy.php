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
        $baseProxy = config('services.imgproxy.url'); // contoh: https://imgproxy.smartid.co.id
        $baseAsset = config('services.imgproxy.base_asset_url'); // contoh: https://smartidapp.co.id

        // Pastikan path dimulai dengan /
        $path = '/' . ltrim($path, '/');

        // Jangan encode https://, langsung concat
        $origin = $baseAsset . $path;

        return rtrim($baseProxy, '/') . '/' . $transform . '/plain/' . $origin;
    }
}
