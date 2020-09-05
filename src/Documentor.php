<?php

namespace Docdress;

use Docdress\Parser\AlertParser;
use Docdress\Parser\CodeParser;
use Docdress\Parser\CodePathParser;
use Docdress\Parser\LinkNameParser;
use Docdress\Parser\LinkParser;
use Docdress\Parser\SrcParser;
use Docdress\Parser\TocParser;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Documentor
{
    /**
     * Filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Cache isntance.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Parser instance.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * Create new Documentor isntance.
     *
     * @param  Filesystem $files
     * @param  Cache      $cache
     * @param  Parser     $parser
     * @return void
     */
    public function __construct(Filesystem $files, Cache $cache, Parser $parser)
    {
        $this->files = $files;
        $this->cache = $cache;
        $this->parser = $parser;
    }

    /**
     * Get version index.
     *
     * @param  string $version
     * @return string
     */
    public function index($repo, $version, $subfolder = null)
    {
        return $this->cache->remember("docs.index.{$repo}.{$version}", 5, function () use ($repo, $version) {
            $content = Str::after($this->parser->parse(
                $this->files->get($this->path($repo, $version, 'readme')),
                [

                ]
            ), '<h2>Index</h2>');

            preg_match_all('/(?<=\bhref=")[^"]*/', $content, $matches);

            foreach ($matches[0] as $match) {
                $page = str_replace('.md', '', $match);
                $link = preg_replace('#/+#', '/', '/'.$this->routePrefix($repo)."/{$version}/$page");
                $content = str_replace('href="'.$match, 'href="'.$link, $content);
            }

            return $content;
        });
    }

    /**
     * Get the route prefix for the given repository.
     *
     * @param  string $repo
     * @return string
     */
    protected function routePrefix($repo)
    {
        return config("docdress.repos.{$repo}.route_prefix");
    }

    /**
     * Dermines if a page exists.
     *
     * @param  string      $project
     * @param  string      $version
     * @param  string|null $page
     * @return bool
     */
    public function exists($repo, $version, $page = null, $subfolder = null)
    {
        return $this->files->exists(
            $this->path($repo, $version, $page, $subfolder)
        );
    }

    /**
     * Get documentation.
     *
     * @param  string      $repo
     * @param  string      $version
     * @param  string      $page
     * @param  string|null $subfolder
     * @return string
     */
    public function get($repo, $version, $page, $subfolder = null)
    {
        return $this->cache->remember("docs.{$repo}.{$version}.{$page}", 5, function () use ($repo, $version, $page) {
            if (! $this->exists($repo, $version, $page)) {
                return;
            }

            $parser = [
                TocParser::class,
                AlertParser::class,
                CodePathParser::class,
                CodeParser::class,
                SrcParser::class,
                LinkParser::class,
                LinkNameParser::class,
            ];

            return $this->parser->parse(
                $this->files->get($this->path($repo, $version, $page)),
                $parser
            );
        });
    }

    /**
     * Get theme for the given repository.
     *
     * @param  string $repo
     * @return array
     */
    public function theme($repo)
    {
        $themes = config('docdress.themes');

        return $themes[config("docdress.repos.{$repo}.theme")]
            ?? $themes['default'];
    }

    /**
     * Get path.
     *
     * @param  string $repo
     * @param  string $version
     * @param  string $page
     * @param  string $subfolder
     * @return string
     */
    public function path($repo, $version, $page = null, $subfolder = null)
    {
        $path = resource_path("docs/{$repo}/{$version}");

        if ($subfolder) {
            $path .= "/{$subfolder}";
        }

        if ($page) {
            $path .= "/{$page}.md";
        }

        return preg_replace('#/+#', '/', $path);
    }
}
