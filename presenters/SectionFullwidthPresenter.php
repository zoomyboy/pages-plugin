<?php 

namespace RainLab\Pages\Presenters;

class SectionFullwidthPresenter extends SectionPresenter {

    public function openTag() {
        $style = [];
        $beforeContainer = '';
        
        if ($this->meta('background')) {
            $style['background-image'] = "url(/storage/app/media{$this->meta('background')})";
            $style['background-size'] = 'cover';
            $style['background-position'] = 'bottom center';
            $style['background-attachment'] = 'fixed';
        }
        if ($this->meta('color')) {
            $style['background-color'] = $this->meta('color');
        }

        if ($this->meta('transparent')) {
            $beforeContainer = '<div class="absolute top-0 left-0 h-full w-full" style="background-color: rgba(255,255,255,'.$this->meta('transparent_amount').')"></div>';
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

        return "<div {$this->mergeAttr('id', $this->idTag())} {$this->mergeStyle($style)} {$this->mergeClass($sectionClass)}>
            {$beforeContainer}
            <div {$this->mergeClass($subsectionClass)}>
        ";
    }

    public function closingTag() {
        return '</div></div>';
    }

    public function isFullwidth() {
        return true;
    }
}
