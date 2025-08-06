<?php

return [
    'avatar_column' => 'avatar_url',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public',
    'show_custom_fields' => false,
    'custom_fields' => [
        'custom_field_1' => [
            'type' => 'text', // required
            'label' => 'Custom Textfield 1', // required
            'placeholder' => 'Custom Field 1', // optional
            'id' => 'custom-field-1', // optional
            'required' => true, // optional
            'rules' => [], // optional
            'hint_icon' => '', // optional
            'hint' => '', // optional
            'suffix_icon' => '', // optional
            'prefix_icon' => '', // optional
            'default' => '', // optional
            'column_span' => 'full', // optional
            'autocomplete' => false, // optional
        ],
        'custom_field_2' => [
            'type' => 'password', // required
            'label' => 'Custom Password field 2', // required
            'placeholder' => 'Custom Password Field 2', // optional
            'id' => 'custom-field-2', // optional
            'required' => true, // optional
            'rules' => [], // optional
            'hint_icon' => '', // optional
            'hint' => '', // optional
            'default' => '', // optional
            'column_span' => 'full',
            'revealable' => true, // optional
            'autocomplete' => true, // optional
        ],
        'custom_field_3' => [
            'type' => 'select', // required
            'label' => 'Custom Select 3', // required
            'placeholder' => 'Select', // optional
            'id' => 'custom-field-3', // optional
            'required' => true, // optional
            'options' => [
                'option_1' => 'Option 1',
                'option_2' => 'Option 2',
                'option_3' => 'Option 3',
            ], // optional
            'selectable_placeholder' => true, // optional
            'native' => true, // optional
            'preload' => true, // optional
            'suffix_icon' => '', // optional
            'default' => '', // optional
            'searchable' => true, // optional
            'column_span' => 'full', // optional
            'rules' => [], // optional
            'hint_icon' => '', // optional
            'hint' => '', // optional
        ],
        'custom_field_4' => [
            'type' => 'textarea', // required
            'label' => 'Custom Textarea 4', // required
            'placeholder' => 'Textarea', // optional
            'id' => 'custom-field-4', // optional
            'rows' => '3', // optional
            'required' => true, // optional
            'hint_icon' => '', // optional
            'hint' => '', // optional
            'default' => '', // optional
            'rules' => [], // optional
            'column_span' => 'full', // optional
        ],
        'custom_field_5' => [
            'type' => 'datetime', // required
            'label' => 'Custom Datetime 5', // required
            'placeholder' => 'Datetime', // optional
            'id' => 'custom-field-5', // optional
            'seconds' => false, // optional
            'required' => true, // optional
            'hint_icon' => '', // optional
            'hint' => '', // optional
            'default' => '', // optional
            'suffix_icon' => '', // optional
            'prefix_icon' => '', // optional
            'rules' => [], // optional
            'format' => 'Y-m-d H:i:s', // optional
            'time' => true, // optional
            'native' => true, // optional
            'column_span' => 'full', // optional
        ],
        'custom_field_6' => [
            'type' => 'boolean', // required
            'label' => 'Custom Boolean 6', // required
            'placeholder' => 'Boolean', // optional
            'id' => 'custom-field-6', // optional
            'hint_icon' => '', // optional
            'hint' => '', // optional
            'default' => '', // optional
            'rules' => [], // optional
            'column_span' => 'full', // optional
        ],
    ]
];
