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
            
            // Módulo de Empresas
            'companies.index' => 'Ver Listado de Empresas',
            'companies.create' => 'Crear Nueva Empresa',
            'companies.show' => 'Ver Detalle de Empresa',
            'companies.edit' => 'Editar Empresa',
            'companies.delete' => 'Eliminar Empresa',
            'companies.check-rnc' => 'Verificar RNC de Empresa',
            
            // Módulo de Certificaciones
            'certifications.index' => 'Ver Tipos de Certificación',
            'certifications.create' => 'Crear Tipo de Certificación',
            'certifications.show' => 'Ver Detalle de Certificación',
            'certifications.edit' => 'Editar Tipo de Certificación',
            'certifications.delete' => 'Eliminar Tipo de Certificación',
            
            // Módulo de Códigos de Referencias
            'reference-codes.index' => 'Ver Códigos de Referencias',
            'reference-codes.create' => 'Crear Código de Referencia',
            'reference-codes.show' => 'Ver Detalle de Código',
            'reference-codes.edit' => 'Editar Código de Referencia',
            'reference-codes.delete' => 'Eliminar Código de Referencia',
            
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

        // Crear todos los permisos
        foreach ($permissions as $name => $description) {
            Permission::create([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Crear rol de Super Administrador con todos los permisos
        $superAdminRole = Role::create(['name' => 'Super Administrador']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Crear rol de Administrador con permisos básicos
        $adminRole = Role::create(['name' => 'Administrador']);
        $adminRole->givePermissionTo([
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
            'companies.index',
            'companies.create',
            'companies.show',
            'companies.edit',
            'companies.check-rnc',
            'certifications.index',
            'certifications.show',
            'reference-codes.index',
            'reference-codes.create',
            'reference-codes.show',
            'reference-codes.edit',
            'profile.edit',
            'profile.update',
        ]);

        // Crear rol de Usuario con permisos de solo lectura
        $userRole = Role::create(['name' => 'Usuario']);
        $userRole->givePermissionTo([
            'dashboard.view',
            'people.index',
            'people.show',
            'companies.index',
            'companies.show',
            'certifications.index',
            'certifications.show',
            'reference-codes.index',
            'reference-codes.show',
            'profile.edit',
            'profile.update',
        ]);

        $this->command->info('Permisos creados correctamente.');
        $this->command->info('Roles creados: Super Administrador, Administrador, Usuario.');
    }
}

