<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Configuraciones - Crear Código de Referencia
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
                    <form action="{{ route('config.reference-codes.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-3 gap-4">
                            <!-- Código -->
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="code" 
                                    id="code"
                                    value="{{ old('code') }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: PROC-001"
                                >
                                @error('code')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Resultado -->
                            <div>
                                <label for="result" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Resultado <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="result" 
                                    id="result"
                                    value="{{ old('result') }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: Aprobado, Sin Antecedentes, etc."
                                >
                                @error('result')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Resultado Real -->
                            <div>
                                <label for="actual_result" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Resultado Real
                                </label>
                                <input 
                                    type="text" 
                                    name="actual_result" 
                                    id="actual_result"
                                    value="{{ old('actual_result') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Resultado real (opcional)"
                                >
                                @error('actual_result')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
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
                                Crear Código de Referencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

