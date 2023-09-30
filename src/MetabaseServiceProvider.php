<?php

namespace Koffinate\Metabase;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MetabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/metabase.php', 'koffinate.metabase');
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'metabase');
        $this->publishes([$viewPath => resource_path('views/vendor/metabase')]);
        $this->publishes([__DIR__.'/../config/metabase.php' => config_path('koffinate/metabase.php')], 'config');

        Blade::component('metabase', MetabaseComponent::class);
    }
}
