<?php

namespace RainLab\Pages\Tests\Lib;

class Structure {

    public static function __callStatic($method, $params) {
        $self = new StructureLoader();

        return $self->{$method}(...$params);
    }

}
