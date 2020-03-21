<?php namespace Rainlab\Pages\FormWidgets;

use View;
use Input;
use Response;
use Backend\Classes\FormWidgetBase;
use Cms\Classes\Controller as CmsController;
use Dv\Base\Models\Membercategory as Category;
use Cms\Classes\ComponentManager;
use RainLab\Pages\Interfaces\Gutenbergable;
use Cms\Classes\ComponentHelpers;

/**
 * zgutenberg Form Widget
 */
class Zgutenberg extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'rainlab_pages_zgutenberg';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('zgutenberg');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/zgutenberg.build.css', 'rainlab.pages');
        $this->addJs('js/zgutenberg.build.js', 'rainlab.pages');
    }

    public function onLoadValue() {
        if (method_exists($this->model, 'getGutenbergData')) {
            $value = $this->model->getGutenbergData();
        } else {
            $value = $this->getLoadValue() ?: [];
        }

        return Response::json($value);
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return json_decode($value);
    }

    public function onGetComponentBlocks() {
        $components = collect(ComponentManager::instance()->listComponents())->filter(function($class) {
            return in_array(Gutenbergable::class, class_implements($class));
        })->map(function($component) {
            $component = ComponentManager::instance()->makeComponent($component);

            $properties = collect($component->defineProperties())->map(function($prop, $key) use ($component) {
                $method = 'get'.ucfirst($key).'Options';
                $prop['options'] = $component->{$method}();

                if ($prop['type'] == 'dropdown') {
                    $prop['value'] = null;
                }

                return $prop;
            });

            return [
                'icon' => $component->componentDetails()['icon'],
                'name' => $component->componentDetails()['name'],
                'is' => 'comp',
                'params' => (object) $properties->toArray()
            ];
        });

        return Response::json($components);
    }

    public function onGetComponentBlock() {
        $block = Input::get('block');
        $component = collect(ComponentManager::instance()->listComponents())->get(Input::get('block'));

        $component = ComponentManager::instance()->makeComponent($component);

        $properties = collect($component->defineProperties())->map(function($prop, $key) use ($component) {
            $method = 'get'.ucfirst($key).'Options';
            $prop['options'] = $component->{$method}();

            if ($prop['type'] == 'dropdown') {
                $prop['value'] = null;
            }

            return $prop;
        });

        return Response::json([
            'icon' => $component->componentDetails()['icon'],
            'name' => $component->componentDetails()['name'],
            'is' => 'comp',
            'params' => (object) $properties->toArray()
        ]);
    }
}
