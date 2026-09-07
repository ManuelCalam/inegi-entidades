<?php

use App\Http\Controllers\EntityWebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MunicipalityWebController;

Route::get('/', function () {
    return view('welcome');
});


// Route::view('/entities', 'entities.index')->name('entities.index');

//Rutas para municipios
Route::get('/municipalities', [MunicipalityWebController::class, 'index'])->name('municipalities.web');
Route::post('/municipalities', [MunicipalityWebController::class, 'store'])->name('municipalities.web.store');
Route::get('/municipalities/{municipality}', [MunicipalityWebController::class, 'show'])->name('municipalities.web.show');
Route::put('/municipalities/{municipality}', [MunicipalityWebController::class, 'update'])->name('municipalities.web.update');
Route::delete('/municipalities/{municipality}', [MunicipalityWebController::class, 'destroy'])->name('municipalities.web.destroy');

//Rutas para estados
Route::get('/entities', [EntityWebController::class, 'index'])->name('entities.web');
Route::post('/entities', [EntityWebController::class, 'store'])->name('entities.web.store');
Route::get('/entities/{entity}', [EntityWebController::class, 'show'])->name('entities.web.show');
Route::put('/entities/{entity}', [EntityWebController::class, 'update'])->name('entities.web.update');
Route::delete('/entities/{entity}', [EntityWebController::class, 'destroy'])->name('entities.web.destroy');
