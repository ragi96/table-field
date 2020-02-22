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
            ]
        ]
    ],
    'fieldMethods' => [
        'toTable' => function ($field) {
            return $field->toArray()['table'];
        }
    ]
]);
