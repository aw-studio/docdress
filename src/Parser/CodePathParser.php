<?php

namespace Docdress\Parser;

use Illuminate\Support\Str;

class CodePathParser implements HtmlParserInterface
{
    /**
     * Parse markup.
     *
     * @param  string $text
     * @return string
     */
    public function parse($markup)
    {
        preg_match_all('/code class=\"([^"]*)\"/', $markup, $matches);

        $matches = collect()
            ->concat($matches[1])
            ->mapWithKeys(function ($class, $key) use ($matches) {
                preg_match('/\{(.*?)\}/', $class, $match);

                if (empty($match)) {
                    return [];
                }

                return [$matches[0][$key] => $match[1]];
            })->filter();

        foreach ($matches as $raw => $path) {
            $replace = "{$raw} dd-path=\"{$path}\"";

            $markup = Str::replaceFirst($raw, $replace, $markup);
        }

        return $markup;
    }
}
