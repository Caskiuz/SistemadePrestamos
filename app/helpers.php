<?php

require_once __DIR__ . '/Helpers/BoliviaHelper.php';

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount) {
        return formatBs($amount);
    }
}