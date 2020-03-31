<?php 

namespace RainLab\Pages\Renderer;

class PresenterFactory {

    public function resolve($abstract, $markup, $index = null) {
        $type = data_get($abstract, 'meta.type', null);

        if ($type && $cls = $this->guessClassNameByType($type)) {
            return new $cls($abstract, $index, $markup);
        }

        if (data_get($abstract, 'is.type', null) === 'sidebar') {
            $className = $this->resolveSidebarModule($abstract);
            return new $className($abstract, $index, $markup);
        }
    }

    public function guessClassNameByType($type) {
        $type = ucfirst($type);
        $className = "\\RainLab\\Pages\\Presenters\\".$type."Presenter";
        return class_exists($className) ? $className : null;
    }

    public function resolveSidebarModule($abstract) {
        $type = ucfirst(data_get($abstract, 'is.component'));

        $className = "\\RainLab\\Pages\\Presenters\\".$type."SidebarModulePresenter";
        return class_exists($className) ? $className : null;
    }
}
