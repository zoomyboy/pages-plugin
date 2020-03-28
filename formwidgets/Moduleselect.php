<?php namespace Rainlab\Pages\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * Moduleselect Form Widget
 */
class Moduleselect extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'rainlab_pages_moduleselect';

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
        return $this->makePartial('moduleselect');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['modules'] = Zgutenberg::moduleselect();
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/moduleselect.css', 'rainlab.pages');
        $this->addJs('js/moduleselect.js', 'rainlab.pages');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return json_decode($value);
    }
}
