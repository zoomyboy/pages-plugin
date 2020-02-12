<?php

namespace RainLab\Pages\Classes;

use Twig;

class Renderer {
    use \System\Traits\ViewMaker;

    public function render($markup) {
        return $this->makePartial('main', ['markup' => $markup]);
    }
}
