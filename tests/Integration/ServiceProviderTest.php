<?php

namespace Tests\Integration;

use Illuminate\Support\Facades\Blade;

class ServiceProviderTest extends IntegrationTestCase
{
    /** @test */
    public function test_search_input_component_is_registered()
    {
        $aliases = Blade::getClassComponentAliases();

        $this->assertArrayHasKey('dd-search-input', $aliases);
    }
}
