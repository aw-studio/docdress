<?php

namespace Tests\Integration;

use Docdress\Commands\AssetsCommand;
use Illuminate\Contracts\Console\Kernel;
use Mockery;

class UpdateCommandTest extends GitIntegrationTestCase
{
    /** @test */
    public function it_calls_assets_command()
    {
        $this->artisan('docdress:clone', ['repository' => 'repo']);

        $assetCommand = Mockery::mock(AssetsCommand::class.'[handle]');
        $assetCommand->shouldReceive('handle')->once();
        $this->app[Kernel::class]->registerCommand($assetCommand);

        $this->artisan('docdress:update', ['repository' => 'repo']);

        $this->assertFileExists(resource_path('docs/repo/master/readme.md'));
    }
}
