<?php

namespace Docdress;

use ParsedownExtra;

class Parser extends ParsedownExtra
{
    protected $parser = [];

    /**
     * Parse markdown to html.
     *
     * @param  string $text
     * @return string
     */
    public function parse($text, $parser = [])
    {
        if (empty($parser)) {
            $parser = $this->parser;
        }

        $parser = collect($parser)->map(fn ($class) => app($class));

        $text = $this->runThroughParser(
            $text, $parser->filter(
                fn ($instance) => $instance instanceof MarkdownParserInterface
            )
        );

        $text = $this->text($text);

        return $this->runThroughParser(
            $text, $text, $parser->filter(
                fn ($instance) => $instance instanceof HtmlParserInterface
            )
        );
    }

    /**
     * Run through parser.
     *
     * @param  string $text
     * @param         $parser
     * @return void
     */
    protected function runThroughParser($text, $parser)
    {
        foreach ($parser as $instance) {
            $text = $instance->parse($text);
        }

        return $text;
    }

    /**
     * Add parser class.
     *
     * @param  string $parser
     * @return $this
     */
    protected function parser(string $parser)
    {
        $this->parser[] = $parser;

        return $this;
    }
}
