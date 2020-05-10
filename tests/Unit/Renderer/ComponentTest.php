<?php

namespace RainLab\Pages\Tests\Unit\Renderer;

use HtmlSerializer\Html;
use TestCase;
use RainLab\Pages\Tests\Lib\Structure;
use Rainlab\Pages\Tests\Traits\GeneratesModule;
use RainLab\Pages\Tests\Stub\Components\NoProperties;

class ComponentTest extends TestCase
{

    use GeneratesModule;

    /** @test */
    public function it_parses_an_example_component()
    {
        $loader = Structure::section([])
            ->component(NoProperties::class);

        $this->assertHtml([
            'node' => 'figure',
            'attributes' => [ 'data-component' => 'no_properties', 'data-title' => 'component' ]
        ], '0.children.0.children.0.children.0.children.0', $loader);
    }

    /** @test */
    public function it_parses_an_example_component_after_a_heading_in_a_normal_section()
    {
        $loader = Structure::section([])
            ->module('heading')
            ->component(NoProperties::class);

        $this->assertHtml([
            'node' => 'h2',
            'attributes' => [ 'class' => 'c' ],
            'children' => [ ['node' => 'text', 'text' => 'hello'] ]
        ], '0.children.0.children.0.children.0.children.0', $loader);
    }

    /** @test */
    public function it_parses_an_example_component_after_a_heading_in_a_fullwidth_section()
    {
        $loader = Structure::section(['type' => 'fullwidth'])
            ->module('heading')
            ->component(NoProperties::class);

        $this->assertHtml('mt-6', '0.children.0.children.0.children.0.children.1.attributes.class', $loader);
    }

}
