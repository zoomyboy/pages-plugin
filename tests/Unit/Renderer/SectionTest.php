<?php

namespace Rainlab\Pages\Tests\Unit\Renderer;

use HtmlSerializer\Html;
use PluginTestCase;
use RainLab\Pages\Renderer\Renderer;
use Rainlab\Pages\Tests\Traits\ParsesHtml;
use Rainlab\Pages\Tests\Traits\GeneratesModule;

class SectionTest extends PluginTestCase
{

    use ParsesHtml;
    use GeneratesModule;

    /** @test */
    public function it_parses_a_normal_single_section_with_a_single_module()
    {
        $this->assertSectionTag('div', ['class' => 'container  py-20'], $this->render('aaabbb'));
    }

    protected function render($text, $attrs = []) {
        return app(Renderer::class)->render($this->section($text, $attrs), []);
    }
}
