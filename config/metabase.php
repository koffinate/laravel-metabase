<?php

return [
    'url' => env('METABASE_URL'),
    'secret' => env('METABASE_SECRET'),

    'off' => (bool) env('METABASE_OFF'),
    'off_message' => env('METABASE_OFF_MESSAGE'),

    'on_local' => (bool) env('METABASE_ON_LOCAL', true),
];
