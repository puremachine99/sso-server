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
        $baseProxy = config('services.imgproxy.url'); // dari config
        $baseAsset = config('app.url'); // misal https://devportal.smartid.or.id

        // Pastikan path jadi full url (pakai asset())
        $origin = asset($path);

        return rtrim($baseProxy, '/') . '/' . $transform . '/plain/' . $origin;
    }
}
