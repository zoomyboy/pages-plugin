<?php namespace Dv\Base\Tests\Stub\Components;

use Cms\Classes\ComponentBase;
use RainLab\Pages\Interfaces\Gutenbergable;

class NoProperties extends ComponentBase implements Gutenbergable
{

    public function componentDetails()
    {
        return [
            'name'        => 'Example',
            'icon'        => 'address-card-o',
            'description' => 'No description provided yet...'
        ];
    }

    public function onRun() {}

    public function defineProperties()
    {
        return [];
    }

}
