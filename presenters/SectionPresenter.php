<?php

namespace RainLab\Pages\Presenters;

class SectionPresenter {

    private $section;
    private $index;
    private $last;

    public function __construct($section, $index, $last) {
        $this->section = $section;
        $this->index = $index;
        $this->last = $last;
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

    if ($this->section->meta->transparent) {
        $beforeContainer = '<div class="absolute top-0 left-0 h-full w-full" style="background-color: rgba(255,255,255,0.5)"></div>';
    }

        return '<div '.$this->mergeStyle($style).' class="py-20 relative">'.$beforeContainer.'<div class="container relative">';
    }

    public function sectionOpenTag() {
        $class = collect([]);

        if ($this->index !== 0) { $class->push('pt-20'); }
        if (!$this->last) { $class->push('pb-20'); }
        return '<div class="container '.$class->implode(' ').'">';
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

}
