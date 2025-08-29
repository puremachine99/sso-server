<?php

return [
    'url' => env('IMGPROXY_URL', 'http://localhost:8080'),
    'key' => env('IMGPROXY_KEY', ''),
    'salt' => env('IMGPROXY_SALT', ''),
    'enabled' => env('IMGPROXY_ENABLED', true),
];