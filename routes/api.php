<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\tblArticuloController;
use App\Http\Controllers\Api\tblClienteController;
use App\Http\Controllers\Api\tblColocacionController;
use App\Http\Controllers\Api\tblFacturaController;
use App\Http\Controllers\Api\tblPedidoController;
use App\Http\Controllers\Api\tblPY1Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clientes', tblClienteController::class);
    Route::apiResource('articulos', tblArticuloController::class);
    Route::apiResource('colocaciones', tblColocacionController::class)->parameters([
    'colocaciones' => 'colocacion',
]);

    Route::apiResource('facturas', tblFacturaController::class);
    Route::apiResource('pedidos', tblPedidoController::class);
    Route::apiResource('usuarios', tblPY1Controller::class);

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
