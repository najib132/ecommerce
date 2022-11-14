<?php

return [

    'driver' => env('SCOUT_DRIVER', 'algolia'),
    'prefix' => env('SCOUT_PREFIX', ''),
    'queue' => env('SCOUT_QUEUE', true),
    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],
    'soft_delete' => false,
    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', 'P36A9204TC'),
        'secret' => env('ALGOLIA_SECRET', 'd4a839de8fc76dd7df6ad1c3102ab168'),
    ],
];
