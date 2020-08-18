<?php

namespace Docdress\Commands;

use Docdress\Git;
use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docdress:update 
                            {--branch= : The version that should be updated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the documentaition repository.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $version = $this->option('branch');

        if ($version != 0) {
            $versions = [$version => null];
        } else {
            $versions = config('docdress.versions');
        }

        foreach ($versions as $version => $title) {
            Git::pull($repo = config('docdress.repository'), $version, config('docdress.subfolder'));
            $this->info("Updated {$repo} [$version]");
        }
    }
}
