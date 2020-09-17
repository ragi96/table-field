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
            if(is_string($field->value())) {
                $value = $field->kirbytextinline();
                $valueArray = preg_split('/\n|\r\n?/', $value);
                $selfmadeValue = [];
                $row = [];
                foreach ($valueArray as $val) {
                    $lastSixChars = substr($val, -6);
                    if($lastSixChars == '<br />'){
                        $val = str_replace($lastSixChars, '', $val);
                    }
                    if($val == '-') {
                        if(count($row) > 0){
                            array_push($selfmadeValue, $row);
                        }
                        $row = [];
                    } else {
                        $val = preg_replace('/- /', '', ltrim($val), 1);
                        if (substr($val, 0, 1) === '"' && substr($val, -1) === '"') {
                            // removes first and last char
                            $val = preg_replace('/^.|.$/','',$val);
                        }
                        array_push($row, $val);
                    }
                }
                array_push($selfmadeValue, $row);
                return $selfmadeValue;
            } else {
                return $field->toArray()[$field->key()];
            }
        }
    ]
]);
