<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Resetear caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Definir permisos por módulo con descripciones en español
        $permissions = [
            // Dashboard
            'dashboard.view' => 'Ver Panel Principal',
            
            // Módulo de Personas
            'people.index' => 'Ver Listado de Personas',
            'people.create' => 'Crear Nueva Persona',
            'people.show' => 'Ver Detalle de Persona',
            'people.edit' => 'Editar Persona',
            'people.delete' => 'Eliminar Persona',
            'people.update-personal-info' => 'Actualizar Información Personal',
            'people.update-residence-info' => 'Actualizar Información de Residencia',
            'people.update-aspiration' => 'Actualizar Aspiraciones Laborales',
            'people.manage-educational-skills' => 'Gestionar Formación Académica',
            'people.manage-work-experiences' => 'Gestionar Experiencia Laboral',
            'people.manage-personal-references' => 'Gestionar Referencias Personales',
            'people.api' => 'Acceso API de Personas',
            'people.statistics' => 'Ver Estadísticas de Personas',
            'people.export' => 'Exportar Personas a PDF',
            
            // Módulo de Empresas
            'companies.index' => 'Ver Listado de Empresas',
            'companies.create' => 'Crear Nueva Empresa',
            'companies.show' => 'Ver Detalle de Empresa',
            'companies.edit' => 'Editar Empresa',
            'companies.delete' => 'Eliminar Empresa',
            'companies.check-rnc' => 'Verificar RNC de Empresa',
            'companies.export' => 'Exportar Empresas a PDF',
            
            // Módulo de Tipos de Depuración
            'certifications.index' => 'Ver Tipos de Depuración',
            'certifications.create' => 'Crear Tipo de Depuración',
            'certifications.show' => 'Ver Detalle de Tipo de Depuración',
            'certifications.edit' => 'Editar Tipo de Depuración',
            'certifications.delete' => 'Eliminar Tipo de Depuración',
            
            // Módulo de Códigos de Referencias
            'reference-codes.index' => 'Ver Códigos de Referencias',
            'reference-codes.create' => 'Crear Código de Referencia',
            'reference-codes.show' => 'Ver Detalle de Código',
            'reference-codes.edit' => 'Editar Código de Referencia',
            'reference-codes.delete' => 'Eliminar Código de Referencia',
            
            // Módulo de Reclutadores
            'recruiters.index' => 'Ver Listado de Reclutadores',
            'recruiters.create' => 'Crear Nuevo Reclutador',
            'recruiters.show' => 'Ver Detalle de Reclutador',
            'recruiters.edit' => 'Editar Reclutador',
            'recruiters.delete' => 'Eliminar Reclutador',
            'recruiters.export' => 'Exportar Reclutadores a PDF',
            
            // Módulo de Integridad Laboral
            'work-integrities.index' => 'Ver Listado de Depuraciones',
            'work-integrities.create' => 'Crear Nueva Depuración',
            'work-integrities.show' => 'Ver Detalle de Depuración',
            'work-integrities.edit' => 'Editar Depuración',
            'work-integrities.delete' => 'Eliminar Depuración',
            'work-integrities.view-actual-results' => 'Ver Resultados Reales en Depuraciones',
            
            // Módulo de Roles
            'roles.index' => 'Ver Listado de Roles',
            'roles.create' => 'Crear Nuevo Rol',
            'roles.show' => 'Ver Detalle de Rol',
            'roles.edit' => 'Editar Rol',
            'roles.delete' => 'Eliminar Rol',
            
            // Módulo de Usuarios
            'users.index' => 'Ver Listado de Usuarios',
            'users.create' => 'Crear Nuevo Usuario',
            'users.show' => 'Ver Detalle de Usuario',
            'users.edit' => 'Editar Usuario',
            'users.delete' => 'Eliminar Usuario',
            'users.assign-roles' => 'Asignar Roles a Usuarios',
            
            // Perfil
            'profile.edit' => 'Editar Mi Perfil',
            'profile.update' => 'Actualizar Mi Perfil',
            'profile.delete' => 'Eliminar Mi Cuenta',
        ];

        // Crear todos los permisos (si no existen)
        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web']
            );
        }

        // Crear rol de Super Administrador con todos los permisos
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Administrador']);
        $superAdminRole->syncPermissions(Permission::all());

        // Crear rol de Administrador con permisos básicos
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $adminRole->syncPermissions([
            'dashboard.view',
            'people.index',
            'people.create',
            'people.show',
            'people.edit',
            'people.update-personal-info',
            'people.update-residence-info',
            'people.update-aspiration',
            'people.manage-educational-skills',
            'people.manage-work-experiences',
            'people.manage-personal-references',
            'people.export',
            'companies.index',
            'companies.create',
            'companies.show',
            'companies.edit',
            'companies.check-rnc',
            'companies.export',
            'recruiters.index',
            'recruiters.create',
            'recruiters.show',
            'recruiters.edit',
            'recruiters.export',
            'work-integrities.index',
            'work-integrities.create',
            'work-integrities.show',
            'work-integrities.edit',
            'work-integrities.view-actual-results',
            'certifications.index',
            'certifications.create',
            'certifications.show',
            'certifications.edit',
            'certifications.delete',
            'reference-codes.index',
            'reference-codes.create',
            'reference-codes.show',
            'reference-codes.edit',
            'reference-codes.delete',
            'roles.index',
            'roles.create',
            'roles.show',
            'roles.edit',
            'roles.delete',
            'users.index',
            'users.create',
            'users.show',
            'users.edit',
            'users.delete',
            'profile.edit',
            'profile.update',
        ]);

        // Crear rol de Usuario con permisos de solo lectura
        $userRole = Role::firstOrCreate(['name' => 'Usuario']);
        $userRole->syncPermissions([
            'dashboard.view',
            'people.index',
            'people.show',
            'companies.index',
            'companies.show',
            'recruiters.index',
            'recruiters.show',
            'work-integrities.index',
            'work-integrities.show',
            'profile.edit',
            'profile.update',
        ]);

        $this->command->info('Permisos creados correctamente.');
        $this->command->info('Roles creados: Super Administrador, Administrador, Usuario.');
    }
}

