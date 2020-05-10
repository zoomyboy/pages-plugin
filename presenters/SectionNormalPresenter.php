<?php 

namespace RainLab\Pages\Presenters;

class SectionNormalPresenter extends SectionPresenter {

    public function openTag() {
        $class = collect([]);
        $class->push('container');

        if ($this->hasSidebar()) {
            $class->push('flex');
        }

        if($this->meta()->paddingY) {
            $class->push('py-20');
        }

        return "<div {$this->mergeAttr('class', $class)} {$this->mergeAttr('id', $this->idTag())}>";
    }

    public function closingTag() {
        return '</div>';
    }

    public function isFullwidth() {
        return false;
    }

}
