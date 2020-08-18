<?php

namespace Docdress;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;
use Symfony\Component\DomCrawler\Crawler;

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

    /**
     * Handle docs route.
     *
     * @param  string $version
     * @param  string $page
     * @param  string $subPage
     * @return View
     */
    public function show(Request $request, $version, $page = null, $subPage = null)
    {
        $repo = $this->getRequestRepo($request);

        if (! $this->isValidVersion($repo, $version)) {
            return redirect(route('docdress.docs', ['version' => config('docdress.default_version')]));
        }

        if (! $page) {
            $page = config('docdress.default_page');
        }

        if ($subPage) {
            $page .= "/{$subPage}";
        }

        $content = $this->docs->get(
            $repo, $version, $page
        );
        $version = $this->docs->index(
            $repo, $version, 'readme'
        );

        $title = (new Crawler($content))->filterXPath('//h1');

        return view('docdress::docs', [
            'index'          => $version,
            'title'          => $title,
            'content'        => $content,
            'versions'       => config('docdress.versions'),
            'currentVersion' => $version,
        ]);
    }

    /**
     * Get repository name from route.
     *
     * @param  Request $route
     * @return string
     */
    protected function getRequestRepo(Request $request)
    {
        return last(explode('.', $request->route()->getName()));
    }

    /**
     * Dermines if the given version is valid.
     *
     * @param  int  $version
     * @return bool
     */
    protected function isValidVersion($repo, $version)
    {
        return array_key_exists($version, config("docdress.repos.{$repo}.versions"));
    }
}
