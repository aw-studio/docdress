<?php

namespace Docdress;

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
        //
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
    }
}
