<?php namespace Rainlab\Pages\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * Aa Form Widget
 */
class Aa extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'rainlab_pages_aa';

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
        return $this->makePartial('aa');
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
        $this->addCss('css/aa.css', 'rainlab.pages');
        $this->addJs('js/aa.js', 'rainlab.pages');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
