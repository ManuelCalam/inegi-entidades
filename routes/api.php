<?php

use App\Http\Controllers\EntityController;
use App\Http\Controllers\MunicipalityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('/entidades', [EntityController::class, 'store']);
// Route::get('/entidades', [EntityController::class, 'index']);
// Route::get('/entidades/{id}', [EntityController::class, 'show']);
// Route::put('/entidades/{id}', [EntityController::class, 'update']);
// Route::delete('/entidades/{id}', [EntityController::class, 'destroy']);

Route::apiResource('entities', EntityController::class);

Route::apiResource('municipalities', MunicipalityController::class);