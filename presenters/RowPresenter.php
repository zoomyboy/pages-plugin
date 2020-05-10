<?php

namespace RainLab\Pages\Presenters;

class RowPresenter {

    use MergesAttributes;

    protected $row;
    protected $index;

    public function __construct($row, $index) {
        $this->row = $row;
        $this->index = $index;
    }

    public function openTag() {
        $rowMarginTop = $this->index != 0 && app('renderer.section')->isFullwidth() ? 'mt-10 pt-10' : null;

        return "<div {$this->mergeAttr('class', $rowMarginTop)} {$this->mergeAttr('id', $this->idTag())}>";
    }

    public function columns() {
        return $this->row->columns;
    }

    public function meta($value) {
        return data_get($this->row->meta, $value);
    }

    public function closingTag() {
        return '</div>';
    }

    public function title() {
        return $this->meta('title');
    }

    public function idTag() {
        return app('renderer.section')->isFullwidth() || $this->index !== 0
            ? str_slug($this->title())
            : null;
    }

    public function hasAnchor() {
        return $this->meta('anchor') === '1';
    }

}
