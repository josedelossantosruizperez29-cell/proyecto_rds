<?php

use Illuminate\Http\Request;
use  App\Http\Controllers\EmpleadoController;   
use App\Http\Controllers\funcionCargoController;
use App\Http\Controllers\CargoController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

    // aqui implementamos laravel sanctum
    Route::apiResource('cargos', CargoController::class);
    Route::apiResource('empleados', EmpleadoController::class);
    Route::apiResource('funcionCargos', funcionCargoController::class);

