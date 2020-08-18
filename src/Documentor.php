<?php

namespace Docdress;

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
    public function getIndex($version)
    {
        $content = Str::after($this->parser->parse(
            $this->files->get($this->path($version, 'readme')),
            [

            ]
        ), '<h2>Index</h2>');

        preg_match_all('/(?<=\bhref=")[^"]*/', $content, $matches);

        foreach ($matches[0] as $match) {
            $page = str_replace('.md', '', $match);
            $content = str_replace($match, trim("/docs/{$version}/$page"), $content);
        }

        return $content;
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
     * @param  string $repo
     * @param  string $version
     * @param         $page
     * @param  [type] $subfolder
     * @return void
     */
    public function get($repo, $version, $page, $subfolder = null)
    {
        return $this->cache->remember("docs.{$version}.{$page}", 5, function () use ($version, $page) {
            if (! $this->exists($version, $page)) {
                return;
            }

            return $this->parser->parse(
                $this->files->get($this->path($version, $page)),
                [
                    TocParser::class,
                    AlertParser::class,
                    CodeParser::class,
                ]
            );
        });
    }

    protected function path($version, $page)
    {
        return resource_path("docs/{$version}/$page.md");
    }
}
