<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Personal Individual - Detalles de Persona
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('people.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                    Volver a Consulta
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6" x-data="tabManager()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            
            <!-- Tabs Navigation -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mb-4">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-4 overflow-x-auto">
                        <button @click="setActiveTab('personal')" 
                                :class="activeTab === 'personal' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Información Personal
                        </button>
                        <button @click="setActiveTab('residence')" 
                                :class="activeTab === 'residence' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Inf. Residencial
                        </button>
                        <button @click="setActiveTab('educational')" 
                                :class="activeTab === 'educational' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Hab. Educativas
                        </button>
                        <button @click="setActiveTab('work')" 
                                :class="activeTab === 'work' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Exp. Laboral
                        </button>
                        <button @click="setActiveTab('references')" 
                                :class="activeTab === 'references' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Ref. Personales
                        </button>
                        <button @click="setActiveTab('aspirations')" 
                                :class="activeTab === 'aspirations' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Aspiraciones
                        </button>
                        <button @click="setActiveTab('availability')" 
                                :class="activeTab === 'availability' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Disponibilidad
                        </button>
                    </nav>
                </div>
            </div>

            

            <!-- Tab Content -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showSuccess('{{ session('success') }}', 'Éxito');
                            });
                        </script>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showError('{{ $errors->first() }}', 'Error de validación');
                            });
                        </script>
                    @endif

                    <!-- Tab: Información Personal -->
                    <div x-show="activeTab === 'personal'">
                        <form action="{{ route('people.update-personal-info', $person) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            
                            <!-- Profile Photo Section -->
                            <div class="mb-8 bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <div class="flex items-center space-x-6">
                                    <!-- Profile Photo Display -->
                                    <div class="relative">
                                        <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <template x-if="previewImage">
                                                <img :src="previewImage" alt="Preview" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!previewImage">
                                                @if($person->profile_photo)
                                                    <img src="{{ asset('storage/' . $person->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                @endif
                                            </template>
                                        </div>
                                    </div>
                            
                                    <!-- Upload Controls -->
                                    <div class="flex-1">
                                        <div class="flex space-x-3 mb-2">
                                            <label for="profile_photo" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 cursor-pointer">
                                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                                Subir foto del candidato
                                            </label>
                                            <button type="button" @click="resetImage()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                                Resetear
                                            </button>
                                        </div>
                                        <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/jpg,image/png,image/gif" @change="handleFileSelect($event)" class="hidden">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Permitido JPG, GIF o PNG. Tamaño máximo de 800K</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Fields -->
                            <div class="space-y-6">
                                <!-- First Row -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <!-- Código Único -->
                                    <div>
                                        <label for="code_unique" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CÓDIGO ÚNICO</label>
                                        <input type="text" id="code_unique" name="code_unique" value="{{ old('code_unique', $person->code_unique) }}" 
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                            disabled>
                                    </div>
                                    <!-- Nombre -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="name">NOMBRE</label>
                                        <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                            id="name" name="name" type="text" value="{{ old('name', $person->name) }}" required />
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Apellidos -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="last_name">APELLIDOS</label>
                                        <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                            id="last_name" name="last_name" type="text" value="{{ old('last_name', $person->last_name) }}" required />
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Cédula -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="dni">CÉDULA</label>
                                        <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                            id="dni" name="dni" type="text" value="{{ old('dni', $person->dni) }}" placeholder="000-0000000-0" maxlength="13" />
                                        @error('dni')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="email">CORREO ELECTRÓNICO</label>
                                        <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                            id="email" name="email" type="email" value="{{ old('email', $person->email) }}" required />
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Teléfono Móvil -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="cell_phone">TELÉFONO MÓVIL</label>
                                        <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                            id="cell_phone" name="cell_phone" type="tel" value="{{ old('cell_phone', $person->cell_phone) }}" placeholder="0000-000-0000" maxlength="12" required />
                                        @error('cell_phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end mt-8">
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    ACTUALIZAR
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab: Información Residencial -->
                    <div x-show="activeTab === 'residence'">
                        @if($person->residenceInformation)
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Información de Residencia
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Región</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->residenceInformation->province->regional->name ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Provincia</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->residenceInformation->province->name ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Municipio</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->residenceInformation->municipality->name ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Distrito</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->residenceInformation->district->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Sector</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->residenceInformation->sector ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Barrio</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->residenceInformation->neighborhood ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Calle y Número</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->residenceInformation->street_and_number ?? 'N/A' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Complejo Residencial</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $person->residenceInformation->residential_complex ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin información residencial</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se ha registrado información de residencia para esta persona.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tab: Habilidades Educativas -->
                    <div x-show="activeTab === 'educational'">
                        @if($person->educationalSkills->count() > 0)
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Habilidades Educativas
                                </h3>
                                
                                <div class="grid grid-cols-1 gap-6">
                                    @foreach($person->educationalSkills as $skill)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Carrera</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $skill->career ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Centro Educativo</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $skill->educational_center ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Provincia</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $skill->province ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Año de Graduación</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $skill->year ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin habilidades educativas</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se han registrado habilidades educativas para esta persona.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tab: Experiencia Laboral -->
                    <div x-show="activeTab === 'work'">
                        @if($person->workExperiences->count() > 0)
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Experiencia Laboral
                                </h3>
                                
                                <div class="grid grid-cols-1 gap-6">
                                    @foreach($person->workExperiences as $experience)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div class="space-y-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Empresa</label>
                                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $experience->company_name ?? 'N/A' }}</p>
                                                    </div>
                                                    
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Posición</label>
                                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $experience->position ?? 'N/A' }}</p>
                                                    </div>
                                                    
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Inicio</label>
                                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $experience->from_date?->format('d/m/Y') ?? 'N/A' }}</p>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Fin</label>
                                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $experience->to_date?->format('d/m/Y') ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="space-y-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Responsabilidades</label>
                                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $experience->responsibilities ?? 'N/A' }}</p>
                                                    </div>
                                                    
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Logros</label>
                                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $experience->achievements ?? 'N/A' }}</p>
                                                    </div>
                                                    
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Habilidades</label>
                                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $experience->skills ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin experiencia laboral</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se ha registrado experiencia laboral para esta persona.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tab: Referencias Personales -->
                    <div x-show="activeTab === 'references'">
                        @if($person->personalReferences->count() > 0)
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Referencias Personales
                                </h3>
                                
                                <div class="grid grid-cols-1 gap-6">
                                    @foreach($person->personalReferences as $reference)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Relación</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($reference->relationship ?? 'N/A') }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $reference->full_name ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Cédula</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $reference->cedula ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Celular</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $reference->cell_phone ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin referencias personales</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se han registrado referencias personales para esta persona.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tab: Aspiraciones -->
                    <div x-show="activeTab === 'aspirations'">
                        @if($person->aspirations->count() > 0)
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Aspiraciones
                                </h3>
                                
                                <div class="grid grid-cols-1 gap-6">
                                    @foreach($person->aspirations as $aspiration)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Ocupación</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $aspiration->occupation ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Disponibilidad</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $aspiration->availability ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Rango de Horas</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $aspiration->hour_range ?? 'N/A' }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Horas por Semana</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $aspiration->hours_per_week ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin aspiraciones</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se han registrado aspiraciones para esta persona.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Tab: Disponibilidad -->
                    <div x-show="activeTab === 'availability'">
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Estados y Disponibilidad
                            </h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="space-y-6">
                                    <div class="space-y-4">
                                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Estados del Sistema</h4>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estado de Verificación</label>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($person->verification_status === 'certificado') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @elseif($person->verification_status === 'pendiente') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @elseif($person->verification_status === 'parcial') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                                    {{ ucfirst($person->verification_status ?? 'N/A') }}
                                                </span>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estado de Empleo</label>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($person->employment_status === 'disponible') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @elseif($person->employment_status === 'contratado') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @elseif($person->employment_status === 'pendiente') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @elseif($person->employment_status === 'en_proceso') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @elseif($person->employment_status === 'part_time') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                                    {{ ucfirst($person->employment_status ?? 'N/A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div class="space-y-4">
                                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Información del Sistema</h4>
                                        <div class="grid grid-cols-1 gap-4">
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
</x-app-layout>