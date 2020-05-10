<?php

namespace RainLab\Pages\Presenters;

use Illuminate\Support\Collection;

trait MergesAttributes {

    public function mergeClass(Collection $classes) {
        return $this->mergeAttr('class', $classes);
    }

    public function mergeStyle($style) {
        if (count($style) == 0) {
            return '';
        }

        return 'style="'.collect($style)->map(function($value, $key) {
            return "{$key}: {$value};";
        })->implode('').'"';
    }

    public function mergeAttr($name, $values) {
        if (! $values instanceof Collection) {
            $values = collect([$values]);
        }

        if (count($values) == 0) {
            return '';
        }

        return $name.'="'.$values->implode(' ').'"';
    }

}
