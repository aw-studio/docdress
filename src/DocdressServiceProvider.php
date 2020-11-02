<?php

namespace Docdress;

use Docdress\Commands\AssetsCommand;
use Docdress\Commands\CloneCommand;
use Docdress\Commands\StatusCommand;
use Docdress\Commands\UpdateCommand;
use Docdress\Components\SearchInputComponent;
use Illuminate\Support\Facades\Blade;
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
        $this->app->singleton('docdress.git', function ($app) {
            return new Git($app['files']);
        });

        Blade::component('dd-search-input', SearchInputComponent::class);

        $this->commands([
            AssetsCommand::class,
            CloneCommand::class,
            UpdateCommand::class,
            StatusCommand::class,
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
        ], 'docdress:assets');

        $this->publishes([
            __DIR__.'/../publish/config/docdress.php' => config_path('docdress.php'),
        ], 'docdress:config');

        $this->mergeConfigFrom(
            __DIR__.'/../publish/config/docdress.php', 'docdress'
        );

        $this->app->register(DocdressRouteServiceProvider::class);
    }
}
