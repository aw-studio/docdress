<?php

namespace Tests\Integration;

use Illuminate\Support\Facades\File;

class GitIntegrationTestCase extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        
        if (exec('which /usr/bin/git') != '/usr/bin/git') {
            $this->markTestSkipped('The test requires git to be installed at /usr/bin/git');
        }
        
        if (! realpath(__DIR__.'/repo/.git')) {
            exec('cd '.__DIR__.'/repo && git init && git add . && git commit -m "init"', $output);
        }

        $this->app['docdress.git']->setUrlResolver(function ($repo, $token = null) {
            return __DIR__.'/repo';
        });
    }

    public function tearDown(): void
    {
        File::deleteDirectory(__DIR__.'/repo/.git');
        File::deleteDirectory(resource_path('docs'));

        parent::tearDown();
    }
}
