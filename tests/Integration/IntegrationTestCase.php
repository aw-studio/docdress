<?php

namespace Tests\Integration;

use Orchestra\Testbench\TestCase;

class IntegrationTestCase extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        //
    }

    protected function getPackageProviders($app)
    {
        return [
            \Docdress\DocdressServiceProvider::class,
        ];
    }
}
