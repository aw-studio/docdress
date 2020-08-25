<?php

namespace Tests;

use Docdress\DocdressServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            DocdressServiceProvider::class,
        ];
    }
}
