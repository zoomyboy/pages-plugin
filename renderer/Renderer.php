<?php

namespace RainLab\Pages\Renderer;

use Twig;
use Cms\Classes\Controller as CmsController;
use Cms\Classes\ComponentManager;
use RainLab\Pages\Presenters\SectionPresenter;
use RainLab\Pages\Interfaces\Gutenbergable;

class Renderer {
    use \System\Traits\ViewMaker;
    use \System\Traits\ConfigMaker;

    private $markup;

    private $moduleTypes = [ 'component', 'module', 'sidebar' ];

    private function getLocalFileConfigsOf($type) {
        $types = str_plural($type);

        return collect(glob($this->guessViewPath("/{$types}").'/*.yml'))->mapWithKeys(function($module) use ($types, $type) {
            $moduleName = str_replace('_', '', basename($module, '.yml'));
            return [ $moduleName => collect($this->makeConfig("{$types}/_{$moduleName}.yml"))->merge(['type' => $type, 'alias' => $moduleName]) ];
        });
    }

    private function getConfigsOfModules() {
        return $this->getLocalFileConfigsOf('module');
    }

    private function getConfigsOfSidebars() {
        return $this->getLocalFileConfigsOf('sidebar');
    }

    private function getConfigsOfComponents() {
        return collect(ComponentManager::instance()->listComponents())->filter(function($class) {
            return in_array(Gutenbergable::class, class_implements($class));
        })->map(function($component, $alias) {
            $component = ComponentManager::instance()->makeComponent($component);

            $parameters = collect($component->defineProperties())->map(function($prop, $key) use ($component) {
                if (array_get($prop, 'type', null) == 'dropdown') {
                    $method = 'get'.ucfirst($key).'Options';
                    $prop['options'] = $component->{$method}();
                }

                return $prop;
            })->toArray();
            $parameters['title'] = ['default' => $component->componentDetails()['name'], 'label' => 'Titel'];

            return collect([
                'settings' => [
                    'icon' => ['default' => $component->componentDetails()['icon']]
                ],
                'type' => 'component',
                'alias' => $alias,
                'meta' => $parameters
            ]);
        });
    }

    public function getModulesConfigs() {
        return collect($this->moduleTypes)->mapWithKeys(function($type) {
            $types = str_plural($type);
            $method = 'getConfigsOf'.ucfirst($types);
            return [ $types => $this->{$method}() ];
        })->flatten(1)->mapWithKeys(function($module) {
            $alias = $module->get('alias');
            $module->forget('alias');
            return [ $alias => $module ];
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
            preg_match_all('/data-([^=]+)="([^"]*)"/', $param, $match);

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
