<?php

namespace Docdress;

use Illuminate\Http\Request;

class DocdressController
{
    /**
     * Documentor instance.
     *
     * @var Documentor
     */
    protected $docs;

    /**
     * Create new DocdressController instance.
     *
     * @param  Documentor $docs
     * @return void
     */
    public function __construct(Documentor $docs)
    {
        $this->docs = $docs;
    }

    /**
     * Handle github webhook call.
     *
     * @param  Request $request
     * @return void
     */
    public function webhook(Request $request)
    {
        $version = last(explode('/', $request->ref));
        $repo = $request->repository->full_name ?? null;

        if (! $this->docs->exists($repo, $version)) {
            return;
        }

        Git::pull($repo, $version);
    }
}
