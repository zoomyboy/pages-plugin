<?php namespace Rainlab\Pages\Controllers;

use Response;
use Model;
use Input;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Forms Back-end Controller
 */
class Forms extends Controller
{
    public function getFormConfig($form, $model) {
        return [
            'model' => $model,
            'alias' => 'zzzz',
            'context' => 'create',
            'fields' => (array) $this->makeConfig($form.'.yml'),
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
}
