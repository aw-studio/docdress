<?php

namespace Docdress;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class DocdressRouteServiceProvider extends RouteServiceProvider
{
    /**
     * Boot application services.
     *
     * @return void
     */
    public function map()
    {
        Route::post('_docdress/update', [DocdressController::class, 'webhook'])->name('docdress.webhook');

        foreach (config('docdress.repos') ?: [] as $repo => $config) {
            Route::redirect($config['route_prefix'], '/'.$config['route_prefix'].'/'.$config['default_version'])->middleware('web');

            Route::get('/'.$config['route_prefix'].'/{version}/{page?}/{sub_page?}', [
                DocdressController::class, 'show',
            ])->name("docdress.docs.{$repo}")->middleware('web');
        }
    }
}
