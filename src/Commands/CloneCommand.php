<?php

namespace Docdress\Commands;

use Docdress\Support\Git;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CloneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docdress:clone {repository}';

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

        $this->prepareResourceDirectory();

        $subfolder = config("docdress.repos.{$repo}.subfolder");
        $token = config("docdress.repos.{$repo}.access_token");

        foreach (config("docdress.repos.{$repo}.versions") as $version => $title) {
            Git::clone($repo, $version, $subfolder, $token);
            $this->info("Cloned {$repo}[$version]");
        }

        $this->call('docdress:assets', ['repository' => $repo]);
    }

    /**
     * Prepare resource directory.
     *
     * @return void
     */
    protected function prepareResourceDirectory()
    {
        File::ensureDirectoryExists($path = config('docdress.path'));
        if (! File::exists($path.'/.gitignore')) {
            File::put($path.'/.gitignore', "*\n!.gitignore");
        }
    }
}
