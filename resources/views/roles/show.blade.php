<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Rol: ') . $role->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('config.roles.edit', $role) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Editar</span>
                </a>
                <a href="{{ route('config.roles.index') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                    Volver al Listado
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Información del Rol -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Información General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre del Rol</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $role->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Total de Permisos</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ $role->permissions->count() }} permiso{{ $role->permissions->count() != 1 ? 's' : '' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $role->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Última Actualización</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $role->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permisos del Rol -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Permisos Asignados</h3>
                    
                    @if($role->permissions->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                use App\Helpers\PermissionHelper;
                            @endphp
                            @foreach($groupedPermissions as $module => $permissions)
                                @php
                                    $colors = PermissionHelper::getModuleColor($module);
                                    $icon = PermissionHelper::getModuleIcon($module);
                                    $moduleName = PermissionHelper::getModuleName($module);
                                @endphp
                                <div class="{{ $colors['bg'] }} rounded-lg p-4 border {{ $colors['border'] }}">
                                    <div class="flex items-center space-x-2 mb-3">
                                        <div class="{{ $colors['icon'] }}">
                                            {!! $icon !!}
                                        </div>
                                        <h4 class="font-semibold {{ $colors['text'] }} text-sm">
                                            {{ $moduleName }}
                                            <span class="text-xs font-normal opacity-75">({{ count($permissions) }})</span>
                                        </h4>
                                    </div>
                                    <ul class="space-y-2">
                                        @foreach($permissions as $permission)
                                            <li class="flex items-start space-x-2 text-sm {{ $colors['text'] }}">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>{{ PermissionHelper::getPermissionLabel($permission->name) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin permisos asignados</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Este rol no tiene ningún permiso asignado.</p>
                            <div class="mt-6">
                                <a href="{{ route('config.roles.edit', $role) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Asignar Permisos
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

