<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Configuraciones - Editar Código de Referencia
            </h2>
            <a href="{{ route('config.reference-codes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Volver a Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('config.reference-codes.update', $referenceCode) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipo de Certificación -->
                            <div class="md:col-span-2">
                                <label for="certification_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tipo de Certificación <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="certification_id" 
                                    id="certification_id"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="">Seleccione un tipo de certificación...</option>
                                    @foreach($certifications as $certification)
                                        <option value="{{ $certification->id }}" {{ old('certification_id', $referenceCode->certification_id) == $certification->id ? 'selected' : '' }}>
                                            {{ $certification->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('certification_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Código -->
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="code" 
                                    id="code"
                                    value="{{ old('code', $referenceCode->code) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: PROC-001"
                                >
                                @error('code')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nombre -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name"
                                    value="{{ old('name', $referenceCode->name) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: Procedimientos Judiciales"
                                >
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Resultado -->
                            <div class="md:col-span-2">
                                <label for="result" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Resultado <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="result" 
                                    id="result"
                                    value="{{ old('result', $referenceCode->result) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: Aprobado, Sin Antecedentes, etc."
                                >
                                @error('result')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Descripción
                                </label>
                                <textarea 
                                    name="description" 
                                    id="description"
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Descripción adicional (opcional)"
                                >{{ old('description', $referenceCode->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Estado Activo -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="is_active" 
                                        id="is_active"
                                        value="1"
                                        {{ old('is_active', $referenceCode->is_active) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    >
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Activo</span>
                                </label>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('config.reference-codes.index') }}" 
                               class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Código de Referencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

