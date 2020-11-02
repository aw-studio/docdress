<?php

namespace Tests\Integration;

use Orchestra\Testbench\TestCase;

class IntegrationTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app['docdress.git']->setSilent(true);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('docdress.repos', [
            'repo' => [
                'route_prefix'    => 'repo',
                'subfolder'       => null,
                'default_version' => 'master',
                'default_page'    => 'foo',
                'versions'        => [
                    'master' => 'Master',
                ],
            ],
            'repo/subfolder' => [
                'route_prefix'    => 'repo-subfolder',
                'subfolder'       => 'sub',
                'default_version' => 'master',
                'default_page'    => 'wow',
                'versions'        => [
                    'master' => 'Master',
                ],
            ],
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            \BladeScript\ServiceProvider::class,
            \BladeStyle\ServiceProvider::class,
            \Docdress\DocdressServiceProvider::class,

        ];
    }
}
