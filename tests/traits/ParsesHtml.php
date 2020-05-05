<?php

namespace Rainlab\Pages\Tests\Traits;

use HtmlSerializer\Html;

trait ParsesHtml {
    
    public function assertHtmlText($html, $markup) {
        $json = json_decode((new Html($markup))->toJson());

        $this->eachNodeContents($json, $html);
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
