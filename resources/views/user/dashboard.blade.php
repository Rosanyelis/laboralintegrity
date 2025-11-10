<x-user-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Mi Dashboard - {{ $person->name }} {{ $person->last_name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- Resumen de Información -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center space-x-6">
                        <!-- Foto de Perfil -->
                        <div class="relative">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                @if($person->profile_photo)
                                    <img src="{{ asset('storage/' . $person->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Información Básica -->
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $person->name }} {{ $person->last_name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Código Único:</strong> {{ $person->code_unique ?? 'N/A' }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Cédula:</strong> {{ $person->dni ?? 'N/A' }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Email:</strong> {{ $person->email ?? 'N/A' }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">
                                <strong>Teléfono:</strong> {{ $person->cell_phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="flex justify-center mb-4">
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $person->educationalSkills->count() }}</h3>
                        <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Habilidades Educativas</p>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="flex justify-center mb-4">
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $person->workExperiences->count() }}</h3>
                        <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Experiencias Laborales</p>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="flex justify-center mb-4">
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $person->personalReferences->count() }}</h3>
                        <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Referencias Personales</p>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="flex justify-center mb-4">
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            @if($person->aspiration)
                                {{ ucfirst($person->aspiration->employment_status) }}
                            @else
                                N/A
                            @endif
                        </h3>
                        <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Estatus Laboral</p>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('user.profile.show') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-sm transition-colors duration-200 uppercase tracking-wide text-center">
                    Ver Mi Perfil Completo
                </a>
                <a href="{{ route('user.profile.edit') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-sm transition-colors duration-200 uppercase tracking-wide text-center">
                    Editar Mi Información
                </a>
                <a href="{{ route('user.cv') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg shadow-sm transition-colors duration-200 uppercase tracking-wide text-center">
                    Generar Mi CV
                </a>
            </div>

            <!-- Información Adicional -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Información de Registro</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Fecha de Registro:</strong> {{ $person->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Última Actualización:</strong> {{ $person->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>

