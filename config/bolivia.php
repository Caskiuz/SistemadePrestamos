<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración Regional de Bolivia
    |--------------------------------------------------------------------------
    |
    | Configuraciones específicas para Bolivia incluyendo moneda, zona horaria,
    | formatos de fecha, números y otras configuraciones regionales.
    |
    */

    'country' => [
        'name' => 'Bolivia',
        'code' => 'BO',
        'phone_prefix' => '+591',
    ],

    'currency' => [
        'code' => 'BOB',
        'symbol' => 'Bs.',
        'name' => 'Boliviano',
        'decimal_places' => 2,
        'decimal_separator' => ',',
        'thousands_separator' => '.',
    ],

    'locale' => [
        'primary' => 'es_BO',
        'fallback' => 'es',
        'faker' => 'es_ES',
    ],

    'timezone' => 'America/La_Paz',

    'formats' => [
        'date' => 'd/m/Y',
        'datetime' => 'd/m/Y H:i',
        'time' => 'H:i',
    ],

    'document_types' => [
        'CI' => 'Cédula de Identidad',
        'PASAPORTE' => 'Pasaporte',
        'EXTRANJERO' => 'Documento de Extranjero',
    ],

    'departments' => [
        'LA_PAZ' => 'La Paz',
        'COCHABAMBA' => 'Cochabamba',
        'SANTA_CRUZ' => 'Santa Cruz',
        'ORURO' => 'Oruro',
        'POTOSI' => 'Potosí',
        'TARIJA' => 'Tarija',
        'SUCRE' => 'Sucre',
        'BENI' => 'Beni',
        'PANDO' => 'Pando',
    ],

    'business' => [
        'tax_id_name' => 'NIT',
        'tax_id_format' => '##########',
    ],
];