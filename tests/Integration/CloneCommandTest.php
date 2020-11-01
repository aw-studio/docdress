<?php

namespace Tests\Integration;

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
}
