<?php

namespace Docdress\Commands\Concerns;

use Docdress\Documentor;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

trait ManagesScreens
{
    /**
     * Publish screens.
     *
     * @param  string $repo
     * @param  string $version
     * @param  string $subfolder
     * @return void
     */
    protected function publishScreens($repo, $version, $subfolder)
    {
        $path = app(Documentor::class)->path($repo, $version, null, $subfolder);
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path)
        );

        foreach ($iterator as $file) {
            if (! $this->isFileScreenDirectory($file)) {
                continue;
            }

            $publicDir = storage_path('app/public/'.config("docdress.repos.{$repo}.route_prefix").'/'.$version.str_replace($path, '', $file));

            File::ensureDirectoryExists($publicDir);
            File::copyDirectory($file, $publicDir);
        }
    }

    /**
     * Determines if file is a screen directory.
     *
     * @param  SplFileInfo $file
     * @return bool
     */
    protected function isFileScreenDirectory(SplFileInfo $file)
    {
        if (! $file->isDir()) {
            return false;
        }

        return Str::endsWith(realpath($file->getPathname()), 'screens');
    }
}
