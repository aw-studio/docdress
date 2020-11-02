<?php

namespace Tests\Integration;

use Docdress\Commands\AssetsCommand;
use Illuminate\Contracts\Console\Kernel;
use Mockery;

class CloneCommandTest extends GitIntegrationTestCase
{
    /** @test */
    public function it_clones_repo_into_resources()
    {
        $this->artisan('docdress:clone', [
            'repository' => 'repo',
        ]);

        $this->assertFileExists(resource_path('docs/repo/master/readme.md'));
    }

    /** @test */
    public function it_clones_subfolder_of_repo_into_resources()
    {
        $this->artisan('docdress:clone', [
            'repository' => 'repo/subfolder',
        ]);

        $this->assertFileExists(resource_path('docs/repo/subfolder/master/sub/readme.md'));
    }

    /** @test */
    public function it_calls_assets_command()
    {
        $assetCommand = Mockery::mock(AssetsCommand::class.'[handle]');
        $assetCommand->shouldReceive('handle')->once();
        $this->app[Kernel::class]->registerCommand($assetCommand);

        $this->artisan('docdress:clone', [
            'repository' => 'repo',
        ]);
    }
}
