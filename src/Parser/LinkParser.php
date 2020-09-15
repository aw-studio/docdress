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
                $text = str_replace("href=\"{$link}\"", 'href="'.$link.'" data-turbolinks="false"', $text);

                continue;
            }

            $text = str_replace($link, $this->modifyLink($link), $text);
        }

        return $text;
    }

    /**
     * Get modified link.
     *
     * @param  string $link
     * @return string
     */
    protected function modifyLink($link)
    {
        if (array_key_exists('host', parse_url($link))) {
            if (! $this->isExternal($link)) {
                return $link;
            }

            return  "{$link}\" target=\"_blank";
        }
        $modified = route(request()->route()->getName(), [
            'version' => request()->route('version') ?: 'master',
            'page'    => $this->parseInternalLink($link),
        ]);

        $modified .= '" data-turbolinks-action="replace';

        return $modified;
    }

    /**
     * Determines if link is external.
     *
     * @param  string $link
     * @return bool
     */
    protected function isExternal($link)
    {
        return parse_url(url(''))['host'] != parse_url($link)['host'];
    }

    /**
     * Parse internal link.
     *
     * @param  string $link
     * @return string
     */
    protected function parseInternalLink($link)
    {
        $url = ltrim(preg_replace('#/+#', '/', $link), '/');

        if (! is_null(request()->route('sub_page')) && ! Str::contains($url, '/')) {
            $url = request()->route('page').'/'.$url;
        }

        $url = str_replace(['.md', '../'], '', $url);

        return $url;
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
