<?php

namespace Rainlab\Pages\Tests\Unit\Renderer;

use HtmlSerializer\Html;
use PluginTestCase;
use RainLab\Pages\Renderer\Renderer;
use RainLab\Pages\Tests\Lib\Structure;
use Rainlab\Pages\Tests\Traits\GeneratesModule;

class SidebarTest extends PluginTestCase
{

    use GeneratesModule;

    /** @test */
    public function it_parses_a_left_sidebar_with_one_module()
    {
        $this->assertHtml('container flex py-20', '0.attributes.class', $this->render('aaabbb', 'left'));
        $this->assertHtml('pr-10 w-1/4 flex-none', '0.children.0.attributes.class', $this->render('aaabbb', 'left'));
    }

    /** @test */
    public function it_parses_a_right_sidebar_with_one_module()
    {
        $this->assertHtml('container flex py-20', '0.attributes.class', $this->render('aaabbb', 'right'));
        $this->assertHtml('pl-10 w-1/4 flex-none', '0.children.1.attributes.class', $this->render('aaabbb', 'right'));
    }

    /** @test */
    public function it_parses_a_module_in_the_sidebar()
    {
        $this->assertHtml('container flex py-20', '0.attributes.class', $this->render('aaabbb', 'left', function($structure) {
            $structure->ankerlist();
        }));
    }


    protected function render($text, $position, $modules = null) {
        $modules = $modules ?? function($structure) {};

        return Structure::section([])
            ->sidebar($position, $modules)
            ->paragraph($text);
    }
}
