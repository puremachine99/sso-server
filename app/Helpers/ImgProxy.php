<?php
if (!function_exists('imgproxy')) {
    /**
     * Generate imgproxy URL from local asset.
     *
     * @param  string  $path
     * @param  string|null  $transform
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
