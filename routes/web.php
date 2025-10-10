<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ReferenceCodeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RecruiterController;
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
        Route::patch('/people/{person}/personal-info', [PersonController::class, 'updatePersonalInfo'])->name('people.update-personal-info');
        Route::patch('/people/{person}/residence-info', [PersonController::class, 'updateResidenceInfo'])->name('people.update-residence-info');
        Route::patch('/people/{person}/aspiration', [PersonController::class, 'updateAspiration'])->name('people.update-aspiration');
        Route::post('/people/{person}/educational-skills', [PersonController::class, 'storeEducationalSkill'])->name('people.educational-skills.store');
        Route::delete('/people/{person}/educational-skills/{educationalSkill}', [PersonController::class, 'destroyEducationalSkill'])->name('people.educational-skills.destroy');
        Route::post('/people/{person}/work-experiences', [PersonController::class, 'storeWorkExperience'])->name('people.work-experiences.store');
        Route::delete('/people/{person}/work-experiences/{workExperience}', [PersonController::class, 'destroyWorkExperience'])->name('people.work-experiences.destroy');
        Route::post('/people/{person}/personal-references', [PersonController::class, 'storePersonalReference'])->name('people.personal-references.store');
        Route::delete('/people/{person}/personal-references/{personalReference}', [PersonController::class, 'destroyPersonalReference'])->name('people.personal-references.destroy');
        Route::get('/people-api', [PersonController::class, 'api'])->name('people.api');
        Route::get('/people-statistics', [PersonController::class, 'statistics'])->name('people.statistics');
    
    // Rutas para el módulo de Empresas
    Route::get('/companies/check-rnc/{rnc}', [CompanyController::class, 'checkRnc'])->name('companies.check-rnc');
    Route::resource('companies', CompanyController::class);
    Route::get('/companies/municipalities/{province}', [CompanyController::class, 'getMunicipalities'])->name('companies.municipalities');
    
    // Rutas para el módulo de Reclutadores
    Route::get('/recruiters/search-by-rnc', [RecruiterController::class, 'searchByRnc'])->name('recruiters.search-by-rnc');
    Route::get('/recruiters/search-by-dni', [RecruiterController::class, 'searchByDni'])->name('recruiters.search-by-dni');
    Route::resource('recruiters', RecruiterController::class);
    
    // Rutas para el módulo de Configuraciones
    Route::prefix('configuraciones')->name('config.')->group(function () {
        // Certificaciones (Tipos de Referencia)
        Route::resource('certifications', CertificationController::class)->names('certifications');
        
        // Códigos de Referencias
        Route::resource('reference-codes', ReferenceCodeController::class)->names('reference-codes');
        
        // Roles
        Route::resource('roles', RoleController::class)->names('roles');
    });
    
    // Ruta temporal para pruebas de toast
    Route::get('/test-toast', function () {
        return view('test-toast');
    })->name('test-toast');
});

require __DIR__.'/auth.php';
