<?php

namespace Rainlab\Pages\Tests\Unit\Renderer;

use HtmlSerializer\Html;
use TestCase;
use RainLab\Pages\Renderer\Renderer;
use RainLab\Pages\Tests\Lib\Structure;
use Rainlab\Pages\Tests\Traits\GeneratesModule;

class AnkerlistText extends TestCase
{

    use GeneratesModule;

    /** @test */
    public function it_parses_the_title_of_the_ankerlist()
    {
        $this->assertHtml(['node' => 'text', 'text' => 'Direkt zu'], '0.children.0.children.0.children.0.children.0.children.0', $this->renderEmpty());
    }

    /** @test */
    public function it_parses_an_empty_ankerlist()
    {
        $this->assertHtml('nav', '0.children.0.children.0.children.0.children.1.children.0.node', $this->renderEmpty());
        $this->assertHtml(null, '0.children.0.children.0.children.0.children.1.children.0.children', $this->renderEmpty());
    }

    /** @test */
    public function it_parses_the_links_in_the_ankerlist()
    {
        $this->assertHtml('#example', '0.children.0.children.0.children.0.children.1.children.0.children.0.attributes.href', $this->renderOne());
        $this->assertHtml('example', '0.attributes.id', $this->renderOne());
    }

    /** @test */
    public function it_parses_the_links_in_the_ankerlist_on_a_fullwidth_section()
    {
        $this->assertHtml('#example', '0.children.0.children.0.children.0.children.0.children.1.children.0.children.0.attributes.href', $this->renderOneFullwidth());
        $this->assertHtml('example', '0.attributes.id', $this->renderOneFullwidth());
    }

    /** @test */
    public function it_parses_a_link_with_space_in_it()
    {
        $this->assertHtml('#example-t', '0.children.0.children.0.children.0.children.1.children.0.children.0.attributes.href', $this->renderOne('example t'));
        $this->assertHtml('example-t', '0.attributes.id', $this->renderOne('example t'));
    }

    protected function renderEmpty() {
        return Structure::section([])
            ->sidebar('left', function($structure) {
                $structure->ankerlist();
            })
            ->module('paragraph');
    }

    protected function renderOne($linkName = 'example') {
        return Structure::section([])
            ->withRow(['anchor' => '1', 'title' => $linkName])
            ->sidebar('left', function($structure) {
                $structure->ankerlist();
            })
            ->module('paragraph');
    }

    protected function renderOneFullwidth($linkName = 'example') {
        return Structure::section(['type' => 'sectionFullwidth'])
            ->withRow(['anchor' => '1', 'title' => $linkName])
            ->sidebar('left', function($structure) {
                $structure->ankerlist();
            })
            ->module('paragraph');
    }
}
