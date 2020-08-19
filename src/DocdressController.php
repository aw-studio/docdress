<?php

namespace Docdress;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\DomCrawler\Crawler;

class DocdressController
{
    use AuthorizesRequests;

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
        $repo = $request->repository['full_name'] ?? null;

        if (! array_key_exists($repo, config('docdress.repos'))) {
            return;
        }

        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');
        $localToken = config("docdress.repos.{$repo}.webhook_token");
        $localHash = 'sha1='.hash_hmac('sha1', $githubPayload, $localToken, false);

        if (! hash_equals($githubHash, $localHash)) {
            return;
        }

        if (! $this->docs->exists($repo, $version)) {
            return;
        }

        Artisan::call('docdress:update', [
            'repository' => $repo,
            '--branch'   => $version,
        ]);
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

        if (Gate::has("docdress.{$repo}")) {
            $this->authorize("docdress.{$repo}");
        }

        if (! $this->isValidVersion($repo, $version)) {
            return redirect(route("docdress.docs.{$repo}", ['version' => config("docdress.repos.{$repo}.default_version")]));
        }

        if (! $page) {
            $page = config("docdress.repos.{$repo}.default_page");
        }

        if ($subPage) {
            $page .= "/{$subPage}";
        }

        $content = $this->getContent($repo, $version, $page);

        $index = $this->docs->index($repo, $version, 'readme');
        $theme = $this->docs->theme($repo);

        $title = (new Crawler($content))->filterXPath('//h1');

        return view('docdress::docs', [
            'index'          => $index,
            'title'          => $title,
            'content'        => $content,
            'versions'       => config("docdress.repos.{$repo}.versions"),
            'currentVersion' => $version,
            'theme'          => $theme,
        ]);
    }

    /**
     * Get docs content.
     *
     * @param  string $repo
     * @param  string $version
     * @param  string $page
     * @return string
     */
    protected function getContent($repo, $version, $page)
    {
        if ($this->docs->exists($repo, $version, $page)) {
            return $this->docs->get($repo, $version, $page);
        }

        return (string) view('docdress::not-found');
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
