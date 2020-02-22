<?php

Kirby::plugin('ragi96/table-field', [
    'fields' => [
        'table' => [
            'props' => [
                'maxColumns' => function ($maxColumns = 10) {
                  return $maxColumns;
                },
                'minColumns' => function ($minColumns = 1) {
                  return $minColumns;
                },
                'header' => function ($header = false) {
                  return $header;
                }
            ]
        ]
    ]
]);
