<?php

namespace Tests\Integration;

use Docdress\Documentor;
use Illuminate\Support\Facades\File;
use Mockery;

class ControllerTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(resource_path('docs/repo/master'));
        File::copyDirectory(__DIR__.'/repo', resource_path('docs/repo/master'));

        File::ensureDirectoryExists(resource_path('docs/repo/subfolder/master/sub'));
        File::copyDirectory(__DIR__.'/repo/sub', resource_path('docs/repo/subfolder/master/sub'));
    }

    public function tearDown(): void
    {
        File::deleteDirectory(resource_path('docs'));

        parent::tearDown();
    }

    /** @test */
    public function test_it_redirects_to_default_branch()
    {
        $this->get('/repo')->assertStatus(302)->assertRedirect('/repo/master');
        $this->get('/repo-subfolder')->assertStatus(302)->assertRedirect('/repo-subfolder/master');
    }

    /** @test */
    public function test_it_shows_default_page()
    {
        $documentor = Mockery::mock(app(Documentor::class));
        $documentor->shouldReceive('get')->withArgs([
            'repo', 'master', 'foo', null,
        ])->once();
        $this->app[Documentor::class] = $documentor;
        $this->json('GET', '/repo/master')->assertStatus(200);
    }

    /** @test */
    public function test_it_shows_subfolder_page()
    {
        $documentor = Mockery::mock(app(Documentor::class));
        $documentor->shouldReceive('get')->withArgs([
            'repo/subfolder', 'master', 'wow', 'sub',
        ])->once();
        $this->app[Documentor::class] = $documentor;
        $this->json('GET', '/repo-subfolder/master/wow')->assertStatus(200);
    }
}
