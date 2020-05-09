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
        $this->assertSectionTag('div', ['class' => 'container py-20'], $this->render('aaabbb'));
    }

    /** @test */
    public function it_doesnt_include_padding_y_when_setting_is_false_on_normal_sections()
    {
        $this->assertSectionTag('div', ['class' => 'container'], $this->render('aaabbb', ['paddingY' => false]));
    }

    /** @test */
    public function it_doesnt_include_padding_y_when_setting_is_false_on_fullwidth_sections()
    {
        $this->assertSectionTag('div', ['class' => 'relative'], $this->render('aaabbb', ['paddingY' => false, 'type' => 'fullwidth']));
        $this->assertSubsectionTag('div', ['class' => 'relative container'], $this->render('aaabbb', ['paddingY' => false, 'type' => 'fullwidth']));
    }

    /** @test */
    public function it_doesnt_include_containeer_when_container_is_false_on_fullwidth_sections()
    {
        $this->assertSectionTag('div', ['class' => 'relative'], $this->render('aaabbb', ['paddingY' => false, 'type' => 'fullwidth', 'container' => false]));
        $this->assertSubsectionTag('div', ['class' => 'relative'], $this->render('aaabbb', ['paddingY' => false, 'type' => 'fullwidth', 'container' => false]));
    }



    protected function render($text, $attrs = []) {
        return app(Renderer::class)->render($this->section($text, $attrs), []);
    }
}
