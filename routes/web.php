<?php

use App\Http\Controllers\EntityWebController;
use App\Http\Controllers\FireController;
use App\Http\Controllers\MunicipalityWebController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas accesibles para todos
    Route::middleware(['role:admin|capturista'])->group(function () {
        
        // Rutas para funcionamiento de formulario de incendios
        Route::prefix('fires/{entity_id}')->group(function () {
            Route::get('/municipalities', [FireController::class, 'getMunicipalities']);
            Route::get('/vegetation-types', [FireController::class, 'getVegetationTypes']);
            Route::get('/generate-fire-key', [FireController::class, 'generateFireKey']);
        });

        // Buscar y agregar incendio
        Route::resource('fires', FireController::class)->only(['index', 'store']);
    });

    // Rutas para administrador
    Route::middleware(['role:admin'])->group(function () {

        // Editar y eliminar incendios
        Route::resource('fires', FireController::class)->only(['update', 'destroy']);

        // Rutas para municipios 
        Route::get('/municipalities', [MunicipalityWebController::class, 'index'])->name('municipalities.web');
        Route::post('/municipalities', [MunicipalityWebController::class, 'store'])->name('municipalities.web.store');
        Route::get('/municipalities/{municipality}', [MunicipalityWebController::class, 'show'])->name('municipalities.web.show');
        Route::put('/municipalities/{municipality}', [MunicipalityWebController::class, 'update'])->name('municipalities.web.update');
        Route::delete('/municipalities/{municipality}', [MunicipalityWebController::class, 'destroy'])->name('municipalities.web.destroy');

        // Rutas para entidades 
        Route::get('/entities', [EntityWebController::class, 'index'])->name('entities.web');
        Route::post('/entities', [EntityWebController::class, 'store'])->name('entities.web.store');
        Route::get('/entities/{entity}', [EntityWebController::class, 'show'])->name('entities.web.show');
        Route::put('/entities/{entity}', [EntityWebController::class, 'update'])->name('entities.web.update');
        Route::delete('/entities/{entity}', [EntityWebController::class, 'destroy'])->name('entities.web.destroy');

        // Ruta para administrar usuarios
        Route::resource('users', UserController::class)->only(['index', 'store']);
    });

});

require __DIR__.'/auth.php';