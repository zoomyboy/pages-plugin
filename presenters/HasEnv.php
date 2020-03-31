<?php

namespace RainLab\Pages\Presenters;

trait HasEnv {
    public function isLast() {
        return $this->index == count($this) - 1;
    }

    public function isFirst() {
        return $this->index === 0;
    }
}
