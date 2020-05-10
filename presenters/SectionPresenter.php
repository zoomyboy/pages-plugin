<?php

namespace RainLab\Pages\Presenters;

use RainLab\Pages\Renderer\PresenterFactory;

abstract class SectionPresenter {

    use HasEnv;
    use MergesAttributes;

    protected $section;
    protected $index;
    protected $markup;

    public function __construct($section, $index, $markup) {
        $this->section = $section;
        $this->index = $index;
        $this->markup = $markup;
    }

    public function isSidebarPosition($position): bool {
        return $this->section->sidebar->meta->position == $position;
    }

    public function hasSidebar(): bool {
        return $this->section->sidebar->meta->position !== false;
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

}
