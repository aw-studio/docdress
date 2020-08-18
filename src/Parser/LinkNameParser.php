<?php

namespace Docdress\Parser;

use Illuminate\Support\Str;

class LinkNameParser implements HtmlParserInterface
{
    /**
     * Parse html.
     *
     * @param  string $text
     * @return string
     */
    public function parse($text)
    {
        $lines = explode("\n", $text);
        foreach ($lines as $number => $line) {
            preg_match('/<a name="(.+)">/', $line, $matches);

            if (isset($matches[1])) {
                $name = $matches[1];

                if (isset($lines[$number + 1]) && Str::startsWith($lines[$number + 1], '<h')) {
                    $header = substr_replace($lines[$number + 1], sprintf(' id="%s"', $name), 3, 0);
                    $lines[$number + 1] = $header;
                }
            }
        }

        return implode("\n", $lines);
    }
}
