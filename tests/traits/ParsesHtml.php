<?php

namespace Rainlab\Pages\Tests\Traits;

use HtmlSerializer\Html;

trait ParsesHtml {
    
    public function assertHtmlText($html, $markup) {
        $json = json_decode((new Html($markup))->toJson());

        $this->eachNodeContents($json, $html);
    }

    public function assertSectionTag($tag, $attrs, $markup, $sectionIndex = 0) {
        $json = json_decode((new Html($markup))->toJson());
        $sectionTag = $json[$sectionIndex];
        $this->assertEquals($tag, $sectionTag->node, 'Failed asserting that Section is of type "<'.$tag.'>". Found tag "<'.$sectionTag->node.'>"');
        $this->assertEquals((object) $attrs, $sectionTag->attributes);
    }

    public function assertSubsectionTag($tag, $attrs, $markup, $sectionIndex = 0) {
        $json = json_decode((new Html($markup))->toJson());
        $sectionTag = $json[$sectionIndex]->children[0];
        $this->assertEquals($tag, $sectionTag->node, 'Failed asserting that Subtag of Section is of type "<'.$tag.'>". Found tag "<'.$sectionTag->node.'>"');
        $this->assertEquals((object) $attrs, $sectionTag->attributes);
    }

    protected function eachNodeContents($node, $html) {
        foreach ($node as $child) {
            if (is_null($child->text ?? null) && isset($child->children)) {
                return $this->eachNodeContents($child->children, $html);
            }

            return $this->assertEquals($html, $child->text);
        }
    }

}
