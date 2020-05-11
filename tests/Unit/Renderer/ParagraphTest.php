<?php

namespace Rainlab\Pages\Tests\Unit\Renderer;

use TestCase;
use RainLab\Pages\Renderer\Renderer;
use RainLab\Pages\Tests\Lib\Structure;
use Rainlab\Pages\Tests\Traits\GeneratesModule;

class ParagraphTest extends TestCase
{

    use GeneratesModule;

    /** @test */
    public function it_parses_a_normal_html_text()
    {
        $this->assertHtml('div', '0.children.0.children.0.children.0.children.0.node', $this->render('aaabbb'));
        $this->assertHtml(['node' => 'p', 'children' => [
            ['node' => 'text', 'text' => 'aaabbb']
        ]], '0.children.0.children.0.children.0.children.0.children.0', $this->render('aaabbb'));
    }

    /** @test */
    public function it_parses_a_markdown_line_break_as_html_br()
    {
        $this->assertHtml(['node' => 'p', 'children' => [
            ['node' => 'text', 'text' => 'aaa bbb']
        ]], '0.children.0.children.0.children.0.children.0.children.0', $this->render('aaa bbb'));
        $this->assertHtml(['node' => 'p', 'children' => [
            ['node' => 'text', 'text' => 'aaa'],
            ['node' => 'br'],
            ['node' => 'text', 'text' => "\nbbb"],
        ]], '0.children.0.children.0.children.0.children.0.children.0', $this->render("aaa  \nbbb"));
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
        $this->assertHtml(['node' => 'p', 'children' => [
            [ 'node' => 'text', 'text' => 'aa' ],
            [ 'node' => 'strong', 'children' => [
                ['node' => 'text', 'text' => 'c']
            ]]
        ]], '0.children.0.children.0.children.0.children.0.children.0', $this->render("aa__c__"));

        $this->assertHtml(['node' => 'p', 'children' => [
            [ 'node' => 'text', 'text' => 'aa' ],
            [ 'node' => 'em', 'children' => [
                ['node' => 'text', 'text' => 'c']
            ]]
        ]], '0.children.0.children.0.children.0.children.0.children.0', $this->render("aa_c_"));
    }

    /** @test */
    public function it_parses_uls() {
        $this->assertHtml([
            ['node' => 'p', 'children' => [ [ 'node' => 'text', 'text' => 'aa' ] ]],
            ['node' => 'ul', 'children' => [ [ 'node' => 'li', 'children' => [['node' => 'text', 'text' => 'b']]], [ 'node' => 'li', 'children' => [['node' => 'text', 'text' => 'c' ]]] ]]
        ], '0.children.0.children.0.children.0.children.0.children', $this->render("aa\n\n* b\n* c"));
    }

    protected function render($text, $attrs = []) {
        return Structure::section([])
            ->module('paragraph', array_merge(['content' => $text], $attrs));
    }
}
