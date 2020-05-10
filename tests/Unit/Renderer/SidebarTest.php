<?php

namespace Rainlab\Pages\Tests\Unit\Renderer;

use HtmlSerializer\Html;
use RainLab\Pages\Renderer\Renderer;
use RainLab\Pages\Tests\Lib\Structure;
use Rainlab\Pages\Tests\Traits\GeneratesModule;
use TestCase;

class SidebarTest extends TestCase
{

    use GeneratesModule;

    /** @test */
    public function it_parses_a_left_sidebar_with_one_module()
    {
        $this->assertHtml('container flex py-20', '0.attributes.class', $this->render('aaabbb', 'left'));
        $this->assertHtml('pr-10 w-1/4 flex-none', '0.children.0.attributes.class', $this->render('aaabbb', 'left'));
        $this->assertHtml('sticky top-10', '0.children.0.children.0.attributes.class', $this->render('aaabbb', 'left'));
    }

    /** @test */
    public function it_parses_a_right_sidebar_with_one_module()
    {
        $this->assertHtml('container flex py-20', '0.attributes.class', $this->render('aaabbb', 'right'));
        $this->assertHtml('pl-10 w-1/4 flex-none', '0.children.1.attributes.class', $this->render('aaabbb', 'right'));
    }

    /** @test */
    public function it_has_a_shadow_and_a_background()
    {
        $this->assertHtml('bg-white shadow-lg p-3', '0.children.0.children.0.children.0.attributes.class', $this->renderWithModule());
    }


    protected function render($text, $position, $modules = null) {
        $modules = $modules ?? function($structure) {};

        return Structure::section([])
            ->sidebar($position, $modules)
            ->module('paragraph', ['content' => $text]);
    }

    protected function renderWithModule() {
        return $this->render('aaabbb', 'left', function($structure) {
            $structure->ankerlist();
        });
    }
}
