<?php

namespace Tests;

class DocdressControllerTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('docdress.repos', ['foo/bar' => [
            'route_prefix'    => 'foo',
            'default_version' => '1.0',
            'versions'        => ['1.0' => '1.0'],
        ]]);
    }

    /** @test */
    public function it_redirects_to_page_with_default_version_when_no_version_is_given()
    {
        $this->get('foo/introduction')->assertRedirect('foo/1.0/introduction');
    }

    /** @test */
    public function it_redirects_to_sub_page_with_default_version_when_no_version_is_given()
    {
        $this->get('foo/basics/basics')->assertRedirect('foo/1.0/basics/basics');
    }
}
