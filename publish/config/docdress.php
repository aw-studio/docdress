<?php

return [
    'path' => resource_path('docs'),

    'open_external_links_in_new_tab' => true,

    'repos' => [
        'my/repo' => [
            'route_prefix'    => 'docs',
            'subfolder'       => null,
            'default_page'    => 'introduction',
            'default_version' => 'master',
            'versions'        => [
                'master' => 'Master',
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
