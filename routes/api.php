<?php

use Illuminate\Http\Request;
use  App\Http\Controllers\EmpleadoController;   
use App\Http\Controllers\funcionCargoController;
use App\Http\Controllers\CargoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


    Route::POST('/login', [AuthController::class, 'login']);
    Route::POST('/register', [AuthController::class, 'register']);
    
    // aqui implementamos laravel sanctum y aseguramos las rutas para los usuarios no autenticados

    Route::middleware('auth:sanctum')->group(function () {
    Route::POST('/logout', [AuthController::class, 'logout']);    
    Route::apiResource('cargos', CargoController::class);
    Route::apiResource('empleados', EmpleadoController::class);
    Route::apiResource('funcionCargos', funcionCargoController::class);
    Route::GET('detalle_empleado/{id}', [EmpleadoController::class, 'detalle_empleado']);
    Route::GET('detalle_cargos',[CargoController::class,'detalle_cargos']);
    });



