<?php

namespace Rainlab\Pages\Tests\Unit\Renderer;

use PluginTestCase;
use RainLab\Pages\Renderer\Renderer;
use Rainlab\Pages\Tests\Traits\ParsesHtml;
use Rainlab\Pages\Tests\Traits\GeneratesModule;

class ParagraphTest extends PluginTestCase
{

    use ParsesHtml;
    use GeneratesModule;

    /** @test */
    public function it_parses_a_normal_html_text()
    {
        $this->assertContents('aaabbb', 'aaabbb');
    }

    /** @test */
    public function it_parses_a_markdown_line_break_as_html_br()
    {
        $this->assertContents('aaabbb', 'aaabbb');
        $this->assertContents('aaa bbb', "aaa bbb");
        $this->assertContains("aaa<br />\nbbb", $this->render("aaa  \nbbb"));
    }

    /** @test */
    public function it_parses_the_size_of_a_text() {
        $this->assertContains('<p class="c text-left text-lg">aa</p>', $this->render('aa', ['textSize' => 'lg']));
    }

    /** @test */
    public function it_parses_the_align_of_a_text() {
        $this->assertContains('<p class="c text-right text-base">aa</p>', $this->render('aa', ['textAlign' => 'right']));
    }

    /** @test */
    public function it_parses_bold_and_italic_text() {
        $this->assertContains('aa<strong>c</strong>', $this->render('aa__c__'));
        $this->assertContains('aa<em>c</em>', $this->render('aa_c_'));
    }

    protected function assertContents($expected, $existing) {
        $this->assertHtmlText($expected, $this->render($expected));
    }

    protected function render($text, $attrs = []) {
        return app(Renderer::class)->render($this->normalParagraph($text, $attrs), []);
    }
}
