<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Personal Individual - Editar Persona
            </h2>
            <a href="{{ route('people.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                Volver a Consulta
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('people.update', $person) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información Personal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre *
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $person->name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Apellido *
                                </label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $person->last_name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email *
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $person->email) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cell_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Teléfono Celular
                                </label>
                                <input type="text" name="cell_phone" id="cell_phone" value="{{ old('cell_phone', $person->cell_phone) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('cell_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="home_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Teléfono Casa
                                </label>
                                <input type="text" name="home_phone" id="home_phone" value="{{ old('home_phone', $person->home_phone) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('home_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Información Demográfica -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fecha de Nacimiento
                                </label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $person->birth_date?->format('Y-m-d')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Edad
                                </label>
                                <input type="number" name="age" id="age" value="{{ old('age', $person->age) }}" min="0" max="120"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('age')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="marital_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Estado Civil
                                </label>
                                <select name="marital_status" id="marital_status" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="soltero" {{ old('marital_status', $person->marital_status) == 'soltero' ? 'selected' : '' }}>Soltero</option>
                                    <option value="casado" {{ old('marital_status', $person->marital_status) == 'casado' ? 'selected' : '' }}>Casado</option>
                                    <option value="viudo" {{ old('marital_status', $person->marital_status) == 'viudo' ? 'selected' : '' }}>Viudo</option>
                                </select>
                                @error('marital_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Información Laboral -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="position_applied_for" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Posición Solicitada
                                </label>
                                <input type="text" name="position_applied_for" id="position_applied_for" value="{{ old('position_applied_for', $person->position_applied_for) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('position_applied_for')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Empresa
                                </label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $person->company_name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código Empresa
                                </label>
                                <input type="text" name="company_code" id="company_code" value="{{ old('company_code', $person->company_code) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('company_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Estados del Sistema -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="verification_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Estado de Verificación
                                </label>
                                <select name="verification_status" id="verification_status" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="pendiente" {{ old('verification_status', $person->verification_status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="parcial" {{ old('verification_status', $person->verification_status) == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                    <option value="no_aplica" {{ old('verification_status', $person->verification_status) == 'no_aplica' ? 'selected' : '' }}>No Aplica</option>
                                    <option value="certificado" {{ old('verification_status', $person->verification_status) == 'certificado' ? 'selected' : '' }}>Certificado</option>
                                </select>
                                @error('verification_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="employment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Estado de Empleo
                                </label>
                                <select name="employment_status" id="employment_status" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="pendiente" {{ old('employment_status', $person->employment_status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="disponible" {{ old('employment_status', $person->employment_status) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                    <option value="en_proceso" {{ old('employment_status', $person->employment_status) == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="contratado" {{ old('employment_status', $person->employment_status) == 'contratado' ? 'selected' : '' }}>Contratado</option>
                                    <option value="part_time" {{ old('employment_status', $person->employment_status) == 'part_time' ? 'selected' : '' }}>Tiempo Parcial</option>
                                    <option value="despido" {{ old('employment_status', $person->employment_status) == 'despido' ? 'selected' : '' }}>Despido</option>
                                    <option value="desaucio" {{ old('employment_status', $person->employment_status) == 'desaucio' ? 'selected' : '' }}>Desahucio</option>
                                    <option value="renuncia" {{ old('employment_status', $person->employment_status) == 'renuncia' ? 'selected' : '' }}>Renuncia</option>
                                    <option value="aplica" {{ old('employment_status', $person->employment_status) == 'aplica' ? 'selected' : '' }}>Aplica</option>
                                    <option value="no_aplica" {{ old('employment_status', $person->employment_status) == 'no_aplica' ? 'selected' : '' }}>No Aplica</option>
                                </select>
                                @error('employment_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('people.index') }}" 
                               class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Persona
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>