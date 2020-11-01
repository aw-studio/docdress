<?php

namespace Docdress\Contracts;

interface Git
{
    /**
     * Clone repository.
     *
     * @param  string      $repo
     * @param  string      $branch
     * @param  string|null $token
     * @return void
     */
    public function clone($repo, $branch = 'master', $subfolder = null, $token = null);

    /**
     * Pull repository.
     *
     * @param  string $repo
     * @param  string $branch
     * @return void
     */
    public function pull($repo, $branch = 'master');

    /**
     * Pull or clone repository.
     *
     * @param  string      $repo
     * @param  string      $branch
     * @param  string|null $subfolder
     * @param  string      $token
     * @return void
     */
    public function pullOrClone($repo, $branch = 'master', $subfolder = null, $token = null);

    /**
     * Get status for repository version.
     *
     * @param  string $version
     * @return string
     */
    public function status($repo, $branch = 'master');
}
