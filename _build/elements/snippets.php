<?php

return [
    'BarcodeGenerator' => [
        'file' => 'barcodegenerator',
        'description' => 'BarcodeGenerator snippet',
        'properties' => [
            'type_code' => [
                'type' => 'textfield',
                'value' => 'TYPE_CODE_128',
            ],
            'tpl' => [
                'type' => 'textfield',
                'value' => 'BarcodeGenerator',
            ],
        ],
    ],
];