<?php namespace Rainlab\Pages\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Test Back-end Controller
 */
class Test extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Rainlab.Pages', 'pages', 'test');
    }

    public function create() {
        $this->bodyClass = 'compact-container';
        parent::create();
    }

    public function update($record) {
        $this->bodyClass = 'compact-container';
        parent::update($record);
    }
}
