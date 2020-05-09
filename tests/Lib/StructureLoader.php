<?php

namespace RainLab\Pages\Tests\Lib;

use HtmlSerializer\Html;
use RainLab\Pages\Renderer\Renderer;

class StructureLoader {

    public $currentSection;
    
    public static function __callStatic($method, $params) {
        $self = new static();

        return $self->{'t_'.$method}($params);
    }

    public function defaultSidebar() {
        return (object) ['meta' => (object) ['position' => false], 'modules' => []];
    }

    public function sectionMeta($section = []) {
        return (object) array_merge([ 'title' => 'Sektion', 'background' => '', 'color' => NULL, 'type' => 'section', 'transparent' => '0', 'container' => true, 'paddingY' => true ], $section);
    }

    public function section($meta) {
        $this->currentSection = (object) [
            'sidebar' => $this->defaultSidebar(),
            'meta' => $this->sectionMeta($meta),
            'rows' => [
                (object) [
                    'meta' => (object) ['title' => 'Zeile'],
                    'columns' => []
                ]
            ]
        ];

        return $this;
    }

    public function sidebar($position) {
        $this->currentSection->sidebar->meta->position = $position;

        return $this;
    }

    public function paragraph($content, $meta = []) {
        $meta = array_merge(['title' => 'Absatz', 'content' => $content, 'textAlign' => 'left', 'textSize' => 'base'], $meta);

        $this->currentSection->rows[0]->columns[] = (object) [
            'width' => 'full',
            'modules' => [
                (object) [
                    'is' => (object) ['type' => 'module', 'component' => 'paragraph', 'icon' => 'paragraph'],
                    'meta' => (object) $meta,
                ],
            ]
        ];

        return $this;
    }

    public function output() {
        $s = (object) ['sections' => [
            $this->currentSection
        ], 'placeholders' => (object) [
            'header' => []
        ]];
        return app(Renderer::class)->render($s, []);
    }

    public function toJson() {
        return json_decode((new Html($this->output()))->toJson(), true);
    }

}
