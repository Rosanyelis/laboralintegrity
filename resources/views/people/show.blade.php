<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Personal Individual - Detalles de Persona
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('people.edit', $person) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                    Editar
                </a>
                <a href="{{ route('people.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                    Volver a Consulta
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" x-data="{ activeTab: 'personal' }">
                <div class="p-6">
                    <!-- Header con información básica -->
                    <div class="mb-8 bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $person->name }} {{ $person->last_name }}
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400">{{ $person->email }}</p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ ucfirst($person->verification_status ?? 'Pendiente') }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ ucfirst($person->employment_status ?? 'Disponible') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'personal'" 
                                    :class="activeTab === 'personal' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                Información Personal
                            </button>
                            <button @click="activeTab = 'demographic'" 
                                    :class="activeTab === 'demographic' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                Información Demográfica
                            </button>
                            <button @click="activeTab = 'employment'" 
                                    :class="activeTab === 'employment' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                Información Laboral
                            </button>
                            <button @click="activeTab = 'location'" 
                                    :class="activeTab === 'location' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                Ubicación
                            </button>
                            <button @click="activeTab = 'medical'" 
                                    :class="activeTab === 'medical' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                Información Médica
                            </button>
                            <button @click="activeTab = 'emergency'" 
                                    :class="activeTab === 'emergency' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                Contactos de Emergencia
                            </button>
                            <button @click="activeTab = 'system'" 
                                    :class="activeTab === 'system' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                Estados del Sistema
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Tab: Información Personal -->
                        <div x-show="activeTab === 'personal'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                        Datos Básicos
                                    </h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->name }} {{ $person->last_name }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->email }}</p>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Celular</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->cell_phone ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Casa</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->home_phone ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                        Información de Identificación
                                    </h3>
                                    
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">DNI</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->dni ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">DNI Anterior</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->previous_dni ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Código Único</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->code_unique ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Información Demográfica -->
                        <div x-show="activeTab === 'demographic'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                        Datos Demográficos
                                    </h3>
                                    
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Nacimiento</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->birth_date?->format('d/m/Y') ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Edad</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->age ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estado Civil</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($person->marital_status ?? 'N/A') }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Lugar de Nacimiento</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->birth_place ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                        Redes Sociales
                                    </h3>
                                    
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Red Social 1</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->social_media_1 ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Red Social 2</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->social_media_2 ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Información Laboral -->
                        <div x-show="activeTab === 'employment'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Información Laboral
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Posición Solicitada</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->position_applied_for ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Empresa</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->company_name ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Código Empresa</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->company_code ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Ubicación -->
                        <div x-show="activeTab === 'location'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Información de Ubicación
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">País</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->country ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Código Postal</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->zip_code ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Información Médica -->
                        <div x-show="activeTab === 'medical'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Información Médica
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Sangre</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->blood_type ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Alergias a Medicamentos</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->medication_allergies ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Enfermedades</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->illnesses ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Contactos de Emergencia -->
                        <div x-show="activeTab === 'emergency'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Contactos de Emergencia
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Contacto</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->emergency_contact_name ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Contacto</label>
                                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->emergency_contact_phone ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Otros Contactos</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->other_emergency_contacts ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Estados del Sistema -->
                        <div x-show="activeTab === 'system'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Estados del Sistema
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-6">
                                        <div class="space-y-4">
                                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Estados de Verificación y Empleo</h4>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estado de Verificación</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($person->verification_status ?? 'N/A') }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estado de Empleo</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($person->employment_status ?? 'N/A') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-6">
                                        <div class="space-y-4">
                                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Información del Sistema</h4>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Última Actualización</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->updated_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>