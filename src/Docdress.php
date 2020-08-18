<?php

namespace Docdress;

use Illuminate\Support\Facades\Route;

class Docdress
{
    /**
     * Create webhook route.
     *
     * @param  string $route
     * @return void
     */
    protected static function webhook($route)
    {
        Route::post($route, [DocdressController::class, 'webhook'])
            ->name('docs.webhook');
    }
}
