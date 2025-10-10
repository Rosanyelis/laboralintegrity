<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Usuario: ') . $user->name }}
            </h2>
            <a href="{{ route('config.users.index') }}" 
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('config.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Seleccionar Persona -->
                        <div class="mb-6">
                            <x-select-search
                                name="person_id"
                                id="person_id"
                                label="Persona"
                                placeholder="Seleccione una persona"
                                searchPlaceholder="Buscar por nombre o cédula..."
                                emptyMessage="No hay personas disponibles"
                                :options="$availablePeople->map(function($person) {
                                    return [
                                        'value' => $person->id,
                                        'text' => $person->name . ' ' . $person->last_name . ' - ' . $person->dni
                                    ];
                                })->toArray()"
                                :selected="old('person_id', $user->person_id)"
                                :required="true"
                                :error="$errors->first('person_id')"
                            />
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                Correo Electrónico <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="usuario@ejemplo.com"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div class="mb-6">
                            <x-select-search
                                name="role_id"
                                id="role_id"
                                label="Rol"
                                placeholder="Seleccione un rol"
                                searchPlaceholder="Buscar rol..."
                                emptyMessage="No hay roles disponibles"
                                :options="$roles->map(function($role) {
                                    return [
                                        'value' => $role->id,
                                        'text' => $role->name
                                    ];
                                })->toArray()"
                                :selected="old('role_id', $userRole?->id)"
                                :required="true"
                                :error="$errors->first('role_id')"
                            />
                        </div>

                        <!-- Separador -->
                        <hr class="border-gray-200 dark:border-gray-700 my-6">

                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cambiar Contraseña (Opcional)</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Deje los campos en blanco si no desea cambiar la contraseña.</p>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="••••••••"
                            >
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                Confirmar Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="••••••••"
                            >
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('config.users.index') }}" 
                               class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

