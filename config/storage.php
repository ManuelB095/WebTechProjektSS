<?php

return [

    /*
    |------------------------------------------------
    | Default Storage Path
    |------------------------------------------------
    |
    | The default storage path will be used
    | if no valid storage is requested.
    |
    */

    'default' => 'assets',

    /*
    |------------------------------------------------
    | Storage Paths
    |------------------------------------------------
    */

    'paths' => [

        'ugc' => [
            'root' => 'ugc/',
            'visibility' => 'public',
        ],
        'assets' => [
            'root' => 'assets/',
            'visibility' => 'public',
        ],
        'img' => [
            'root' => 'assets/img/',
            'visibility' => 'public',
        ],

    ],

];
