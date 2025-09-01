<?php

return [
    // wejangan pakem
    'url'            => env('IMGPROXY_URL', 'https://imgproxy.smartid.co.id'),
    'base_asset_url' => env('IMGPROXY_BASE_ASSET_URL', env('APP_URL')),
    'key'            => env('IMGPROXY_KEY'),
    'salt'           => env('IMGPROXY_SALT'),

    // setingan
    'resize'    => 'fit',
    'width'     => 0,
    'height'    => 750,
    'enlarge'   => 0,
    'gravity'   => 'no',
    'extension' => 'webp',


];
