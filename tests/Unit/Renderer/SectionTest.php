<?php

namespace RainLab\Pages\Tests\Unit\Renderer;

use HtmlSerializer\Html;
use TestCase;
use RainLab\Pages\Tests\Lib\Structure;
use Rainlab\Pages\Tests\Traits\GeneratesModule;

class SectionTest extends TestCase
{

    use GeneratesModule;

    /** @test */
    public function it_parses_a_normal_single_section_with_a_single_module()
    {
        $this->assertHtml('container py-20', '0.attributes.class', $this->render('aaabbb'));
    }

    /** @test */
    public function it_doesnt_include_padding_y_when_setting_is_false_on_normal_sections()
    {
        $this->assertHtml('container', '0.attributes.class', $this->render('aaabbb', ['paddingY' => false]));
    }

    /** @test */
    public function it_doesnt_include_padding_y_when_setting_is_false_on_fullwidth_sections()
    {
        $this->assertHtml('relative', '0.attributes.class', $this->render('aaabbb', ['paddingY' => false, 'type' => 'sectionFullwidth']));
        $this->assertHtml('relative container', '0.children.0.attributes.class', $this->render('aaabbb', ['paddingY' => false, 'type' => 'sectionFullwidth']));
    }

    /** @test */
    public function it_doesnt_include_containeer_when_container_is_false_on_fullwidth_sections()
    {
        $this->assertHtml('relative', '0.attributes.class', $this->render('aaabbb', ['paddingY' => false, 'type' => 'sectionFullwidth', 'container' => false]));
        $this->assertHtml('relative', '0.children.0.attributes.class', $this->render('aaabbb', ['paddingY' => false, 'type' => 'sectionFullwidth', 'container' => false]));
    }


    protected function render($text, $attrs = []) {
        return Structure::section($attrs)
            ->module('paragraph', ['content' => $text]);
    }
}
