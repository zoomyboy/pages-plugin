<?php

namespace RainLab\Pages\Presenters;

class AnkerlistSidebarModulePresenter {

    public $section;
    public $index;
    public $markup;
    public $module;

    public function __construct($module, $index) {
        $this->module = $module;
        $this->index = $index;
    }

    public function setSection($section) {
        $this->section = $section;

        return $this;
    }

    public function title() {
        return $this->module->meta->title;
    }

    public function getPartial() {
        return $this->module->is->component;
    }

    public function links() {
        $ankers = collect([]);

        $columns = app('renderer.markup')->sections->each(function($section) use ($ankers) {
            collect($section->rows())->each(function($row) use ($ankers) {
                if ($row->hasAnchor()) {
                    $ankers->push((object) [
                        'href' => str_slug($row->title()),
                        'title' => $row->title()
                    ]);
                }
            });
        });

        return $ankers;
    }

}
