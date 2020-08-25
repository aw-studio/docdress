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
        $matches = $this->getLinksOutsideOfCodeBlocks($text);

        foreach ($matches[0] as $link) {
            if (Str::startsWith($link, '#')) {
                continue;
            }

            if (array_key_exists('host', parse_url($link))) {
                $replace = $link;

                if (config('docdress.open_external_links_in_new_tab')) {
                    $replace .= '" target="_blank';
                }
            } else {
                $replace = route(request()->route()->getName(), [
                    'version' => request()->route('version'),
                    'page'    => ltrim(preg_replace('#/+#', '/', $link), '/'),
                ]);

                $replace .= '" data-turbolinks-action="replace';
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
    protected function getLinksOutsideOfCodeBlocks($text)
    {
        preg_match_all('#<\s*?code\b[^>]*>(.*?)</code\b[^>]*>#s', $text, $matches);

        foreach ($matches[0] as $match) {
            $text = str_replace($match, '', $text);
        }

        preg_match_all('/(?<=\bhref=")[^"]*/', $text, $matches);

        return $matches;
    }
}
