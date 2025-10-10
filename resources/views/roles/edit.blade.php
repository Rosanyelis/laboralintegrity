@php
    use App\Helpers\PermissionHelper;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Rol: ') . $role->name }}
            </h2>
            <a href="{{ route('config.roles.index') }}" 
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('config.roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nombre del Rol -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                Nombre del Rol <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                value="{{ old('name', $role->name) }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Ej: Administrador de Recursos Humanos"
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Separador -->
                        <hr class="border-gray-200 dark:border-gray-700 my-6">

                        <!-- Sección de Permisos -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Permisos del Rol
                                </h3>
                                <div class="flex space-x-2">
                                    <button 
                                        type="button" 
                                        onclick="selectAllPermissions()" 
                                        class="px-3 py-1.5 text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-md hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors"
                                    >
                                        Seleccionar Todos
                                    </button>
                                    <button 
                                        type="button" 
                                        onclick="deselectAllPermissions()" 
                                        class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                                    >
                                        Deseleccionar Todos
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($groupedPermissions as $module => $permissions)
                                    @php
                                        $colors = PermissionHelper::getModuleColor($module);
                                        $icon = PermissionHelper::getModuleIcon($module);
                                        $moduleName = PermissionHelper::getModuleName($module);
                                    @endphp
                                    <div class="{{ $colors['bg'] }} rounded-lg p-4 border {{ $colors['border'] }} hover:shadow-md transition-shadow duration-200">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center space-x-2">
                                                <div class="{{ $colors['icon'] }}">
                                                    {!! $icon !!}
                                                </div>
                                                <h4 class="font-semibold {{ $colors['text'] }} text-sm">
                                                    {{ $moduleName }}
                                                </h4>
                                            </div>
                                            <button 
                                                type="button" 
                                                onclick="toggleModulePermissions('{{ $module }}')" 
                                                class="text-xs {{ $colors['text'] }} hover:underline font-medium"
                                                title="Seleccionar/Deseleccionar todos los permisos de este módulo"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="space-y-1">
                                            @foreach($permissions as $permission)
                                                <label class="flex items-start space-x-2 text-sm {{ $colors['text'] }} hover:bg-white dark:hover:bg-gray-800/50 p-2 rounded cursor-pointer transition-all duration-150 group">
                                                    <input 
                                                        type="checkbox" 
                                                        name="permissions[]" 
                                                        value="{{ $permission['name'] }}"
                                                        data-module="{{ $module }}"
                                                        class="mt-0.5 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700"
                                                        {{ in_array($permission['name'], old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                                    >
                                                    <span class="flex-1 group-hover:font-medium transition-all">
                                                        {{ PermissionHelper::getPermissionLabel($permission['name']) }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="mt-3 pt-3 border-t {{ $colors['border'] }}">
                                            <span class="text-xs {{ $colors['text'] }} opacity-75">
                                                {{ count($permissions) }} {{ count($permissions) == 1 ? 'permiso' : 'permisos' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @error('permissions')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('config.roles.index') }}" 
                               class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Actualizar Rol
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAllPermissions() {
            document.querySelectorAll('input[type="checkbox"][name="permissions[]"]').forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function deselectAllPermissions() {
            document.querySelectorAll('input[type="checkbox"][name="permissions[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        function toggleModulePermissions(module) {
            const moduleCheckboxes = document.querySelectorAll(`input[type="checkbox"][data-module="${module}"]`);
            const allChecked = Array.from(moduleCheckboxes).every(cb => cb.checked);
            
            moduleCheckboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }
    </script>
</x-app-layout>

