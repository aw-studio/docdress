<?php

return [
    'path' => resource_path('docs'),

    'repos' => [
        'fjuse/docs' => [
            'route_prefix'    => 'docs',
            'subfolder'       => null,
            'default_page'    => 'introduction',
            'default_version' => '2.4',
            'webhook_token'   => env('WEBHOOK_TOKEN', null),
            'versions'        => [
                'master' => 'Master',
                '2.4'    => '2.4',
            ],
        ],
    ],

    'themes' => [
        'default' => [
            'primary' => '#4951f2',

            'code-bg'            => '#f5f8fb',
            'code-selection'     => '#b3d4fc',
            'code-value'         => '#055472',
            'code-prop'          => '#d44545',
            'code-function'      => '#4951f2',
            'code-variable'      => '#588bbd',
            'code-string'        => '#169f0c',
            'code-default-color' => '#090910',
        ],
    ],
];
