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
    public static function webhook($route)
    {
        Route::post($route, [DocdressController::class, 'webhook'])
            ->name('docs.webhook');
    }

    /**
     * Get docs view.
     *
     * @param  string $repo
     * @param  string $version
     * @param  string $page
     * @param  string $subfolder
     * @return View
     */
    public static function view($repo, $version, $page, $subfolder = null)
    {
        $docs = app(Documentor::class);

        return view('docdress::docs', [
            'content' => $docs->get($repo, $version, $page, $subfolder),
            'index'   => $docs->index($repo, $version, $subfolder),
        ]);
    }
}
