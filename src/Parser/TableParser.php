<?php

namespace Docdress\Parser;

class TableParser implements HtmlParserInterface
{
    /**
     * Parse html.
     *
     * @param  string $text
     * @return string
     */
    public function parse($text)
    {
        // Adding "dd-table" calss to all table's without a class to allow
        // custom tables without a styling by adding a class to a table.
        return str_replace('<table>', '<table class="dd-table">', $text);
    }
}
