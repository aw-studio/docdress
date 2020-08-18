<?php

namespace Docdress\Commands;

use Docdress\Git;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CloneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docdress:clone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone the documentaition repository.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        File::ensureDirectoryExists(config('docdress.path'));

        foreach (config('docdress.versions') as $version => $title) {
            Git::clone($repo = config('docdress.repository'), $version, config('docdress.subfolder'));
            $this->info("Cloned {$repo} [$version]");
        }
    }
}
