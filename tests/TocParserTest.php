<?php

namespace Tests;

use Docdress\Parser\TocParser;
use PHPUnit\Framework\TestCase;

class TocParserTest extends TestCase
{
    /** @test */
    public function it_places_toc_below_first_header()
    {
        $result = (new TocParser)->parse('# Header
## Foo
### Bar
## Baz
');
        $this->assertSame('# Header

- [Foo](#foo)
    - [Bar](#bar)
- [Baz](#baz)
<a name="foo"></a>
## <a href="#foo">Foo</a>
<a name="bar"></a>
### <a href="#bar">Bar</a>
<a name="baz"></a>
## <a href="#baz">Baz</a>
', $result);
    }

    /** @test */
    public function it_doesnt_show_fourth_or_lower_headers()
    {
        $result = (new TocParser)->parse('# Header
#### Foo
##### Bar
');
        $this->assertSame('# Header
#### Foo
##### Bar
', $result);
    }

    /** @test */
    public function it_places_toc_only_below_first_header()
    {
        $result = (new TocParser)->parse('# Header
## Foo
```shell
# hello world
```
');
        $this->assertSame('# Header

- [Foo](#foo)
<a name="foo"></a>
## <a href="#foo">Foo</a>
```shell
# hello world
```
', $result);
    }
}
