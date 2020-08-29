<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Documentations Path
     |--------------------------------------------------------------------------
     |
     | Docdress stores its documentation files in ./resources/docs by default.
     | You may change the path to where your documentation files are located.
     |
     */

    'path' => resource_path('docs'),

    /*
     |--------------------------------------------------------------------------
     | Docdress Settings
     |--------------------------------------------------------------------------
     |
     | Specify wether external links should be opened in a new tab.
     |
     */

    'open_external_links_in_new_tab' => true,

    /*
     |--------------------------------------------------------------------------
     | Docdress Repositories
     |--------------------------------------------------------------------------
     |
     | All GitHub repositories containing documentations are specified here.
     |
     */

    'repos' => [
        'my/repo' => [
            'route_prefix'    => 'docs',
            'subfolder'       => null,
            'default_page'    => 'introduction',
            'default_version' => 'master',
            'algolia_app_key' => env('ALGOLIA_APP_KEY', null),
            'versions'        => [
                'master' => 'Master',
            ],
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Docdress Themes
     |--------------------------------------------------------------------------
     |
     | The themes that are specified here are available for repository
     | documentations. When no spcific theme is given, the "default" theme is
     | used.
     |
     */

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
            'code-punctuation'   => '#055472',

            'algolia-icon-color' => '#090910',
        ],
    ],
];
