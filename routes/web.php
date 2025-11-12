<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ReferenceCodeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkIntegrityController;
use App\Http\Controllers\Public\PersonRegistrationController;
use App\Http\Controllers\Public\CompanyRegistrationController;
use App\Http\Controllers\User\PersonalProfileController;
use App\Http\Controllers\Company\CompanyDashboardController;
use App\Http\Controllers\Company\CompanyPersonController;
use App\Http\Controllers\Company\CompanyWorkIntegrityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas para registro de persona
Route::prefix('registro-persona')->name('public.person-registration.')->group(function () {
    Route::get('/', [PersonRegistrationController::class, 'show'])->name('wizard');
    Route::post('/', [PersonRegistrationController::class, 'store'])->name('store');
    Route::get('/districts-by-municipality', [PersonRegistrationController::class, 'getDistrictsByMunicipality'])->name('districts-by-municipality');
});

// Rutas públicas para registro de empresa - DESHABILITADO
// Route::prefix('registro-empresa')->name('public.company-registration.')->group(function () {
//     Route::get('/', [CompanyRegistrationController::class, 'show'])->name('wizard');
//     Route::post('/', [CompanyRegistrationController::class, 'store'])->name('store');
//     Route::get('/municipalities-by-province', [CompanyRegistrationController::class, 'getMunicipalitiesByProvince'])->name('municipalities-by-province');
// });

// Ruta para descargar CV (requiere autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/registro-persona/cv/{person}', [PersonRegistrationController::class, 'generateCV'])->name('public.person-registration.cv');
});

// Rutas para usuarios personales (solo su propia información)
Route::middleware(['auth', 'user.owns.person'])->prefix('mi-perfil')->name('user.')->group(function () {
    Route::get('/', [PersonalProfileController::class, 'index'])->name('dashboard');
    Route::get('/informacion', [PersonalProfileController::class, 'show'])->name('profile.show');
    Route::get('/informacion/editar', [PersonalProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/cv', [PersonalProfileController::class, 'generateCV'])->name('cv');
    
    // Rutas para actualizar información
    Route::patch('/informacion/personal', [PersonalProfileController::class, 'updatePersonalInfo'])->name('profile.update-personal-info');
    Route::patch('/informacion/residencia', [PersonalProfileController::class, 'updateResidenceInfo'])->name('profile.update-residence-info');
    Route::patch('/informacion/aspiraciones', [PersonalProfileController::class, 'updateAspiration'])->name('profile.update-aspiration');
    
    // Rutas para habilidades educativas
    Route::post('/informacion/habilidades-educativas', [PersonalProfileController::class, 'storeEducationalSkill'])->name('profile.educational-skills.store');
    Route::delete('/informacion/habilidades-educativas/{educationalSkill}', [PersonalProfileController::class, 'destroyEducationalSkill'])->name('profile.educational-skills.destroy');
    
    // Rutas para experiencias laborales
    Route::post('/informacion/experiencias-laborales', [PersonalProfileController::class, 'storeWorkExperience'])->name('profile.work-experiences.store');
    Route::delete('/informacion/experiencias-laborales/{workExperience}', [PersonalProfileController::class, 'destroyWorkExperience'])->name('profile.work-experiences.destroy');
    
    // Rutas para referencias personales
    Route::post('/informacion/referencias-personales', [PersonalProfileController::class, 'storePersonalReference'])->name('profile.personal-references.store');
    Route::delete('/informacion/referencias-personales/{personalReference}', [PersonalProfileController::class, 'destroyPersonalReference'])->name('profile.personal-references.destroy');
    
    // AJAX
    Route::get('/districts-by-municipality', [PersonalProfileController::class, 'getDistrictsByMunicipality'])->name('districts-by-municipality');
});

// Rutas para empresas (solo su propia información)
Route::middleware(['auth', 'company.owns'])->prefix('empresa')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
    
    // Rutas para personas de la empresa
    Route::get('/people/districts-by-municipality', [CompanyPersonController::class, 'getDistrictsByMunicipality'])
        ->name('people.districts-by-municipality');
    Route::resource('people', CompanyPersonController::class)->names('people');
    Route::patch('/people/{person}/aspiration', [CompanyPersonController::class, 'updateAspiration'])
        ->name('people.update-aspiration');
    Route::patch('/people/{person}/personal-info', [CompanyPersonController::class, 'updatePersonalInfo'])
        ->name('people.update-personal-info');
    Route::patch('/people/{person}/residence-info', [CompanyPersonController::class, 'updateResidenceInfo'])
        ->name('people.update-residence-info');
    Route::post('/people/{person}/educational-skills', [CompanyPersonController::class, 'storeEducationalSkill'])
        ->name('people.educational-skills.store');
    Route::delete('/people/{person}/educational-skills/{educationalSkill}', [CompanyPersonController::class, 'destroyEducationalSkill'])
        ->name('people.educational-skills.destroy');
    Route::post('/people/{person}/work-experiences', [CompanyPersonController::class, 'storeWorkExperience'])
        ->name('people.work-experiences.store');
    Route::delete('/people/{person}/work-experiences/{workExperience}', [CompanyPersonController::class, 'destroyWorkExperience'])
        ->name('people.work-experiences.destroy');
    Route::post('/people/{person}/personal-references', [CompanyPersonController::class, 'storePersonalReference'])
        ->name('people.personal-references.store');
    Route::delete('/people/{person}/personal-references/{personalReference}', [CompanyPersonController::class, 'destroyPersonalReference'])
        ->name('people.personal-references.destroy');
    
    // Rutas para depuraciones de la empresa (requiere pago activo)
    Route::middleware('work-integrity.payment')->group(function () {
        Route::resource('work-integrities', CompanyWorkIntegrityController::class)->names('work-integrities');
    });
});

