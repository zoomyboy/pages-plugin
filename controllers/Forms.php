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
        if (is_array($form) && $form['type'] == 'component') {
            $fields = $this->getComponentFields($form['component']);
            $fields = ['title' => [ 'label' => 'Titel' ] ] + $fields;
        } else if (is_array($form) && $form['type'] == 'module') {
            $fields = (array) $this->makeConfig($form['component'].'.yml');
            $fields = ['title' => [ 'label' => 'Titel' ] ] + $fields;
        } else {
            $fields = (array) $this->makeConfig($form.'.yml');
        }


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
        $model->forceFill(Input::get('data', []));

        $formWidget = $this->makeWidget('Backend\Widgets\Form', $this->getFormConfig(Input::get('subform'), $model));
        $formWidget->bindToController();

        return [
            'content' => $formWidget->render()
        ];
    }

    public function onSave() {
        $model = app(Model::class);

        $formWidget = $this->makeWidget('Backend\Widgets\Form', $this->getFormConfig(Input::get('subform'), $model));
        $formWidget->bindToController();

        return Response::json($formWidget->getSaveData());
    }

    public function getComponentFields($component) {
        $component = collect(ComponentManager::instance()->listComponents())->get($component);
        $component = ComponentManager::instance()->makeComponent($component);

        return collect($component->defineProperties())->map(function($prop, $key) use ($component) {
            if (array_get($prop, 'type', null) == 'dropdown') {
                $method = 'get'.ucfirst($key).'Options';
                $prop['options'] = $component->{$method}();
            }

            return $prop;
        })->toArray();
    }
}
