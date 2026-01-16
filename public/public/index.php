<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = '/home/hcservic/app-hc/storage/framework/maintenance.php')) {
    require $maintenance;
}

require '/home/hcservic/app-hc/vendor/autoload.php';

$app = require_once '/home/hcservic/app-hc/bootstrap/app.php';

$app->handleRequest(Request::capture());
