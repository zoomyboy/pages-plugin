<?php

namespace RainLab\Pages\Presenters;

class AnkerlistSidebarModulePresenter {

    public $section;
    public $index;
    public $markup;
    public $module;

    public function __construct($module, $index, $markup) {
        $this->module = $module;
        $this->index = $index;
        $this->markup = $markup;
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
                if (isset($row->meta->anchor) && $row->meta->anchor === '1') {
                    $ankers->push((object) [
                        'href' => str_slug($row->meta->title),
                        'title' => $row->meta->title
                    ]);
                }
            });
        });

        return $ankers;
    }

}
