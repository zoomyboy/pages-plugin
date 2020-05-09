<?php

namespace Rainlab\Pages\Tests\Unit\Renderer;

use PluginTestCase;
use RainLab\Pages\Renderer\Renderer;
use RainLab\Pages\Tests\Lib\Structure;
use Rainlab\Pages\Tests\Traits\GeneratesModule;

class ParagraphTest extends PluginTestCase
{

    use GeneratesModule;

    /** @test */
    public function it_parses_a_normal_html_text()
    {
        $this->assertHtml('aaabbb', '0.children.0.children.0.children.0.children.0.children.0.text', $this->render('aaabbb'));
    }

    /** @test */
    public function it_parses_a_markdown_line_break_as_html_br()
    {
        $this->assertHtml('aaa bbb', '0.children.0.children.0.children.0.children.0.children.0.text', $this->render('aaa bbb'));
        $this->assertHtml("aaa", '0.children.0.children.0.children.0.children.0.children.0.text', $this->render("aaa  \nbbb"));
        $this->assertHtml("br", '0.children.0.children.0.children.0.children.0.children.1.node', $this->render("aaa  \nbbb"));
        $this->assertHtml("\nbbb", '0.children.0.children.0.children.0.children.0.children.2.text', $this->render("aaa  \nbbb"));
    }

    /** @test */
    public function it_parses_the_size_of_a_text() {
        $this->assertHtml('c text-left text-lg', '0.children.0.children.0.children.0.children.0.attributes.class', $this->render('aaa', ['textSize' => 'lg']));
    }

    /** @test */
    public function it_parses_the_align_of_a_text() {
        $this->assertHtml('c text-right text-base', '0.children.0.children.0.children.0.children.0.attributes.class', $this->render('aaa', ['textAlign' => 'right']));
    }

    /** @test */
    public function it_parses_bold_and_italic_text() {
        $this->assertHtml([
            [ 'node' => 'text', 'text' => 'aa' ],
            [ 'node' => 'strong', 'children' => [
                ['node' => 'text', 'text' => 'c']
            ]]
        ], '0.children.0.children.0.children.0.children.0.children', $this->render("aa__c__"));

        $this->assertHtml([
            [ 'node' => 'text', 'text' => 'aa' ],
            [ 'node' => 'em', 'children' => [
                ['node' => 'text', 'text' => 'c']
            ]]
        ], '0.children.0.children.0.children.0.children.0.children', $this->render("aa_c_"));
    }

    protected function render($text, $attrs = []) {
        return Structure::section([])
            ->paragraph($text, $attrs);
    }
}
