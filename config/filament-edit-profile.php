<?php

return [
    'avatar_column' => 'avatar_url',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public',
    'password_rules' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/'],

    'show_custom_fields' => false,
];
