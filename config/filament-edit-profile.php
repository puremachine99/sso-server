<?php

return [
    'avatar_column' => 'avatar_url',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public',

    'show_custom_fields' => true,

    'custom_fields' => [
        'display_name' => [
            'type' => auth()->check() && auth()->user()->source === 'manual' ? 'text' : 'view',
            'label' => 'Nama Lengkap',
            'placeholder' => 'Nama Anda',
            'id' => 'custom-display-name',
            'required' => auth()->check() && auth()->user()->source === 'manual',
            'rules' => auth()->check() && auth()->user()->source === 'manual' ? ['required', 'string', 'max:255'] : [],
            'view' => 'components.display-field', // untuk user non-manual (readonly)
            'view_data' => [
                'value' => auth()->check() ? auth()->user()->name : null,
            ],
            'column_span' => 'full',
        ],
    ],
];
