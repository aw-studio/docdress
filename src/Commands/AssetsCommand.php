<?php

namespace Docdress\Commands;

use Docdress\Documentor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docdress:assets {repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone the repository.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repo = $this->argument('repository');

        if (! array_key_exists($repo, config('docdress.repos'))) {
            return $this->error("Couldn't find {$repo} in config [docdress.repos].");
        }

        $subfolder = config("docdress.repos.{$repo}.subfolder");
        $token = config("docdress.repos.{$repo}.access_token");

        foreach (config("docdress.repos.{$repo}.versions") as $version => $title) {
            $this->publishScreens($repo, $version, $subfolder);
        }
    }

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
