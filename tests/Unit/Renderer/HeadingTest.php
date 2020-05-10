<?php

namespace Rainlab\Pages\Tests\Unit\Renderer;

use TestCase;
use RainLab\Pages\Renderer\Renderer;
use RainLab\Pages\Tests\Lib\Structure;
use Rainlab\Pages\Tests\Traits\GeneratesModule;

class HeadingTest extends TestCase
{

    use GeneratesModule;

    /** @test */
    public function it_parses_a_normal_html_text()
    {
        $loader = Structure::section([])
            ->module('heading');

        $this->assertHtml([
            'node' => 'h2',
            'attributes' => [ 'class' => 'c' ],
            'children' => [ ['node' => 'text', 'text' => 'hello'] ]
        ], '0.children.0.children.0.children.0.children.0', $loader);
    }

    /** @test */
    public function it_parses_a_paragraph_after_a_heading_and_the_paragraph_has_no_margin_top()
    {
        $loader = Structure::section([])
            ->module('heading')
            ->module('paragraph');

        $this->assertHtml([
            'node' => 'h2',
            'attributes' => [ 'class' => 'c' ],
            'children' => [ ['node' => 'text', 'text' => 'hello'] ]
        ], '0.children.0.children.0.children.0.children.0', $loader);

        $this->assertHtml('', '0.children.0.children.0.children.1.attributes.class', $loader);
    }

    /** @test */
    public function it_parses_a_paragraph_after_a_heading_in_a_fullwidth_section_and_the_paragraph_has_a_margin_top()
    {
        $loader = Structure::section(['type' => 'fullwidth'])
            ->module('heading')
            ->module('paragraph');

        $this->assertHtml('mt-6', '0.children.0.children.0.children.0.children.1.attributes.class', $loader);
    }

}
