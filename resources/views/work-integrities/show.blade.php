<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Integridad Laboral') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('work-integrities.edit', $workIntegrity) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Editar</span>
                </a>
                <a href="{{ route('work-integrities.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors duration-150">
                    Volver al Listado
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Información General -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Información General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->fecha->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Registrado por</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->creator?->name ?? 'N/A' }}</p>
                        </div>
                        @if($workIntegrity->resultado)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Resultado</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $workIntegrity->resultado }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Datos de la Empresa -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos de la Empresa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Código Empresa</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_code ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre de Empresa</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Sucursal</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_branch ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Empresa</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Correo Empresa</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <!-- Datos del Representante -->
                    @if($workIntegrity->representative_name)
                        <hr class="border-gray-200 dark:border-gray-700 my-6">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos del Representante</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->representative_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->representative_phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Correo</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->representative_email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Datos de la Persona -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos de la Persona</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Cédula</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->person_dni }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</label>
                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->person_name }}</p>
                        </div>
                        @if($workIntegrity->previous_dni)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Cédula Anterior</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->previous_dni }}</p>
                            </div>
                        @endif
                        @if($workIntegrity->birth_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Nacimiento</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->birth_date->format('d/m/Y') }}</p>
                            </div>
                        @endif
                        @if($workIntegrity->birth_place)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Lugar de Nacimiento</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->birth_place }}</p>
                            </div>
                        @endif
                        @if($workIntegrity->province)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Provincia</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->province }}</p>
                            </div>
                        @endif
                        @if($workIntegrity->municipality)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Municipio</label>
                                <p class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ $workIntegrity->municipality }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hoja Integral de Vida -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hoja Integral de Vida</h3>
                    
                    @if($workIntegrity->items->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tipo de Depuración
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Código
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Resultado
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($workIntegrity->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $item->certification?->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $item->reference_code }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $item->reference_name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin certificaciones</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No hay items de certificación registrados.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

