<?php

namespace Docdress;

use Docdress\Commands\CloneCommand;
use Docdress\Commands\UpdateCommand;
use Illuminate\Support\ServiceProvider;

class DocdressServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(DocdressRouteServiceProvider::class);

        $this->commands([
            CloneCommand::class,
            UpdateCommand::class,
        ]);
    }

    /**
     * Boot application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'docdress');

        $this->publishes([
            __DIR__.'/../publish/public' => public_path('docdress'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/../publish/config/docdress.php' => config_path('docdress.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../publish/config/docdress.php', 'docdress'
        );
    }
}
