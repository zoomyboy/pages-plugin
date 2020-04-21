<?php

namespace RainLab\Pages\Presenters;

use RainLab\Pages\Renderer\PresenterFactory;

class SectionPresenter implements \Countable {

    use HasEnv;

    private $section;
    private $index;
    private $markup;

    public function __construct($section, $index, $markup) {
        $this->section = $section;
        $this->index = $index;
        $this->markup = $markup;
    }

    public function count() {
        return count($this->markup->sections);
    }

    public function openTag() {
        $method = $this->section->meta->type.'OpenTag';
        return $this->{$method}();
    }

    public function closingTag() {
        $method = $this->section->meta->type.'ClosingTag';
        return $this->{$method}();
    }

    public function fullwidthOpenTag() {
        $style = [];
        $beforeContainer = '';
        
        if ($this->section->meta->background) {
            $style['background-image'] = 'url(/storage/app/media'.$this->section->meta->background.')';
            $style['background-size'] = 'cover';
            $style['background-position'] = 'bottom center';
            $style['background-attachment'] = 'fixed';
        }
        if ($this->section->meta->color) {
            $style['background-color'] = $this->section->meta->color;
        }

        $id = data_get($this->section, 'rows.0.meta.anchor', null) === "1" ? str_slug(data_get($this->section, 'rows.0.meta.title')) : null;

        if ($this->section->meta->transparent) {
            $beforeContainer = '<div '.($id ? 'id="'.$id.'"' : '').' class="absolute top-0 left-0 h-full w-full" style="background-color: rgba(255,255,255,0.5)"></div>';
        }

        $containerClass = $this->section->sidebar->meta->position !== false ? 'flex' : '';

        return '<div '.($id ? 'id="'.$id.'"' : '').' '.$this->mergeStyle($style).' class="py-20 relative">'.$beforeContainer.'<div class="container relative '.$containerClass.'">';
    }

    public function sectionOpenTag() {
        $class = collect([]);

        $containerClass = $this->section->sidebar->meta->position !== false ? 'flex' : '';

        $class->push('py-20');
        return '<div class="container '.$containerClass.' '.$class->implode(' ').'">';
    }

    public function sectionClosingTag() {
        return '</div>';
    }

    public function fullwidthClosingTag() {
        return '</div></div>';
    }

    public function mergeStyle($style) {
        return 'style="'.collect($style)->map(function($value, $key) {
            return "{$key}: {$value};";
        })->implode('').'"';
    }

    public function sidebarModules() {
        return collect($this->section->sidebar->modules)->map(function($module, $index) {
            return app(PresenterFactory::class)->resolve($module, $this->markup, $index)->setSection($this->section);
        });
    }
}
