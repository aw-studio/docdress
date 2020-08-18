<?php

return [
    'path' => resource_path('docs'),

    'repos' => [

        'fjuse/docs' => [
            'route_prefix'    => 'docs',
            'subfolder'       => null,
            'default_page'    => 'introduction',
            'default_version' => '2.4',
            'versions'        => [
                'master' => 'Master',
                '2.4'    => '2,4',
            ],
        ],
    ],
];
