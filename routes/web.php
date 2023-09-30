<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => config('koffinate.metabase.route.prefix'),
        'as' => 'metabase::',
        'middleware' => config('koffinate.metabase.route.middleware'),
    ],
    function () {
        Route::resource('embed', \Koffinate\Metabase\Controllers\EmbedController::class)->only('show');
    }
);
