<?php

namespace Docdress\Parser;

class CodeParser implements HtmlParserInterface
{
    /**
     * Parse the given markup.
     *
     * @param  string $html
     * @return string
     */
    public function parse($html)
    {
        return str_replace('<code>', '<code class="language-php">', $html);
    }
}
