<?php

namespace Docdress;

use Closure;
use Docdress\Contracts\Git as GitContract;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class Git implements GitContract
{
    /**
     * Url resolver. Resolves the path or url to a git repository.
     *
     * @var Closure
     */
    protected $urlResolver;

    /**
     * Filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Set silent.
     *
     * @var bool
     */
    protected $silent = false;

    /**
     * Create new Git instance.
     *
     * @param  Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->urlResolver = $this->getDefaultUrlResolver();
    }

    /**
     * Set silent.
     *
     * @param  bool $silent
     * @return void
     */
    public function setSilent(bool $silent)
    {
        $this->silent = $silent;
    }

    /**
     * Get default url resolver.
     *
     * @return Closure
     */
    protected function getDefaultUrlResolver(): Closure
    {
        return function ($repo, $token = null) {
            if ($token) {
                return "https://{$token}@github.com/{$repo}.git";
            }

            return "https://github.com/{$repo}.git";
        };
    }

    /**
     * Set url resolver.
     *
     * @param  Closure $resolver
     * @return void
     */
    public function setUrlResolver(Closure $resolver)
    {
        $this->urlResolver = $resolver;
    }

    /**
     * Pull or clone repository.
     *
     * @param  string      $repo
     * @param  string      $branch
     * @param  string|null $subfolder
     * @param  string      $token
     * @return void
     */
    public function pullOrClone($repo, $branch = 'master', $subfolder = null, $token = null)
    {
        if (realpath($this->path($repo, $branch))) {
            return $this->pull($repo, $branch);
        } else {
            return $this->clone($repo, $branch, $subfolder, $token);
        }
    }

    /**
     * Clone repository.
     *
     * @param  string      $repo
     * @param  string      $branch
     * @param  string|null $token
     * @return void
     */
    public function clone($repo, $branch = 'master', $subfolder = null, $token = null)
    {
        if (! is_null($subfolder)) {
            return $this->cloneSubfolder($repo, $branch, $subfolder, $token);
        } else {
            return $this->cloneRoot($repo, $branch, $token);
        }
    }

    /**
     * Pull repository.
     *
     * @param  string $repo
     * @param  string $branch
     * @return void
     */
    public function pull($repo, $branch = 'master')
    {
        $path = $this->path($repo, $branch);

        exec($this->cmd("cd {$path}", 'git pull'));
    }

    /**
     * Resolve shell command.
     *
     * @param  array|string $cmd
     * @return string
     */
    protected function cmd($cmd)
    {
        $cmds = collect(Arr::wrap($cmd));

        if ($this->silent) {
            $cmds = $cmds->map(fn ($cmd) => "$cmd 2> /dev/null");
        }

        return $cmds->implode(' && ');
    }

    /**
     * Clone subfolder.
     *
     * @param  string      $repo
     * @param  string      $branch
     * @param  string      $folder
     * @param  string|null $token
     * @return void
     */
    protected function cloneSubfolder($repo, $branch, $folder, $token = null)
    {
        $path = $this->path($repo, $branch);

        File::ensureDirectoryExists($path);
        exec($this->cmd([
            'cd '.$path,
            'git init',
            'git remote add -f origin '.$this->cloneUrl($repo, $token),
            'git config core.sparseCheckout true',
            'echo "/'.$folder.'" >> .git/info/sparse-checkout',
            'git checkout '.$branch,
            'git pull origin '.$branch,
        ]));
    }

    /**
     * Clone full repository.
     *
     * @param  string      $repo
     * @param  string      $branch
     * @param  string|null $token
     * @return void
     */
    protected function cloneRoot($repo, $branch, $token = null)
    {
        $path = $this->path($repo, $branch);
        $url = $this->cloneUrl($repo, $token);

        exec($this->cmd([
            'git clone -b '.$branch.' '.$url.' '.$path,
            'cd '.$path,
            'git remote add -f origin '.$url,
        ]));
    }

    /**
     * Get clone url for repo.
     *
     * @param  string      $repo
     * @param  string|null $token
     * @return string
     */
    protected function cloneUrl($repo, $token = null)
    {
        return ($this->urlResolver)($repo, $token);
    }

    /**
     * Get docs path.
     *
     * @param  string $repo
     * @param  string $branch
     * @return string
     */
    protected function path($repo, $branch)
    {
        $path = resource_path("/docs/{$repo}/{$branch}");

        if (! app()->runningInConsole()) {
            $path = '../'.$path;
        }

        return $path;
    }

    /**
     * Get status for repository version.
     *
     * @param  string $version
     * @return string
     */
    public function status($repo, $branch = 'master')
    {
        if (! realpath($path = $this->path($repo, $branch))) {
            return State::MISSING;
        }

        exec('
            cd '.$path.' \
            && UPSTREAM=${1:-\'@{u}\'} \
            && echo $(git rev-parse @) \
            && echo $(git rev-parse "$UPSTREAM") \
            && echo $(git merge-base @ "$UPSTREAM")
        ', $output);

        $local = $output[0];
        $remote = $output[1];
        $base = $output[2];

        if ($local == $remote) {
            return State::UP_TO_DATE;
        }

        if ($local == $base) {
            return State::NEED_TO_PULL;
        }

        return State::DIVERGE;
    }
}
