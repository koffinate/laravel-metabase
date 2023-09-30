<?php

return [
    'route' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
        'prefix' => 'metabase',
    ],
    'view' => [
        'layout' => 'koffinate::layouts.centered',
    ],
];
