<?php

namespace App\Helpers;

class PermissionHelper
{
    /**
     * Obtener el nombre en español de un módulo
     */
    public static function getModuleName(string $module): string
    {
        $modules = [
            'dashboard' => 'Panel Principal',
            'people' => 'Personas',
            'companies' => 'Empresas',
            'certifications' => 'Certificaciones',
            'reference-codes' => 'Códigos de Referencias',
            'roles' => 'Roles y Permisos',
            'users' => 'Usuarios',
            'profile' => 'Mi Perfil',
            'user' => 'Perfil de Usuario',
            'company' => 'Empresa',
            'person-registration' => 'Registro Público',
        ];

        return $modules[$module] ?? ucfirst($module);
    }

    /**
     * Obtener el icono de un módulo
     */
    public static function getModuleIcon(string $module): string
    {
        $icons = [
            'dashboard' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
            'people' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
            'companies' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
            'certifications' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>',
            'reference-codes' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>',
            'roles' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
            'users' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
            'profile' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
            'user' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
            'company' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
            'person-registration' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
        ];

        return $icons[$module] ?? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>';
    }

    /**
     * Obtener el nombre en español de una acción de permiso
     */
    public static function getPermissionLabel(string $permissionName): string
    {
        // Extraer la acción del nombre del permiso
        $parts = explode('.', $permissionName);
        $action = end($parts);

        $actions = [
            'index' => 'Ver Listado',
            'create' => 'Crear',
            'show' => 'Ver Detalle',
            'edit' => 'Editar',
            'delete' => 'Eliminar',
            'update' => 'Actualizar',
            'view' => 'Ver',
            'api' => 'Acceso API',
            'statistics' => 'Ver Estadísticas',
            'check-rnc' => 'Verificar RNC',
            'assign-roles' => 'Asignar Roles',
            'update-personal-info' => 'Actualizar Info Personal',
            'update-residence-info' => 'Actualizar Info Residencia',
            'update-aspiration' => 'Actualizar Aspiraciones',
            'manage-educational-skills' => 'Gestionar Formación',
            'manage-work-experiences' => 'Gestionar Experiencias',
            'manage-personal-references' => 'Gestionar Referencias',
            'export' => 'Exportar a PDF',
            'view-actual-results' => 'Ver Resultados Reales',
            'assign-permissions' => 'Asignar Permisos Directos',
            'generate-cv' => 'Generar CV',
            'update-personal-info' => 'Actualizar Info Personal',
            'update-residence-info' => 'Actualizar Info Residencia',
            'update-aspiration' => 'Actualizar Aspiraciones',
        ];

        return $actions[$action] ?? ucfirst(str_replace('-', ' ', $action));
    }

    /**
     * Obtener el color de un módulo
     */
    public static function getModuleColor(string $module): array
    {
        $colors = [
            'dashboard' => [
                'bg' => 'bg-blue-50 dark:bg-blue-900/20',
                'border' => 'border-blue-200 dark:border-blue-800',
                'text' => 'text-blue-700 dark:text-blue-300',
                'icon' => 'text-blue-600 dark:text-blue-400',
            ],
            'people' => [
                'bg' => 'bg-purple-50 dark:bg-purple-900/20',
                'border' => 'border-purple-200 dark:border-purple-800',
                'text' => 'text-purple-700 dark:text-purple-300',
                'icon' => 'text-purple-600 dark:text-purple-400',
            ],
            'companies' => [
                'bg' => 'bg-indigo-50 dark:bg-indigo-900/20',
                'border' => 'border-indigo-200 dark:border-indigo-800',
                'text' => 'text-indigo-700 dark:text-indigo-300',
                'icon' => 'text-indigo-600 dark:text-indigo-400',
            ],
            'certifications' => [
                'bg' => 'bg-green-50 dark:bg-green-900/20',
                'border' => 'border-green-200 dark:border-green-800',
                'text' => 'text-green-700 dark:text-green-300',
                'icon' => 'text-green-600 dark:text-green-400',
            ],
            'reference-codes' => [
                'bg' => 'bg-orange-50 dark:bg-orange-900/20',
                'border' => 'border-orange-200 dark:border-orange-800',
                'text' => 'text-orange-700 dark:text-orange-300',
                'icon' => 'text-orange-600 dark:text-orange-400',
            ],
            'roles' => [
                'bg' => 'bg-red-50 dark:bg-red-900/20',
                'border' => 'border-red-200 dark:border-red-800',
                'text' => 'text-red-700 dark:text-red-300',
                'icon' => 'text-red-600 dark:text-red-400',
            ],
            'users' => [
                'bg' => 'bg-pink-50 dark:bg-pink-900/20',
                'border' => 'border-pink-200 dark:border-pink-800',
                'text' => 'text-pink-700 dark:text-pink-300',
                'icon' => 'text-pink-600 dark:text-pink-400',
            ],
            'profile' => [
                'bg' => 'bg-gray-50 dark:bg-gray-700/50',
                'border' => 'border-gray-200 dark:border-gray-600',
                'text' => 'text-gray-700 dark:text-gray-300',
                'icon' => 'text-gray-600 dark:text-gray-400',
            ],
            'user' => [
                'bg' => 'bg-cyan-50 dark:bg-cyan-900/20',
                'border' => 'border-cyan-200 dark:border-cyan-800',
                'text' => 'text-cyan-700 dark:text-cyan-300',
                'icon' => 'text-cyan-600 dark:text-cyan-400',
            ],
            'company' => [
                'bg' => 'bg-teal-50 dark:bg-teal-900/20',
                'border' => 'border-teal-200 dark:border-teal-800',
                'text' => 'text-teal-700 dark:text-teal-300',
                'icon' => 'text-teal-600 dark:text-teal-400',
            ],
            'person-registration' => [
                'bg' => 'bg-amber-50 dark:bg-amber-900/20',
                'border' => 'border-amber-200 dark:border-amber-800',
                'text' => 'text-amber-700 dark:text-amber-300',
                'icon' => 'text-amber-600 dark:text-amber-400',
            ],
        ];

        return $colors[$module] ?? [
            'bg' => 'bg-gray-50 dark:bg-gray-700/50',
            'border' => 'border-gray-200 dark:border-gray-600',
            'text' => 'text-gray-700 dark:text-gray-300',
            'icon' => 'text-gray-600 dark:text-gray-400',
        ];
    }

    /**
     * Ordenar módulos según prioridad
     */
    public static function sortModules(array $modules): array
    {
        $order = [
            'dashboard' => 1,
            'people' => 2,
            'companies' => 3,
            'certifications' => 4,
            'reference-codes' => 5,
            'roles' => 6,
            'users' => 7,
            'profile' => 8,
            'user' => 9,
            'company' => 10,
            'person-registration' => 11,
        ];

        uksort($modules, function($a, $b) use ($order) {
            $orderA = $order[$a] ?? 999;
            $orderB = $order[$b] ?? 999;
            return $orderA <=> $orderB;
        });

        return $modules;
    }
}

