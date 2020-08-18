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
        Route::get('/'.config('docdress.route_prefix').'/{version?}/{page?}');
    }
}
