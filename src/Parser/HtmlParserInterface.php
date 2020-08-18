<?php

namespace Docdress;

interface HtmlParserInterface
{
    /**
     * Parse the given html..
     *
     * @param  string $html
     * @return string
     */
    public function parse($html);
}
