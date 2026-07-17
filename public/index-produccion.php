<?php

define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../app-hc/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../app-hc/vendor/autoload.php';

$app = require_once __DIR__.'/../app-hc/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);