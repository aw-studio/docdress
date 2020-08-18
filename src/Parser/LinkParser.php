<?php

namespace Docdress\Parser;

use Illuminate\Support\Str;

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
                $replace = route(request()->route()->getName(), [
                    'version' => request()->route('version'),
                    'page'    => $link,
                ]);
            }

            $text = str_replace($link, $replace, $text);
        }

        return $text;
    }
}
