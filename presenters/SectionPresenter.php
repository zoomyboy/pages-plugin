<?php

namespace RainLab\Pages\Presenters;

use RainLab\Pages\Renderer\PresenterFactory;

abstract class SectionPresenter {

    use HasEnv;
    use MergesAttributes;

    protected $section;
    protected $index;

    public function __construct($section, $index) {
        $this->section = $section;
        $this->index = $index;
    }

    public function isSidebarPosition($position): bool {
        return $this->section->sidebar->meta->position == $position;
    }

    public function hasSidebar(): bool {
        return $this->section->sidebar->meta->position !== false;
    }

    public function sidebarModules() {
        return collect($this->section->sidebar->modules)->map(function($module, $index) {
            return app(PresenterFactory::class)->resolve($module, $index)->setSection($this->section);
        });
    }

    public function rows() {
        return $this->section->rows;
    }

    public function meta() {
        return $this->section->meta;
    }

    /**
     * This will assign the ID as the first row - if that row has an anker setting
     */
    public function idTag(): ?string {
        return data_get($this->section, 'rows.0.meta.anchor', null) === "1"
            ? str_slug(data_get($this->section, 'rows.0.meta.title'))
            : null;
    }

}
