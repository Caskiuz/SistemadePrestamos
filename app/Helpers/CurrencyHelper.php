<?php

require_once __DIR__ . '/BoliviaConfig.php';

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount) {
        return BoliviaConfig::formatCurrency($amount);
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($amount, $decimals = 2) {
        return BoliviaConfig::formatNumber($amount, $decimals);
    }
}