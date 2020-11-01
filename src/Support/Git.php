<?php

namespace Docdress\Support;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Docdress\Git
 */
class Git extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'docdress.git';
    }
}
