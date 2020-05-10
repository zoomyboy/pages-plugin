<?php

namespace RainLab\Pages\Tests\Lib;

use HtmlSerializer\Html;
use RainLab\Pages\Renderer\Renderer;

class StructureLoader {

    public $currentSection;

    public static $moduleMeta = [
        'heading' => ['content' => 'hello', 'tag' => 'h2', 'title' => 'Überschrift'],
        'paragraph' => ['textAlign' => 'left', 'textSize' => 'base', 'content' => 'hello'],
    ];
    
    public static function __callStatic($method, $params) {
        $self = new static();

        return $self->{'t_'.$method}($params);
    }

    public function defaultSidebar() {
        return (object) ['meta' => (object) ['position' => false], 'modules' => []];
    }

    public function sectionMeta($section = []) {
        return (object) array_merge([ 'title' => 'Sektion', 'background' => '', 'color' => NULL, 'type' => 'sectionNormal', 'transparent' => '0', 'container' => true, 'paddingY' => true ], $section);
    }

    public function section($meta) {
        $this->currentSection = (object) [
            'sidebar' => $this->defaultSidebar(),
            'meta' => $this->sectionMeta($meta),
            'rows' => [
                (object) [
                    'meta' => (object) ['title' => 'Zeile', 'anchor' => '0'],
                    'columns' => []
                ]
            ]
        ];

        return $this;
    }

    public function withRow($meta = []) {
        $this->currentSection->rows[0]->meta = (object) array_merge((array) $this->currentSection->rows[0]->meta, $meta);

        return $this;
    }
        

    public function sidebar($position, $modules) {
        $this->currentSection->sidebar->meta->position = $position;

        $sidebarModuleLoader = Structure::section([]);
        call_user_func($modules, $sidebarModuleLoader);

        if(count($sidebarModuleLoader->currentSection->rows[0]->columns)) {
            $this->currentSection->sidebar->modules = $sidebarModuleLoader->currentSection->rows[0]->columns[0]->modules;
        }

        return $this;
    }

    public function ankerlist($meta = []) {
        $meta = array_merge(['title' => 'Direkt zu'], $meta);

        $this->currentSection->rows[0]->columns[] = (object) [
            'width' => 'full',
            'modules' => [
                (object) [
                    'is' => (object) ['type' => 'sidebar', 'component' => 'ankerlist', 'icon' => 'anchor'],
                    'meta' => (object) $meta,
                ],
            ]
        ];
    }

    public function appendModule($module) {
        if (empty($this->currentSection->rows[0]->columns)) {
            $this->currentSection->rows[0]->columns[] = (object) [ 'width' => 'full', 'modules' => [ $module ]];
        } else {
            $this->currentSection->rows[0]->columns[0]->modules[] = $module;
        }
        
        return $this;
    }

    public function module($component, $meta = []) {
        return $this->appendModule((object) [
            'is' => (object) ['type' => 'module', 'component' => $component, 'icon' => 'paragraph'],
            'meta' => (object) array_merge(static::$moduleMeta[$component], $meta),
        ]);
    }

    public function component($className, $params = []) {
        $component = snake_case(class_basename($className));
        return $this->appendModule((object) [
            'is' => (object) ['type' => 'component', 'component' => $component, 'icon' => 'paragraph'],
            'meta' => (object) array_merge(['title' => 'component'], $params)
        ]);
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
