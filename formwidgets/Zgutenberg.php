<?php namespace Rainlab\Pages\FormWidgets;

use Response;
use Backend\Classes\FormWidgetBase;

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

    public function onGutenbergInit() {
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
}
