<?php

require_once __DIR__ . '/BoliviaConfig.php';

if (!function_exists('formatBs')) {
    function formatBs($amount) {
        return BoliviaConfig::formatCurrency($amount);
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount) {
        return BoliviaConfig::formatCurrency($amount);
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($number, $decimals = 2) {
        return BoliviaConfig::formatNumber($number, $decimals);
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date) {
        return BoliviaConfig::formatDate($date);
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date) {
        return BoliviaConfig::formatDateTime($date);
    }
}

if (!function_exists('getCurrencySymbol')) {
    function getCurrencySymbol() {
        return BoliviaConfig::getCurrencySymbol();
    }
}

if (!function_exists('getCountry')) {
    function getCountry() {
        return BoliviaConfig::getCountry();
    }
}