<x-company-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard - {{ $company->business_name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalPeople }}</h3>
                                <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Personas Registradas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalWorkIntegrities }}</h3>
                                <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Depuraciones Realizadas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Empresa -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información de la Empresa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Nombre:</strong> {{ $company->business_name }}
                            </p>
                            @if($company->branch)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Sucursal:</strong> {{ $company->branch }}
                                </p>
                            @endif
                            @if($company->rnc)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>RNC:</strong> {{ $company->rnc }}
                                </p>
                            @endif
                        </div>
                        <div>
                            @if($company->email)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Email:</strong> {{ $company->email }}
                                </p>
                            @endif
                            @if($company->landline_phone)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Teléfono:</strong> {{ $company->landline_phone }}
                                </p>
                            @endif
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Código Único:</strong> {{ $company->code_unique }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personas Recientes -->
            @if($recentPeople->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Personas Recientes</h3>
                            <a href="{{ route('company.people.index') }}" class="text-primary hover:text-primary/80 text-sm font-medium">
                                Ver todas
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cédula</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha de Registro</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentPeople as $person)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $person->name }} {{ $person->last_name }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $person->dni }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $person->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('company.people.show', $person) }}" class="text-primary hover:text-primary/80">
                                                    Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Depuraciones Recientes -->
            @if($recentWorkIntegrities->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Depuraciones Recientes</h3>
                            <a href="{{ route('company.work-integrities.index') }}" class="text-primary hover:text-primary/80 text-sm font-medium">
                                Ver todas
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Persona</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentWorkIntegrities as $workIntegrity)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $workIntegrity->person_name }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($workIntegrity->fecha)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('company.work-integrities.show', $workIntegrity) }}" class="text-primary hover:text-primary/80">
                                                    Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Acciones Rápidas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                <a href="{{ route('company.people.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-sm transition-colors duration-200 uppercase tracking-wide text-center">
                    Registrar Nueva Persona
                </a>
                <a href="{{ route('company.work-integrities.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-sm transition-colors duration-200 uppercase tracking-wide text-center">
                    Nueva Depuración
                </a>
                <a href="{{ route('company.people.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg shadow-sm transition-colors duration-200 uppercase tracking-wide text-center">
                    Ver Todas las Personas
                </a>
            </div>
        </div>
    </div>
</x-company-layout>

