<?php

namespace Tests\Integration;

use Illuminate\Support\Facades\File;

class ScreenCommandTest extends GitIntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        File::deleteDirectory(__DIR__.'/repo/screens');
        File::deleteDirectory(storage_path('app/public/repo'));

        parent::tearDown();
    }

    /** @test */
    public function it_publishes_screens()
    {
        File::ensureDirectoryExists(resource_path('docs/repo/master/screens'));
        File::put(resource_path('docs/repo/master/screens/image'), '');

        $this->artisan('docdress:assets', ['repository' => 'repo']);

        $this->assertFileExists(storage_path('app/public/repo/master/screens/image'));
    }
}
