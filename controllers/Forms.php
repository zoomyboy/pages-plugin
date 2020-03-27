<?php namespace Rainlab\Pages\Controllers;

use Response;
use Model;
use Input;
use BackendMenu;
use Backend\Classes\Controller;
use Cms\Classes\ComponentManager;

/**
 * Forms Back-end Controller
 */
class Forms extends Controller
{
    public function getFormConfig($form, $model) {
        $fields = $form === 'component' ? $this->getComponentFields($model->component) : (array) $this->makeConfig($form.'.yml');

        return [
            'model' => $model,
            'alias' => 'zzzz',
            'context' => 'create',
            'fields' => $fields,
        ];
    }

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Rainlab.Pages', 'pages', 'forms');
    }

    public function index() {}

    public function onEdit() {
        $model = app(Model::class);
        $model->forceFill(Input::get('data'));

        $formWidget = $this->makeWidget('Backend\Widgets\Form', $this->getFormConfig(Input::get('subform'), $model));
        $formWidget->bindToController();

        return [
            'content' => $formWidget->render()
        ];
    }

    public function onSave() {
        return Response::json(Input::all());
    }

    public function getComponentFields($component) {
        $component = collect(ComponentManager::instance()->listComponents())->get($component);
        $component = ComponentManager::instance()->makeComponent($component);

        return collect($component->defineProperties())->map(function($prop, $key) use ($component) {
            $method = 'get'.ucfirst($key).'Options';
            $prop['options'] = $component->{$method}();

            return $prop;
        })->toArray();
    }
}
