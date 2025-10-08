<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
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
    
    // Rutas para el módulo de Personas Individuales
        Route::resource('people', PersonController::class);
        Route::get('/people-api', [PersonController::class, 'api'])->name('people.api');
        Route::get('/people-statistics', [PersonController::class, 'statistics'])->name('people.statistics');
});

require __DIR__.'/auth.php';
