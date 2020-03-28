<?php

namespace RainLab\Pages\Classes;

use Twig;
use Cms\Classes\Controller as CmsController;
use Cms\Classes\ComponentManager;
use RainLab\Pages\Presenters\SectionPresenter;

class Renderer {
    use \System\Traits\ViewMaker;
    use \System\Traits\ConfigMaker;

    private $markup;

    public function getModulesConfigs() {
        return collect(glob($this->guessViewPath('/modules').'/*.yml'))->mapWithKeys(function($module) {
            $moduleName = str_replace('_', '', basename($module, '.yml'));
            return [ $moduleName => collect($this->makeConfig("modules/_{$moduleName}.yml")) ];
        });
    }

    public function render($markup, $params) {
        $this->markup = $markup;

        return $this->makePartial('main', [
            'markup' => $markup,
            'params' => $params
        ]);
    }

    public function renderPlaceholders($placeholders, $params) {
        return collect($placeholders)->map(function($placeholder, $name) {
            return $this->makePartial('placeholder_'.$name, (array) $placeholder);
        })->toArray();
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

    public function presenter($block, $index = null) {
        if (in_array($block->meta->type, ['section', 'fullwidth'])) {
            return new SectionPresenter($block, $index, $index === count($this->markup->sections) -1);
        }
    }
}
