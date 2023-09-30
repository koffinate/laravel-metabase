<?php

return [
    'url' => env('METABASE_URL'),
    'secret' => env('METABASE_SECRET'),
    'on_local' => (bool) env('METABASE_ON_LOCAL', true),
];
