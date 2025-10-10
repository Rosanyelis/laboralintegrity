<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Usuario: ') . $user->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('config.users.edit', $user) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Editar</span>
                </a>
                <a href="{{ route('config.users.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors duration-150">
                    Volver al Listado
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Información del Usuario -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Información General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre de Usuario</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Rol Asignado</label>
                            <p class="mt-1">
                                @if($user->roles->isNotEmpty())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $user->roles->first()->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">Sin rol asignado</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estado</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Activo
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Última Actualización</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Persona Asociada -->
            @if($user->person)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Persona Asociada</h3>
                            <a href="{{ route('people.show', $user->person) }}" 
                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                Ver perfil completo →
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                    {{ $user->person->name }} {{ $user->person->last_name }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Cédula</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->person->dni }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Código Único</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->person->code_unique }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Edad</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->person->age ?? 'N/A' }} años</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->person->cell_phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Correo Personal</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $user->person->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin persona asociada</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Este usuario no tiene una persona asociada.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Permisos del Rol -->
            @if($user->roles->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Permisos del Rol: {{ $user->roles->first()->name }}
                        </h3>
                        @php
                            $permissions = $user->roles->first()->permissions;
                        @endphp
                        @if($permissions->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($permissions as $permission)
                                    <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>{{ $permission->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Este rol no tiene permisos asignados.</p>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

