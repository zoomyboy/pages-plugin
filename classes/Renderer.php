<?php

namespace RainLab\Pages\Classes;

use Twig;
use Cms\Classes\Controller as CmsController;
use Cms\Classes\ComponentManager;

class Renderer {
    use \System\Traits\ViewMaker;

    public function render($markup, $params) {
        return $this->makePartial('main', [
            'markup' => $markup,
            'params' => $params
        ]);
    }

    public static function parseParams($params) {
        $params = collect(explode(' ', trim($params)))->filter(function($param) {
            return !empty(trim($param));
        });

        return collect($params)->mapWithKeys(function($param) {
            preg_match_all('/data-([^=]+)="([^"]+)"/', $param, $match);

            return [ $match[1][0] => $match[2][0] ];
        })->toArray();
    }

    public static function insertCmsComponents($markup) {
        $components = preg_match_all('|<figure data-component="([^"]+)" ?([^>]*)></figure>|i', $markup, $declarations, PREG_SET_ORDER);
        
        return array_map(function($declaration) {
            $component = $declaration[1];
            $params = self::parseParams($declaration[2]);
            $componentClass = ComponentManager::instance()->resolve($component);

            return [
                'class'      => $componentClass,
                'alias'      => $component,
                'properties' => $params
            ];
        }, $declarations);
    }

    public static function processPageMarkup($markup) {
        return preg_replace_callback('|<figure data-component="([^"]+)" ?([^>]*)></figure>|i', function($declaration) {
            $component = $declaration[1];
            $controller = CmsController::getController();
            return $controller->renderComponent($component);
        }, $markup);
    }
}
