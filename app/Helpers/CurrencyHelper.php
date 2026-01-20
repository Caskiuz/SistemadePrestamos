<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount) {
        return 'Bs. ' . number_format($amount, 2, ',', '.');
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($amount, $decimals = 2) {
        return number_format($amount, $decimals, ',', '.');
    }
}

if (!function_exists('formatBs')) {
    function formatBs($amount) {
        return 'Bs. ' . number_format($amount, 2, ',', '.');
    }
}