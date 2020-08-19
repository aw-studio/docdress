<?php

namespace Docdress;

use Closure;
use Illuminate\Support\Facades\Gate;

class Docdress
{
    /**
     * Define a gate for the given repository.
     *
     * @param  string  $repo
     * @param  Closure $closure
     * @return void
     */
    public static function gate($repo, Closure $closure)
    {
        Gate::define("docdress.{$repo}", $closure);
    }
}
