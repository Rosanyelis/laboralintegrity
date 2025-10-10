<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Detalles de la Empresa
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('companies.edit', $company) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                    Editar
                </a>
                <a href="{{ route('companies.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                    Volver al Listado
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Datos de la Empresa -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Datos de la Empresa
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Código -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Código
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100 font-semibold">
                                {{ $company->code_unique }}
                            </p>
                        </div>

                        <!-- Fecha de Registro -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Fecha de Registro
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->registration_date?->format('d/m/Y') ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Nombre de Empresa -->
                        <div class="md:col-span-2 lg:col-span-1">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Nombre de Empresa
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100 font-semibold">
                                {{ $company->business_name ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Sucursal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Sucursal
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->branch ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- RNC -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                RNC
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->rnc ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Rubro -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Rubro
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->industry ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ubicación -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Ubicación
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Regional -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Regional
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->regional?->name ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Provincia -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Provincia
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->province?->name ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Municipio -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Municipio
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->municipality?->name ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Sector -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Sector
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->sector ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos de Contacto -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Datos de Contacto
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Teléfono Fijo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Teléfono Fijo
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->landline_phone ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Extensión -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Extensión
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->extension ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Correo Electrónico -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Correo Electrónico
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                @if($company->email)
                                    <a href="mailto:{{ $company->email }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        {{ $company->email }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Representante Autorizado -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Datos del Representante Autorizado
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre y Apellidos -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Nombre y Apellidos
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100 font-semibold">
                                {{ $company->representative_name ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Cédula -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Cédula
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->representative_dni ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Teléfono Móvil -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Teléfono Móvil
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->representative_mobile ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Correo Electrónico Personal -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Correo Electrónico Personal
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                @if($company->representative_email)
                                    <a href="mailto:{{ $company->representative_email }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        {{ $company->representative_email }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Información del Sistema
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fecha de Creación -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Fecha de Creación
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->created_at->format('d/m/Y H:i:s') }}
                            </p>
                        </div>

                        <!-- Última Actualización -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">
                                Última Actualización
                            </label>
                            <p class="text-base text-gray-900 dark:text-gray-100">
                                {{ $company->updated_at->format('d/m/Y H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('companies.index') }}" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Volver al Listado
                </a>
                <a href="{{ route('companies.edit', $company) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Empresa
                </a>
            </div>

        </div>
    </div>
</x-app-layout>

