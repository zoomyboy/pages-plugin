<?php

namespace RainLab\Pages\Presenters;

use Illuminate\Support\Collection;
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

    public function sidebarPosition() {
        return $this->section->sidebar->meta->position;
    }

    public function hasSidebar(): bool {
        return $this->section->sidebar->meta->position !== false;
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


        $subsectionClass = collect([]);
        $subsectionClass->push('relative');

        if ($this->hasSidebar()) {
            $subsectionClass->push('flex');
        }

        $sectionClass = collect(['relative']);
        if ($this->meta()->paddingY) {
            $sectionClass->push('py-20');
        }

        if ($this->meta()->container) {
            $subsectionClass->push('container');
        }

        return '<div '.($id ? 'id="'.$id.'"' : '').' '.$this->mergeStyle($style).' '.$this->mergeClass($sectionClass).'>'.$beforeContainer.'<div '.$this->mergeClass($subsectionClass).'">';
    }

    public function sectionOpenTag() {
        $class = collect([]);
        $class->push('container');

        if ($this->hasSidebar()) {
            $class->push('flex');
        }

        if($this->meta()->paddingY) {
            $class->push('py-20');
        }

        $id = $this->rows()[0]->meta->anchor == '1' ? str_slug($this->rows()[0]->meta->title) : null;

        return '<div class="'.$class->implode(' ').'" '.$this->mergeAttr('id', $id).'>';
    }

    public function sectionClosingTag() {
        return '</div>';
    }

    public function fullwidthClosingTag() {
        return '</div></div>';
    }

    public function mergeClass(Collection $classes) {
        return $this->mergeAttr('class', $classes);
    }

    public function mergeStyle($style) {
        if (count($style) == 0) {
            return '';
        }

        return 'style="'.collect($style)->map(function($value, $key) {
            return "{$key}: {$value};";
        })->implode('').'"';
    }

    public function mergeAttr($name, $values) {
        if (! $values instanceof Collection) {
            $values = collect([$values]);
        }

        if (count($values) == 0) {
            return '';
        }

        return $name.'="'.$values->implode(' ').'"';
    }

    public function sidebarModules() {
        return collect($this->section->sidebar->modules)->map(function($module, $index) {
            return app(PresenterFactory::class)->resolve($module, $this->markup, $index)->setSection($this->section);
        });
    }

    public function rows() {
        return $this->section->rows;
    }

    public function meta() {
        return $this->section->meta;
    }

    public function isFullwidth() {
        return $this->meta()->type == 'fullwidth';
    }
}
