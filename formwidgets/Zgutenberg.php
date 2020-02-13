<?php namespace Rainlab\Pages\FormWidgets;

use View;
use Input;
use Response;
use Backend\Classes\FormWidgetBase;
use Cms\Classes\Controller as CmsController;
use Dv\Base\Models\Membercategory as Category;
use Cms\Classes\ComponentManager;

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
        $this->addCss('css/zgutenberg.css', 'rainlab.pages');
        $this->addCss('css/font.css', 'rainlab.pages');
        $this->addCss('css/backend.css', 'rainlab.pages');
        $this->addCss('css/theme-fonts.css', 'rainlab.pages');
        $this->addJs('js/zgutenberg.js', 'rainlab.pages');
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

    public function onUpdateComponent() {
        $controller = CmsController::getController();

        $params = collect(Input::get('params'))->map(function($param) {
            return $param['value'] ?? null;
        })->toArray();

        $component = ComponentManager::instance()->makeComponent(Input::get('component'), null, $params);

        $page = app()->make('\Cms\Classes\Page');
        $page->components = [Input::get('component') => $component];

        $controller = app()->make('\Cms\Classes\Controller');
        $controller->runPage($page, false);


        $markup = $controller->renderComponent(Input::get('component'));

        return Response::make($markup);
    }

    public function loadMembersParams() {
        return [
            'category' => [
                'label' => 'Kategorie',
                'type' => 'dropdown',
                'placeholder' => 'Kategorie wählen',
                'value' => null,
                'options' => Category::get()->pluck('title', 'id')->toArray()
            ]
        ];
    }

    public function onLoadParams() {
        $component = Input::get('component');
        $method = camel_case('load_'.$component.'_params');

        return Response::json($this->{$method}());
    }
}
