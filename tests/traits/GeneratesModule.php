<?php 

namespace Rainlab\Pages\Tests\Traits;

trait GeneratesModule {

    public function normalParagraph($contents, $meta = [], $section = []) {
        $meta = array_merge(['title' => 'Absatz', 'content' => $contents, 'textAlign' => 'left', 'textSize' => 'base'], $meta);
        $section = array_merge([ 'title' => 'Sektion', 'background' => '', 'color' => NULL, 'type' => 'section', 'transparent' => '0' ], $section);

        return (object) ['sections' => [
            (object) [
                'sidebar' => (object) ['meta' => (object) ['position' => false], 'modules' => []],
                'meta' => (object) $section,
                'rows' => [
                    (object) [
                        'meta' => (object) ['title' => 'Zeile'],
                        'columns' => [
                            (object) ['width' => 'full', 'modules' => [
                                (object) [
                                    'is' => (object) ['type' => 'module', 'component' => 'paragraph', 'icon' => 'paragraph'],
                                    'meta' => (object) $meta,
                                ],
                            ]],
                        ],
                    ],
                ],
            ],
        ], 'placeholders' => (object) [
            'header' => []
        ]];
    }

    public function section($contents, $meta = []) {
        return $this->normalParagraph('aaa', [], $meta);
    }
}
