<?php

namespace Docdress\Parser;

use Illuminate\Support\Str;

class SrcParser implements HtmlParserInterface
{
    /**
     * Parse html.
     *
     * @param  string $text
     * @return string
     */
    public function parse($text)
    {
        $matches = $this->getSrcOutsideOfCodeBlocks($text);

        foreach ($matches[0] as $link) {
            if (Str::startsWith($link, '#')) {
                continue;
            }

            if (Str::startsWith($link, '/')) {
                continue;
            }

            if (array_key_exists('host', parse_url($link))) {
                $replace = "{$link}";
            } else {
                $path = explode('/', request()->getPathInfo());
                array_pop($path);
                $replace = '/storage'.implode('/', $path).'/'.Str::replaceFirst('./', '', $link);
            }

            $text = str_replace($link, $replace, $text);
        }

        return $text;
    }

    /**
     * Get links outside of code blocks.
     *
     * @param  string $text
     * @return array
     */
    protected function getSrcOutsideOfCodeBlocks($text)
    {
        preg_match_all('#<\s*?code\b[^>]*>(.*?)</code\b[^>]*>#s', $text, $matches);

        foreach ($matches[0] as $match) {
            $text = str_replace($match, '', $text);
        }

        preg_match_all('/(?<=\bsrc=")[^"]*/', $text, $matches);

        return $matches;
    }
}
