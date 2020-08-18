<?php

namespace Docdress\Parser;

class LinkParser implements HtmlParserInterface
{
    /**
     * Parse html.
     *
     * @param  string $text
     * @return string
     */
    public function parse($text)
    {
        preg_match_all('/(?<=\bhref=")[^"]*/', $text, $matches);

        foreach ($matches[0] as $link) {
            if (Str::startsWith($link, '#')) {
                continue;
            }

            if (array_key_exists('host', parse_url($link))) {
                $replace = "{$link}\" target=\"_blank";
            } else {
                $split = explode('/', request()->getPathInfo());
                array_pop($split);

                $replace = str_replace('.md', '', '/'.trim(implode('/', $split).'/'.$link, '/'));
            }

            $text = str_replace($link, $replace, $text);
        }

        return $text;
    }
}
