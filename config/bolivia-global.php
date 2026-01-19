<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración Regional de Bolivia
    |--------------------------------------------------------------------------
    |
    | Configuraciones específicas para Bolivia que se aplican a toda la aplicación
    |
    */

    'country' => 'Bolivia',
    'country_code' => 'BO',
    'currency' => 'BOB',
    'currency_symbol' => 'Bs',
    'currency_name' => 'Boliviano',
    'timezone' => 'America/La_Paz',
    'locale' => 'es_BO',
    'phone_prefix' => '+591',

    /*
    |--------------------------------------------------------------------------
    | Formato de Números y Moneda
    |--------------------------------------------------------------------------
    */

    'number_format' => [
        'decimals' => 2,
        'decimal_separator' => ',',
        'thousands_separator' => '.',
    ],

    'currency_format' => [
        'symbol_position' => 'before', // before or after
        'symbol_spacing' => true, // space between symbol and amount
        'decimals' => 2,
        'decimal_separator' => ',',
        'thousands_separator' => '.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Formato de Fechas
    |--------------------------------------------------------------------------
    */

    'date_format' => 'd/m/Y',
    'datetime_format' => 'd/m/Y H:i',
    'time_format' => 'H:i',

    /*
    |--------------------------------------------------------------------------
    | Tipos de Documento de Identidad
    |--------------------------------------------------------------------------
    */

    'document_types' => [
        'CI' => 'Cédula de Identidad',
        'PASAPORTE' => 'Pasaporte',
        'EXTRANJERO' => 'Documento de Extranjero',
    ],

    /*
    |--------------------------------------------------------------------------
    | Departamentos de Bolivia
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Configuración de Módulos
    |--------------------------------------------------------------------------
    */

    'modules' => [
        'prestamos' => [
            'currency_display' => true,
            'use_bolivia_format' => true,
        ],
        'inventario' => [
            'currency_display' => true,
            'use_bolivia_format' => true,
        ],
        'compras' => [
            'currency_display' => true,
            'use_bolivia_format' => true,
        ],
        'ventas' => [
            'currency_display' => true,
            'use_bolivia_format' => true,
        ],
        'apartados' => [
            'currency_display' => true,
            'use_bolivia_format' => true,
        ],
        'contabilidad' => [
            'currency_display' => true,
            'use_bolivia_format' => true,
        ],
        'reportes' => [
            'currency_display' => true,
            'use_bolivia_format' => true,
        ],
        'configuracion' => [
            'currency_display' => true,
            'use_bolivia_format' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS y JavaScript
    |--------------------------------------------------------------------------
    */

    'assets' => [
        'css' => [
            'bolivia-currency.css',
            'modules-currency.css',
        ],
        'js' => [
            'bolivia-currency.js',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reemplazos de Texto
    |--------------------------------------------------------------------------
    */

    'text_replacements' => [
        '$' => 'Bs',
        'USD' => 'BOB',
        'Dólares' => 'Bolivianos',
        'dólares' => 'bolivianos',
        'Dólar' => 'Boliviano',
        'dólar' => 'boliviano',
    ],
];