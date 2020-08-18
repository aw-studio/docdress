<?php

namespace Docdress\Parser;

use Illuminate\Support\Str;

class TocParser implements MarkdownParserInterface
{
    /**
     * Parse the given markup.
     *
     * @param  string $markup
     * @return string
     */
    public function parse($markup)
    {
        $toc = [];

        $headings = $this->matchHeadings($markup);

        foreach ($headings[1] as $key => $heading) {
            $slug = Str::slug($heading);

            $replace = "<a name=\"{$slug}\"></a>\n"
                .str_replace(
                    $heading,
                    '<a href="#'.$slug.'">'.$heading."</a>\n",
                    $headings[0][$key]
                );

            $markup = str_replace($headings[0][$key]."\n", $replace, $markup);

            $link = '['.trim($heading)."](#{$slug})";

            if (Str::startsWith($headings[0][$key], '###')) {
                $toc[] = "    - {$link}";
            } else {
                $toc[] = "- {$link}";
            }
        }

        return preg_replace('/(?m)^#{1}(?!#)(.*)/', "$0\n\n".implode("\n", $toc), $markup);
    }

    /**
     * Match headings in markup.
     *
     * @param  string $markup
     * @return array
     */
    protected function matchHeadings($markup)
    {
        preg_match_all('/(?m)^#{2,3}(?!#)(.*)/', $markup, $matches);

        return $matches;
    }
}
