<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Integraciones Laborales de') }} {{ $person->name }} {{ $person->last_name }}
        </h2>
        <a href="{{ route('work-integrities.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors duration-150">
            Volver
        </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nombre Completo:</p>
                                <p class="font-medium">{{ $person->name }} {{ $person->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Cédula:</p>
                                <p class="font-medium">{{ $person->dni }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Cédula Anterior:</p>
                                <p class="font-medium">{{ $person->previous_dni }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Nacimiento:</p>
                                <p class="font-medium">{{ $person->birth_date ? \Carbon\Carbon::parse($person->birth_date)->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Lugar de Nacimiento:</p>
                                <p class="font-medium">{{ $person->birth_place ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Integraciones Laborales
                    </h3>

                    @if ($workIntegrities->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">No hay integraciones laborales registradas para esta persona.</p>
                    @else
                        <div class="space-y-4" x-data="{}">
                            @foreach ($workIntegrities as $workIntegrity)
                                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-700 shadow sm:rounded-lg">
                                    <div class="flex items-center justify-between p-4 cursor-pointer" @click="open = !open">
                                        <div class="flex-1">
                                            <h4 class="text-md font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $loop->iteration }} - Integración Laboral del {{ \Carbon\Carbon::parse($workIntegrity->fecha)->format('d/m/Y') }}
                                                @if ($workIntegrity->company)
                                                    <span class="text-sm text-gray-600 dark:text-gray-300"> - {{ $workIntegrity->company->business_name }}</span>
                                                @endif
                                            </h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ $workIntegrity->items->count() }} ítems 
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @can('work-integrities.edit')
                                                <a href="{{ route('work-integrities.edit', $workIntegrity->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150" @click.stop>
                                                    Editar
                                                </a>
                                            @endcan
                                            <button @click="open = !open" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none">
                                                <svg x-show="!open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                                <svg x-show="open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="p-4 border-t border-gray-200 dark:border-gray-600">
                                        
                                        <!-- Información de la Empresa -->
                                        <div class="mb-4">
                                            <h5 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Información de la Empresa:</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Nombre de la Empresa:</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_name ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Código/RNC:</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_code ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Sucursal:</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_branch ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono:</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_phone ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Email:</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $workIntegrity->company_email ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Representante:</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $workIntegrity->representative_name ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono del Representante:</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $workIntegrity->representative_phone ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Email del Representante:</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $workIntegrity->representative_email ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <h5 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Hoja Integral de Vida</h5>
                                        @if ($workIntegrity->items->isEmpty())
                                            <p class="text-sm text-gray-600 dark:text-gray-400">No hay ítems para esta integración.</p>
                                        @else
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                                        <tr>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">TIPO DE DEPURACIÓN</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">CÓDIGO</th>
                                                            @can('work-integrities.view-actual-results')
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">RESULTADO REAL</th>
                                                            @endcan
                                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">DESCRIPCIÓN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                                        @foreach ($workIntegrity->items as $item)
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                    {{ $item->certification->name ?? 'N/A' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                    {{ $item->referenceCode->code ?? 'N/A' }}
                                                                </td>
                                                                @can('work-integrities.view-actual-results')
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                    {{ $item->actual_result ?? 'N/A' }}
                                                                </td>
                                                                @endcan
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                    {{ $item->referenceCode->name ?? 'N/A' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <!-- Resultado debajo de la tabla -->
                                            @can('work-integrities.view-actual-results')
                                            <div class="mt-4 p-4 bg-white dark:bg-gray-700 rounded-lg">
                                                <h6 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Resultado:</h6>
                                               <p>{{ $workIntegrity->resultado ?? 'N/A' }}</p>
                                            </div>
                                            @endcan
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
