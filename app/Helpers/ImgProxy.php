<?php

if (!function_exists('imgproxy')) {
    function imgproxy(string $path, ?string $transform = '100x200,sc'): string
    {
        $baseProxy = config('services.imgproxy.url'); // dari config
        $baseAsset = config('app.url'); // misal https://devportal.smartid.or.id

        // Pastikan path jadi full url (pakai asset())
        $origin = asset($path);

        return rtrim($baseProxy, '/') . '/' . $transform . '/plain/' . $origin;
    }
}


// if (!function_exists('imgproxy')) {
//     /**
//      * Generate an ImgProxy URL (signed if key/salt exist, else plain).
//      *
//      * @param  string  $path
//      * @param  string|null  $transform
//      * @return string
//      */
//     function imgproxy(string $path, ?string $transform = '100x200,sc'): string
//     {
//         $baseUrl = rtrim(config('services.imgproxy.url'), '/');
//         $key     = config('services.imgproxy.key');
//         $salt    = config('services.imgproxy.salt');

//         $origin  = asset($path);
//         $urlPart = "/{$transform}/plain/{$origin}";

//         // Kalau key & salt ada → pakai signed URL
//         if (!empty($key) && !empty($salt)) {
//             $key  = base64_decode($key);
//             $salt = base64_decode($salt);

//             $signature = hash_hmac('sha256', $salt . $urlPart, $key, true);
//             $signature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

//             return "{$baseUrl}/{$signature}{$urlPart}";
//         }

//         // Kalau gak ada key/salt → fallback unsigned
//         return "{$baseUrl}/{$urlPart}";
//     }
// }
