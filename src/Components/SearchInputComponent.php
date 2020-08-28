<?php

namespace Docdress\Components;

use Illuminate\View\Component;

class SearchInputComponent extends Component
{
    /**
     * CSS Classes.
     *
     * @var string
     */
    public $class = '';

    /**
     * Version.
     *
     * @var string
     */
    public $version = 'master';

    /**
     * Repository config.
     *
     * @var object|null
     */
    public $config;

    /**
     * Create new SearchInputComponent instance.
     *
     * @param  string $class
     * @return void
     */
    public function __construct($repo, $version = 'master', $class = '')
    {
        $this->config = (object) config("docdress.repos.{$repo}");
        $this->version = $version;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('docdress::components.search_input');
    }
}
