<?php

namespace Docdress;

use Illuminate\Support\Facades\File;

class Git
{
    /**
     * Pull or clone repository.
     *
     * @param  string      $repo
     * @param  string      $branch
     * @param  string|null $subfolder
     * @param  string      $token
     * @return void
     */
    public static function pullOrClone($repo, $branch = 'master', $subfolder = null, $token = null)
    {
        if (realpath(self::path($repo, $branch))) {
            return self::pull($repo, $branch);
        } else {
            return self::clone($repo, $branch, $subfolder, $token);
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
    public static function clone($repo, $branch, $subfolder, $token = null)
    {
        if (! is_null($subfolder)) {
            return self::cloneSubfolder($repo, $branch, $subfolder, $token);
        } else {
            return self::cloneRoot($repo, $branch, $token);
        }
    }

    /**
     * Pull repository.
     *
     * @param  string $repo
     * @param  string $branch
     * @return void
     */
    public static function pull($repo, $branch = 'master')
    {
        $path = self::path($repo, $branch);

        exec("cd {$path} && git pull");
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
    protected static function cloneSubfolder($repo, $branch, $folder, $token = null)
    {
        $path = self::path($repo, $branch);

        File::ensureDirectoryExists($path);
        exec('
            cd '.$path.' \
            && git init \
            && git remote add -f origin '.self::cloneUrl($repo, $token).' \
            && git config core.sparseCheckout true \
            && echo "/'.$folder.'" >> .git/info/sparse-checkout \
            && git checkout '.$branch.' \
            && git pull origin '.$branch.'
        ');
    }

    /**
     * Clone full repository.
     *
     * @param  string      $repo
     * @param  string      $branch
     * @param  string|null $token
     * @return void
     */
    protected static function cloneRoot($repo, $branch, $token = null)
    {
        $path = self::path($repo, $branch);
        $url = self::cloneUrl($repo, $token);

        exec('
            git clone -b '.$branch.' '.$url.' '.$path.' \
            && cd '.$path.' \
            && git remote add -f origin '.$url.'
        ');
    }

    /**
     * Get clone url for repo.
     *
     * @param  string      $repo
     * @param  string|null $token
     * @return string
     */
    protected static function cloneUrl($repo, $token = null)
    {
        if ($token) {
            return "https://{$token}@github.com/{$repo}.git";
        }

        return "https://github.com/{$repo}.git";
    }

    /**
     * Get docs path.
     *
     * @param  string $repo
     * @param  string $branch
     * @return string
     */
    protected static function path($repo, $branch)
    {
        $path = "resources/docs/{$repo}/{$branch}";

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
    public static function status($repo, $branch)
    {
        if (! realpath($path = static::path($repo, $branch))) {
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
