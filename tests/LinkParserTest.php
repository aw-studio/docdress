<?php

namespace Tests;

use Docdress\Parser\LinkParser;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Mockery as m;

class LinkParserTest extends TestCase
{
    /** @test */
    public function it_adds_target_blank_to_external_links()
    {
        $result = (new LinkParser)->parse('<a href="https://www.example.org">foo</a>');

        $this->assertSame('<a href="https://www.example.org" target="_blank">foo</a>', $result);
    }

    /** @test */
    public function it_removes_md_file_extension()
    {
        $route = $this->getRoute();
        $result = (new LinkParser)->parse('<a href="foo.md">foo</a>');
        $this->assertStringContainsString('href="http://test/1.0/foo"', $result);
    }

    /** @test */
    public function test_from_subfolder_to_root()
    {
        $route = $this->getRoute('bar', 'baz');
        $result = (new LinkParser)->parse('<a href="/../foo.md">foo</a>');
        $this->assertStringContainsString('href="http://test/1.0/foo"', $result);
        $result = (new LinkParser)->parse('<a href="../foo.md">foo</a>');
        $this->assertStringContainsString('href="http://test/1.0/foo"', $result);
    }

    /** @test */
    public function test_from_subfolder_to_subfolder()
    {
        $route = $this->getRoute('baz', 'test');
        $result = (new LinkParser)->parse('<a href="/../foo/bar.md">foo</a>');
        $this->assertStringContainsString('href="http://test/1.0/foo/bar"', $result);
        $result = (new LinkParser)->parse('<a href="../foo/bar.md">foo</a>');
        $this->assertStringContainsString('href="http://test/1.0/foo/bar"', $result);
    }

    /** @test */
    public function it_sets_data_turbo_link_to_false_for_same_page_anchor_links()
    {
        $result = (new LinkParser)->parse('<a href="#foo">foo</a>');

        $this->assertSame('<a href="#foo" data-turbolinks="false">foo</a>', $result);
    }

    /** @test */
    public function parsed_anchor_link_wont_not_effect_anchor_text()
    {
        $result = (new LinkParser)->parse('<a href="#foo">foo</a> #foo');

        $this->assertSame('<a href="#foo" data-turbolinks="false">foo</a> #foo', $result);
    }

    public function getRoute($page = 'introduction', $subPage = null)
    {
        $route = m::mock('route');
        Request::setRouteResolver(fn () => $route);
        $route->shouldReceive('getName')->andReturn('docs');
        Route::get('/{version}/{page?}/{sub_page?}', fn () => null)->name('docs');

        $route->shouldReceive('parameter')->withArgs(['version', null])->andReturn('1.0');
        $route->shouldReceive('parameter')->withArgs(['page', null])->andReturn($page);
        $route->shouldReceive('parameter')->withArgs(['sub_page', null])->andReturn($subPage);

        return $route;
    }
}
