<?php

namespace Docdress\Parser;

use Docdress\Parser;
use Illuminate\Support\Str;

class AlertParser implements MarkdownParserInterface
{
    /**
     * Parse the given markup.
     *
     * @param  string $markup
     * @return string
     */
    public function parse($markup)
    {
        preg_match_all('/:::(?s)(.*?):::/', $markup, $match);

        foreach ($match[1] as $key => $block) {
            $split = explode("\n", $block);
            $name = trim(array_shift($split));
            $content = (new Parser)->text(implode("\n", $split));
            $markup = Str::replaceFirst($match[0][$key], "<div class=\"alert alert-{$name}\">{$content}</div>", $markup);
        }

        return $markup;
    }
}
