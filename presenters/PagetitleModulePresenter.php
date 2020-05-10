<?php

namespace RainLab\Pages\Presenters;

use RainLab\Pages\Classes\Page;
use Cms\Classes\Theme;
use RainLab\Pages\Classes\Router;
use RainLab\Pages\Classes\Page as StaticPageClass;
use RainLab\Pages\Classes\MenuItemReference;

class PagetitleModulePresenter {

    public $index;
    public $markup;
    public $module;

    public function __construct($module, $index, $markup) {
        $this->module = $module;
        $this->index = $index;
        $this->markup = $markup;
    }

    public function links() {
        $page = app('renderer.current')->getPage();
        $bag = app('renderer.current')->getBag();
        $theme = Theme::getActiveTheme();
        $tree = collect(StaticPageClass::buildMenuTree($theme));

        $node = $page->parentFileName;

        $return = [];

        while ($node) {
            $pageInfo = $tree->get($node);

            if ($pageInfo['navigation_hidden']) {
                $node = $pageInfo['parent'];
                continue;
            }

            array_unshift($return, (object) [
                'href' => $pageInfo['url'],
                'title' => $pageInfo['title']
            ]);

            $node = $pageInfo['parent'];
        }

        array_unshift($return, (object) [
            'href' => '/',
            'title' => 'Startseite'
        ]);

        array_push($return, (object) [
            'href' => data_get($bag, 'settings.viewBag.url'),
            'title' => data_get($bag, 'settings.viewBag.title')
        ]);

        return $return;
    }

    public function pagetitle() {
        return data_get(app('renderer.current')->getBag(), 'settings.viewBag.title');
    }

    public function getPartial() {
        return $this->module->is->component;
    }
}

