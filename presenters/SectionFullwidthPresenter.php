<?php 

namespace RainLab\Pages\Presenters;

class SectionFullwidthPresenter extends SectionPresenter {

    public function openTag() {
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

        return '<div '.$this->mergeAttr('id', $id).' '.$this->mergeStyle($style).' '.$this->mergeClass($sectionClass).'>'.$beforeContainer.'<div '.$this->mergeClass($subsectionClass).'">';
    }

    public function closingTag() {
        return '</div></div>';
    }

    public function isFullwidth() {
        return true;
    }
}
