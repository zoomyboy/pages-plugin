<?php namespace Rainlab\Pages\FormWidgets;

use View;
use Input;
use Model;
use Response;
use Backend\Classes\Controller;
use Backend\Classes\FormWidgetBase;
use Cms\Classes\Controller as CmsController;
use Dv\Base\Models\Membercategory as Category;
use Cms\Classes\ComponentManager;
use RainLab\Pages\Interfaces\Gutenbergable;
use Cms\Classes\ComponentHelpers;
use Rainlab\Pages\Renderer\Renderer;
use Rainlab\Pages\Controllers\Forms;

/**
 * zgutenberg Form Widget
 */
class Zgutenberg extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'rainlab_pages_zgutenberg';
    public $header = false;

    public static function moduleselect($filter) {
        $forms = app(Forms::class);
        return $forms->getModulesConfig($filter);
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'header'
        ]);
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
        $value = $this->getLoadValue() 
            ? json_decode($this->getLoadValue())
            : (object) [
                'sections' => [],
                'placeholders' => (object) [ 'header' => (object) [] ]
        ];

        return Response::json($value);
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
