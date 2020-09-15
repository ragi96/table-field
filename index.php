<?php

Kirby::plugin('ragi96/table-field', [
    'fields' => [
        'table' => [
            'props' => [
                'maxColumns' => function (int $maxColumns = 10) {
                    return $maxColumns;
                },
                'minColumns' => function (int $minColumns = 2) {
                    return $minColumns;
                },
            ]
        ]
    ],
    'fieldMethods' => [
        'toTable' => function ($field) {
            return $field->toArray()[$field->key()];
        }
    ]
]);
