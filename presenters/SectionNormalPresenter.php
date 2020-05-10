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

        $id = $this->rows()[0]->meta->anchor == '1' ? str_slug($this->rows()[0]->meta->title) : null;

        return '<div class="'.$class->implode(' ').'" '.$this->mergeAttr('id', $id).'>';
    }

    public function closingTag() {
        return '</div>';
    }

    public function isFullwidth() {
        return false;
    }

}
