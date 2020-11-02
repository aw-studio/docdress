<?php

namespace Docdress\Commands;

use Docdress\Support\Git;
use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docdress:update {repository}
                            {--branch= : The version that should be updated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the repository.';

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

        $version = $this->option('branch');

        if ($version != 0) {
            $versions = [$version => null];
        } else {
            $versions = config("docdress.repos.{$repo}.versions");
        }

        foreach ($versions as $version => $title) {
            $subfolder = config("docdress.repos.{$repo}.subfolder");
            Git::pull($repo, $version, $subfolder);
            $this->info("Updated {$repo}[$version]");
        }

        $this->call('docdress:assets', ['repository' => $repo]);
    }
}
