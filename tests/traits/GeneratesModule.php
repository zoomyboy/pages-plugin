<?php 

namespace Rainlab\Pages\Tests\Traits;

trait GeneratesModule {

    public function normalParagraph($contents, $meta = []) {
        $meta = array_merge(['title' => 'Absatz', 'content' => $contents, 'textAlign' => 'left', 'textSize' => 'base'], $meta);

        return (object) ['sections' => [
            (object) [
                'sidebar' => (object) ['meta' => (object) ['position' => false], 'modules' => []],
                'meta' => (object) [ 'title' => 'Sektion', 'background' => '', 'color' => NULL, 'type' => 'section', 'transparent' => '0' ],
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

}
