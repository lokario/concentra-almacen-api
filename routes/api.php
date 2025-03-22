<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\tblClienteController;
use App\Http\Controllers\Api\tblArticuloController;
use App\Http\Controllers\Api\tblColocacionController;
use App\Http\Controllers\Api\tblFacturaController;
use App\Http\Controllers\Api\tblPedidoController;
use App\Http\Controllers\Api\tblPY1Controller;

Route::apiResource('clientes', tblClienteController::class);
Route::apiResource('articulos', tblArticuloController::class);
Route::apiResource('colocaciones', tblColocacionController::class);
Route::apiResource('facturas', tblFacturaController::class);
Route::apiResource('pedidos', tblPedidoController::class);
Route::apiResource('usuarios', tblPY1Controller::class);
