<?php

namespace Docdress;

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
     * Create new SearchInputComponent instance.
     *
     * @param  string $class
     * @return void
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('docdress::search_input');
    }
}
