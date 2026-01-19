<?php

class BoliviaConfig
{
    public static function getCountry()
    {
        return 'Bolivia';
    }

    public static function getCurrency()
    {
        return 'BOB';
    }

    public static function getCurrencySymbol()
    {
        return 'Bs.';
    }

    public static function getTimezone()
    {
        return 'America/La_Paz';
    }

    public static function getLocale()
    {
        return 'es_BO';
    }

    public static function getPhonePrefix()
    {
        return '+591';
    }

    public static function formatCurrency($amount)
    {
        return self::getCurrencySymbol() . ' ' . number_format($amount, 2, ',', '.');
    }

    public static function formatNumber($number, $decimals = 2)
    {
        return number_format($number, $decimals, ',', '.');
    }

    public static function formatDate($date)
    {
        return \Carbon\Carbon::parse($date)->setTimezone(self::getTimezone())->format('d/m/Y');
    }

    public static function formatDateTime($date)
    {
        return \Carbon\Carbon::parse($date)->setTimezone(self::getTimezone())->format('d/m/Y H:i');
    }

    public static function getDocumentTypes()
    {
        return [
            'CI' => 'Cédula de Identidad',
            'PASAPORTE' => 'Pasaporte',
            'EXTRANJERO' => 'Documento de Extranjero'
        ];
    }

    public static function getDepartments()
    {
        return [
            'LA_PAZ' => 'La Paz',
            'COCHABAMBA' => 'Cochabamba',
            'SANTA_CRUZ' => 'Santa Cruz',
            'ORURO' => 'Oruro',
            'POTOSI' => 'Potosí',
            'TARIJA' => 'Tarija',
            'SUCRE' => 'Sucre',
            'BENI' => 'Beni',
            'PANDO' => 'Pando'
        ];
    }
}