Route::get('/dashboard', function () {
    $stats = [
        'people_count' => \App\Models\Person::count(),
        'companies_count' => \App\Models\Company::count(),
        'recruiters_count' => \App\Models\Recruiter::count(),
        'work_integrities_count' => \App\Models\WorkIntegrity::count(),
    ];
    
    return view('dashboard', $stats);
})->middleware(['auth', 'verified', 'permission:dashboard.view'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para el módulo de Personas Individuales
    Route::middleware(['module.access:people'])->group(function () {
        // Rutas específicas primero (para evitar conflictos)
        Route::get('/people/districts-by-municipality', [PersonController::class, 'getDistrictsByMunicipality'])->name('people.districts-by-municipality');
        Route::get('/people-api', [PersonController::class, 'api'])->name('people.api');
        Route::get('/people-statistics', [PersonController::class, 'statistics'])->name('people.statistics');
        Route::post('/people/export-pdf', [PersonController::class, 'exportToPdf'])->name('people.export-pdf')
            ->middleware('permission:people.export');
        
        // Rutas de solo lectura (sin middleware adicional)
        Route::get('/people', [PersonController::class, 'index'])->name('people.index');
        
        // Rutas que requieren permisos específicos
        Route::get('/people/create', [PersonController::class, 'create'])->name('people.create')
            ->middleware('permission:people.create');
        Route::post('/people', [PersonController::class, 'store'])->name('people.store')
            ->middleware('permission:people.create');
        
        // Rutas con parámetros (al final para evitar conflictos)
        Route::get('/people/{person}', [PersonController::class, 'show'])->name('people.show');
        Route::get('/people/{person}/edit', [PersonController::class, 'edit'])->name('people.edit')
            ->middleware('permission:people.edit');
        Route::put('/people/{person}', [PersonController::class, 'update'])->name('people.update')
            ->middleware('permission:people.edit');
        Route::patch('/people/{person}', [PersonController::class, 'update'])->name('people.update');
        Route::delete('/people/{person}', [PersonController::class, 'destroy'])->name('people.destroy')
            ->middleware('permission:people.delete');
        
        // Rutas adicionales con parámetros y validaciones específicas
        Route::patch('/people/{person}/personal-info', [PersonController::class, 'updatePersonalInfo'])
            ->name('people.update-personal-info')
            ->middleware('permission:people.update-personal-info,Person');
        Route::patch('/people/{person}/residence-info', [PersonController::class, 'updateResidenceInfo'])
            ->name('people.update-residence-info')
            ->middleware('permission:people.update-residence-info,Person');
        Route::patch('/people/{person}/aspiration', [PersonController::class, 'updateAspiration'])
            ->name('people.update-aspiration')
            ->middleware('permission:people.update-aspiration,Person');
        Route::post('/people/{person}/educational-skills', [PersonController::class, 'storeEducationalSkill'])
            ->name('people.educational-skills.store')
            ->middleware('permission:people.manage-educational-skills,Person');
        Route::delete('/people/{person}/educational-skills/{educationalSkill}', [PersonController::class, 'destroyEducationalSkill'])
            ->name('people.educational-skills.destroy')
            ->middleware('permission:people.manage-educational-skills,Person');
        Route::post('/people/{person}/work-experiences', [PersonController::class, 'storeWorkExperience'])
            ->name('people.work-experiences.store')
            ->middleware('permission:people.manage-work-experiences,Person');
        Route::delete('/people/{person}/work-experiences/{workExperience}', [PersonController::class, 'destroyWorkExperience'])
            ->name('people.work-experiences.destroy')
            ->middleware('permission:people.manage-work-experiences,Person');
        Route::post('/people/{person}/personal-references', [PersonController::class, 'storePersonalReference'])
            ->name('people.personal-references.store')
            ->middleware('permission:people.manage-personal-references,Person');
        Route::delete('/people/{person}/personal-references/{personalReference}', [PersonController::class, 'destroyPersonalReference'])
            ->name('people.personal-references.destroy')
            ->middleware('permission:people.manage-personal-references,Person');
    });
    
    // Rutas para el módulo de Empresas
    Route::middleware(['module.access:companies'])->group(function () {
        // Rutas específicas primero (para evitar conflictos)
        Route::get('/companies/check-rnc/{rnc}', [CompanyController::class, 'checkRnc'])->name('companies.check-rnc')
            ->middleware('permission:companies.check-rnc');
        Route::get('/companies/municipalities/{province}', [CompanyController::class, 'getMunicipalities'])->name('companies.municipalities');
        Route::post('/companies/export-pdf', [CompanyController::class, 'exportToPdf'])->name('companies.export-pdf')
            ->middleware('permission:companies.export');
        
        // Rutas de solo lectura (sin middleware adicional)
        Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
        
        // Rutas que requieren permisos específicos
        Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create')
            ->middleware('permission:companies.create');
        Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store')
            ->middleware('permission:companies.create');
        
        // Rutas con parámetros (al final para evitar conflictos)
        Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
        Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit')
            ->middleware('permission:companies.edit');
        Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update')
            ->middleware('permission:companies.edit');
        Route::patch('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy')
            ->middleware('permission:companies.delete');
    });
    
    // Rutas para el módulo de Reclutadores
    Route::middleware(['module.access:recruiters'])->group(function () {
        // Rutas específicas primero (para evitar conflictos)
        Route::get('/recruiters/search-by-rnc', [RecruiterController::class, 'searchByRnc'])->name('recruiters.search-by-rnc');
        Route::get('/recruiters/search-by-dni', [RecruiterController::class, 'searchByDni'])->name('recruiters.search-by-dni');
        Route::get('/recruiters/search-companies', [RecruiterController::class, 'searchCompanies'])->name('recruiters.search-companies');
        Route::get('/recruiters/search-people', [RecruiterController::class, 'searchPeople'])->name('recruiters.search-people');
        Route::post('/recruiters/export-pdf', [RecruiterController::class, 'exportToPdf'])->name('recruiters.export-pdf')
            ->middleware('permission:recruiters.export');
        
        // Rutas de solo lectura (sin middleware adicional)
        Route::get('/recruiters', [RecruiterController::class, 'index'])->name('recruiters.index');
        
        // Rutas que requieren permisos específicos
        Route::get('/recruiters/create', [RecruiterController::class, 'create'])->name('recruiters.create')
            ->middleware('permission:recruiters.create');
        Route::post('/recruiters', [RecruiterController::class, 'store'])->name('recruiters.store')
            ->middleware('permission:recruiters.create');
        
        // Rutas con parámetros (al final para evitar conflictos)
        Route::get('/recruiters/{recruiter}', [RecruiterController::class, 'show'])->name('recruiters.show');
        Route::get('/recruiters/{recruiter}/edit', [RecruiterController::class, 'edit'])->name('recruiters.edit')
            ->middleware('permission:recruiters.edit');
        Route::put('/recruiters/{recruiter}', [RecruiterController::class, 'update'])->name('recruiters.update')
            ->middleware('permission:recruiters.edit');
        Route::patch('/recruiters/{recruiter}', [RecruiterController::class, 'update'])->name('recruiters.update');
        Route::delete('/recruiters/{recruiter}', [RecruiterController::class, 'destroy'])->name('recruiters.destroy')
            ->middleware('permission:recruiters.delete');
    });
    
    // Rutas para el módulo de Integridad Laboral
    Route::middleware(['module.access:work-integrities'])->group(function () {
        // Rutas específicas primero (para evitar conflictos)
        Route::get('/work-integrities/search-companies', [WorkIntegrityController::class, 'searchCompanies'])->name('work-integrities.search-companies');
        Route::get('/work-integrities/search-company', [WorkIntegrityController::class, 'searchCompanyByRnc'])->name('work-integrities.search-company');
        Route::post('/work-integrities/create-company', [WorkIntegrityController::class, 'createCompany'])->name('work-integrities.create-company')
            ->middleware('permission:work-integrities.create');
        Route::post('/work-integrities/create-person', [WorkIntegrityController::class, 'createPerson'])->name('work-integrities.create-person')
            ->middleware('permission:work-integrities.create');
        Route::get('/work-integrities/municipalities/{provinceId}', [WorkIntegrityController::class, 'getMunicipalities'])->name('work-integrities.municipalities');
        Route::get('/work-integrities/search-people', [WorkIntegrityController::class, 'searchPeople'])->name('work-integrities.search-people');
        Route::get('/work-integrities/search-person', [WorkIntegrityController::class, 'searchPersonByDni'])->name('work-integrities.search-person');
        Route::get('/work-integrities/reference-codes', [WorkIntegrityController::class, 'getReferenceCodesByCertification'])->name('work-integrities.reference-codes');
        Route::get('/work-integrities/person/{person}', [WorkIntegrityController::class, 'showPersonIntegrations'])->name('work-integrities.person.show');
        
        // Rutas de solo lectura (sin middleware adicional)
        Route::get('/work-integrities', [WorkIntegrityController::class, 'index'])->name('work-integrities.index');
        
        // Rutas que requieren permisos específicos
        Route::get('/work-integrities/create', [WorkIntegrityController::class, 'create'])->name('work-integrities.create')
            ->middleware('permission:work-integrities.create');
        Route::post('/work-integrities', [WorkIntegrityController::class, 'store'])->name('work-integrities.store')
            ->middleware('permission:work-integrities.create');
        
        // Rutas con parámetros (al final para evitar conflictos)
        Route::get('/work-integrities/{workIntegrity}', [WorkIntegrityController::class, 'show'])->name('work-integrities.show');
        Route::get('/work-integrities/{workIntegrity}/edit', [WorkIntegrityController::class, 'edit'])->name('work-integrities.edit')
            ->middleware('permission:work-integrities.edit');
        Route::put('/work-integrities/{workIntegrity}', [WorkIntegrityController::class, 'update'])->name('work-integrities.update')
            ->middleware('permission:work-integrities.edit');
        Route::patch('/work-integrities/{workIntegrity}', [WorkIntegrityController::class, 'update'])->name('work-integrities.update');
        Route::delete('/work-integrities/{workIntegrity}', [WorkIntegrityController::class, 'destroy'])->name('work-integrities.destroy')
            ->middleware('permission:work-integrities.delete');
    });
    
    // Rutas para el módulo de Configuraciones
    Route::prefix('configuraciones')->name('config.')->middleware(['admin-access'])->group(function () {
        // Tipos de Depuración
        Route::resource('certifications', CertificationController::class)->names('certifications')
            ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])
            ->middleware([
                'create' => 'permission:certifications.create',
                'store' => 'permission:certifications.create',
                'edit' => 'permission:certifications.edit',
                'update' => 'permission:certifications.edit',
                'destroy' => 'permission:certifications.delete'
            ]);
        
        // Códigos de Referencias
        Route::resource('reference-codes', ReferenceCodeController::class)->names('reference-codes')
            ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])
            ->middleware([
                'create' => 'permission:reference-codes.create',
                'store' => 'permission:reference-codes.create',
                'edit' => 'permission:reference-codes.edit',
                'update' => 'permission:reference-codes.edit',
                'destroy' => 'permission:reference-codes.delete'
            ]);
        
        // Roles
        Route::resource('roles', RoleController::class)->names('roles')
            ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])
            ->middleware([
                'create' => 'permission:roles.create',
                'store' => 'permission:roles.create',
                'edit' => 'permission:roles.edit',
                'update' => 'permission:roles.edit',
                'destroy' => 'permission:roles.delete'
            ]);
        
        // Usuarios
        Route::resource('users', UserController::class)->names('users')
            ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])
            ->middleware([
                'create' => 'permission:users.create',
                'store' => 'permission:users.create',
                'edit' => 'permission:users.edit',
                'update' => 'permission:users.edit',
                'destroy' => 'permission:users.delete'
            ]);
    });
    
    // Ruta temporal para pruebas de toast
    Route::get('/test-toast', function () {
        return view('test-toast');
    })->name('test-toast');
});

require __DIR__.'/auth.php';
