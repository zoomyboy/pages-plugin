<?php 

namespace Rainlab\Pages\Tests\Traits;

use RainLab\Pages\Tests\Lib\StructureLoader;

trait GeneratesModule {

    public function assertHtml($content, $path, StructureLoader $loader) {
        $json = $loader->toJson();
        $data = data_get($loader->toJson(), $path);
        $this->assertEquals($content, $data);
    }

}
