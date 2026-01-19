<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileApiController;

Route::post('/login', [MobileApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [MobileApiController::class, 'dashboard']);
    Route::get('/prestamos', [MobileApiController::class, 'prestamos']);
    Route::get('/prestamos/{id}', [MobileApiController::class, 'prestamo']);
    Route::post('/prestamos/{id}/pagar', [MobileApiController::class, 'registrarPago']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});