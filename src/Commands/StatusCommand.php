<?php

namespace Docdress\Commands;

use Docdress\Support\Git;
use Illuminate\Console\Command;

class StatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docdress:status {repository}
                            {--branch= : The version that should be checked}';

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
            $status = Git::status($repo, $version);
            $this->line("{$repo}[{$version}]: {$status}");
        }
    }
}
