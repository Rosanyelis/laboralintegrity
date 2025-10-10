<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Reclutador') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('recruiters.edit', $recruiter) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                <a href="{{ route('recruiters.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Información Básica -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información del Reclutador</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Código Único</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->code_unique }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Registro</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->registration_date->format('d/m/Y') }}</p>
                        </div>

                        @if($recruiter->branch)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sucursal</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->branch }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de la Empresa -->
            @if($recruiter->company)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información de la Empresa</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Comercial</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->company->commercial_name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Razón Social</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->company->business_name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">RNC</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->company->rnc }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Actividad Económica</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->company->economic_activity ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Provincia</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->company->municipality->province->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Municipio</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->company->municipality->name ?? 'N/A' }}</p>
                        </div>

                        @if($recruiter->company->sector)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sector</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->company->sector }}</p>
                        </div>
                        @endif

                        @if($recruiter->company->phone)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $recruiter->company->phone }}
                                @if($recruiter->company->extension)
                                    Ext. {{ $recruiter->company->extension }}
                                @endif
                            </p>
                        </div>
                        @endif

                        @if($recruiter->company->email)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                <a href="mailto:{{ $recruiter->company->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $recruiter->company->email }}
                                </a>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 dark:bg-yellow-900/20 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <p class="text-sm text-yellow-800 dark:text-yellow-300">
                        <strong>Nota:</strong> Este reclutador no tiene empresa asociada.
                    </p>
                </div>
            </div>
            @endif

            <!-- Información del Representante Autorizado -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Representante Autorizado</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->person->name }} {{ $recruiter->person->last_name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cédula</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $recruiter->person->dni }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                <a href="tel:{{ $recruiter->person->cell_phone }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $recruiter->person->cell_phone ?? 'N/A' }}
                                </a>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                <a href="mailto:{{ $recruiter->person->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $recruiter->person->email ?? 'N/A' }}
                                </a>
                            </p>
                        </div>

                        @if($recruiter->person->residenceInformation)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Provincia</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $recruiter->person->residenceInformation->municipality->province->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Municipio</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $recruiter->person->residenceInformation->municipality->name ?? 'N/A' }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('people.show', $recruiter->person) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Ver perfil completo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

