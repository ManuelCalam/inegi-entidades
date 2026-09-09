<?php

use App\Http\Controllers\EntityWebController;
use App\Http\Controllers\MunicipalityWebController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
});



require __DIR__.'/auth.php';
