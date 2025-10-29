<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Personal Individual - {{ $person->name }} {{ $person->last_name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('people.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200">
                    Volver a Consulta
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6" x-data="tabManager()" data-active-tab="{{ request('activeTab', session('activeTab', 'personal')) }}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            
            <!-- Tabs Navigation -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mb-4">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-4 overflow-x-auto">
                        <button @click="setActiveTab('personal')" 
                                :class="activeTab === 'personal' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-bold text-sm uppercase transition-colors duration-200">
                            Información Personal
                        </button>
                        <button @click="setActiveTab('residence')" 
                                :class="activeTab === 'residence' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                                Información Residencial
                        </button>
                        <button @click="setActiveTab('educational')" 
                                :class="activeTab === 'educational' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Habilidades Educativas
                        </button>
                        <button @click="setActiveTab('work')" 
                                :class="activeTab === 'work' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Experiencia Laborales
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
                        <button @click="setActiveTab('depuraciones')" 
                                :class="activeTab === 'depuraciones' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm uppercase transition-colors duration-200">
                            Depuraciones
                        </button>
                    </nav>
                </div>
            </div>

            

            <!-- Tab Content -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    
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
                                <!-- Información Básica -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
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
                                                id="dni" name="dni" type="text" value="{{ old('dni', $person->dni) }}" placeholder="000-0000000-0" maxlength="13" required />
                                            @error('dni')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Cédula Anterior -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="previous_dni">CÉDULA ANTERIOR</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="previous_dni" name="previous_dni" type="text" value="{{ old('previous_dni', $person->previous_dni) }}" placeholder="000-0000000-0" maxlength="13" />
                                            @error('previous_dni')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Género -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="gender">SEXO</label>
                                            <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="gender" name="gender">
                                                <option value="">Seleccionar...</option>
                                                <option value="masculino" {{ old('gender', $person->gender) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                                <option value="femenino" {{ old('gender', $person->gender) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                                <option value="otro" {{ old('gender', $person->gender) == 'otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                            @error('gender')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- País -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="country">NACIONALIDAD</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="country" name="country" type="text" value="{{ old('country', $person->country) }}" required />
                                            @error('country')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Lugar de Nacimiento -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="birth_place">LUGAR DE NACIMIENTO</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="birth_place" name="birth_place" type="text" value="{{ old('birth_place', $person->birth_place) }}" required />
                                            @error('birth_place')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Fecha de Nacimiento -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="birth_date">FECHA DE NACIMIENTO</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', $person->birth_date?->format('Y-m-d')) }}" required />
                                            @error('birth_date')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Edad -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="age">EDAD</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="age" name="age" type="number" value="{{ old('age', $person->age) }}" min="0" max="120" />
                                            @error('age')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Estado Civil -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="marital_status">ESTADO CIVIL</label>
                                            <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="marital_status" name="marital_status">
                                                <option value="">Seleccionar...</option>
                                                @foreach(\App\Models\Person::MARITAL_STATUS_OPTIONS as $status)
                                                    <option value="{{ $status }}" {{ old('marital_status', $person->marital_status) == $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('marital_status')
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
                                                id="cell_phone" name="cell_phone" type="tel" value="{{ old('cell_phone', $person->cell_phone) }}" placeholder="0000-000-0000" maxlength="13" required />
                                            @error('cell_phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Teléfono Fijo -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="home_phone">TELÉFONO FIJO</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="home_phone" name="home_phone" type="tel" value="{{ old('home_phone', $person->home_phone) }}" placeholder="0000-000-0000" maxlength="13" />
                                            @error('home_phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Red Social 1 -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="social_media_1">RED SOCIAL 1</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="social_media_1" name="social_media_1" type="text" value="{{ old('social_media_1', $person->social_media_1) }}" placeholder="Facebook, Instagram, etc." />
                                            @error('social_media_1')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Red Social 2 -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="social_media_2">RED SOCIAL 2</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="social_media_2" name="social_media_2" type="text" value="{{ old('social_media_2', $person->social_media_2) }}" placeholder="LinkedIn, Twitter, etc." />
                                            @error('social_media_2')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    
                                        <!-- Tipo de Sangre -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="blood_type">TIPO DE SANGRE</label>
                                            <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="blood_type" name="blood_type">
                                                <option value="">Seleccionar...</option>
                                                <option value="A+" {{ old('blood_type', $person->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                                <option value="A-" {{ old('blood_type', $person->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                                <option value="B+" {{ old('blood_type', $person->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                                <option value="B-" {{ old('blood_type', $person->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                                <option value="AB+" {{ old('blood_type', $person->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                <option value="AB-" {{ old('blood_type', $person->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                <option value="O+" {{ old('blood_type', $person->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                                <option value="O-" {{ old('blood_type', $person->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                            </select>
                                            @error('blood_type')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Alergias a Medicamentos -->
                                        <div class="md:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="medication_allergies">ALERGIAS A MEDICAMENTOS</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="medication_allergies" name="medication_allergies" type="text" placeholder="Describa las alergias a medicamentos..." value="{{ old('medication_allergies', $person->medication_allergies) }}" />
                                            @error('medication_allergies')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Enfermedades -->
                                        <div class="md:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="illnesses">ENFERMEDADES</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="illnesses" name="illnesses" type="text" placeholder="Describa enfermedades crónicas o condiciones médicas..." value="{{ old('illnesses', $person->illnesses) }}" />
                                            @error('illnesses')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    
                                        <!-- Nombre Contacto Emergencia -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="emergency_contact_name">NOMBRE CONTACTO EMERGENCIA</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="emergency_contact_name" name="emergency_contact_name" type="text" value="{{ old('emergency_contact_name', $person->emergency_contact_name) }}" required />
                                            @error('emergency_contact_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Teléfono Contacto Emergencia -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="emergency_contact_phone">TELÉFONO CONTACTO EMERGENCIA</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="emergency_contact_phone" name="emergency_contact_phone" type="tel" value="{{ old('emergency_contact_phone', $person->emergency_contact_phone) }}" placeholder="0000-000-0000" maxlength="13" required />
                                            @error('emergency_contact_phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Otros Contactos de Emergencia -->
                                        <div class="md:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="other_emergency_contacts">OTROS CONTACTOS DE EMERGENCIA</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="other_emergency_contacts" name="other_emergency_contacts" placeholder="Información adicional de contactos de emergencia..." value="{{ old('other_emergency_contacts', $person->other_emergency_contacts) }}" />
                                            @error('other_emergency_contacts')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
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
                        <form action="{{ route('people.update-residence-info', $person) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="space-y-6">
                                <!-- Ubicación Geográfica -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <!-- Regional (readonly) -->
                                        <div>
                                            <label for="regional_residence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                REGIONAL
                                            </label>
                                            <input type="text" 
                                                   id="regional_residence" 
                                                   name="regional" 
                                                   value="{{ old('regional', $person->residenceInformation?->province?->regional?->name ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                                   readonly />
                                        </div>
                                        
                                        <!-- Provincia (readonly) -->
                                        <div>
                                            <label for="provincia_residence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                PROVINCIA
                                            </label>
                                            <input type="text" 
                                                   id="provincia_residence" 
                                                   name="provincia"
                                                   value="{{ old('provincia', $person->residenceInformation?->province?->name ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                                   readonly />
                                        </div>
                                        
                                        <!-- Municipio (selector activo) -->
                                        <div>
                                            <label for="municipio_select_residence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                MUNICIPIO
                                            </label>
                                            <select id="municipio_select_residence" 
                                                    name="municipality_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm">
                                                <option value="">Seleccione un municipio...</option>
                                                @foreach($municipalities as $municipality)
                                                    @php
                                                        $regional = $municipality->province && $municipality->province->regional 
                                                            ? $municipality->province->regional->name 
                                                            : '';
                                                        $provincia = $municipality->province 
                                                            ? $municipality->province->name 
                                                            : '';
                                                    @endphp
                                                    <option value="{{ $municipality->id }}" 
                                                            data-regional="{{ $regional }}"
                                                            data-provincia="{{ $provincia }}"
                                                            {{ old('municipality_id', $person->residenceInformation?->municipality_id ?? '') == $municipality->id ? 'selected' : '' }}>
                                                        {{ $municipality->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('municipality_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Distrito (select) -->
                                        <div>
                                            <label for="district_id_residence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                DISTRITO
                                            </label>
                                            <select id="district_id_residence" 
                                                    name="district_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm disabled:bg-gray-100 disabled:dark:bg-gray-600 disabled:cursor-not-allowed"
                                                    disabled>
                                                <option value="">{{ $person->residenceInformation?->municipality_id ? 'Cargando distritos...' : 'Seleccione primero un municipio...' }}</option>
                                            </select>
                                            @error('district_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Sector -->
                                        <div>
                                            <label for="sector" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                SECTOR
                                            </label>
                                            <input type="text" 
                                                   name="sector" 
                                                   id="sector"
                                                   value="{{ old('sector', $person->residenceInformation?->sector ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm">
                                            @error('sector')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Barrio -->
                                        <div>
                                            <label for="neighborhood" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                BARRIO
                                            </label>
                                            <input type="text" 
                                                   name="neighborhood" 
                                                   id="neighborhood"
                                                   value="{{ old('neighborhood', $person->residenceInformation?->neighborhood ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm">
                                            @error('neighborhood')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    
                                        <div>
                                            <label for="street_and_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                CALLE Y NÚMERO
                                            </label>
                                            <input type="text" 
                                                   name="street_and_number" 
                                                   id="street_and_number"
                                                   value="{{ old('street_and_number', $person->residenceInformation?->street_and_number ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm">
                                            @error('street_and_number')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Referencia de llegada -->
                                        <div>
                                            <label for="arrival_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                REFERENCIA DE LLEGADA
                                            </label>
                                            <input type="text" 
                                                   name="arrival_reference" 
                                                   id="arrival_reference"
                                                   value="{{ old('arrival_reference', $person->residenceInformation?->arrival_reference ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm">
                                            @error('arrival_reference')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón Actualizar -->
                                <div class="flex justify-end pt-4">
                                    <button type="submit" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Actualizar Información de Residencia</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <script>
                            // Función para cargar distritos según el municipio seleccionado
                            async function cargarDistritos(municipalityId, selectedDistrictId = null) {
                                const districtSelect = document.getElementById('district_id_residence');
                                
                                if (!municipalityId) {
                                    districtSelect.innerHTML = '<option value="">Seleccione primero un municipio...</option>';
                                    districtSelect.disabled = true;
                                    return;
                                }
                                
                                // Deshabilitar mientras carga
                                districtSelect.disabled = true;
                                districtSelect.innerHTML = '<option value="">Cargando distritos...</option>';
                                
                                try {
                                    const response = await fetch(`{{ route('people.districts-by-municipality') }}?municipality_id=${municipalityId}`);
                                    const districts = await response.json();
                                    
                                    // Si hay distritos, mostrar opciones normales
                                    if (districts.length > 0) {
                                        districtSelect.innerHTML = '<option value="">Seleccione...</option><option value="no_aplica">No aplica</option>';
                                        
                                        districts.forEach(district => {
                                            const option = document.createElement('option');
                                            option.value = district.id;
                                            option.textContent = district.name;
                                            if (selectedDistrictId && district.id == selectedDistrictId) {
                                                option.selected = true;
                                            }
                                            districtSelect.appendChild(option);
                                        });
                                    } else {
                                        // Si no hay distritos, solo mostrar "No aplica" y seleccionarlo automáticamente
                                        districtSelect.innerHTML = '<option value="no_aplica" selected>No aplica</option>';
                                    }
                                    
                                    // Habilitar el select después de cargar los distritos
                                    districtSelect.disabled = false;
                                } catch (error) {
                                    console.error('Error al cargar distritos:', error);
                                    // En caso de error, mostrar solo "No aplica"
                                    districtSelect.innerHTML = '<option value="no_aplica" selected>No aplica</option>';
                                    districtSelect.disabled = false;
                                }
                            }

                            // Función para auto-completar campos cuando se selecciona un municipio
                            document.getElementById('municipio_select_residence').addEventListener('change', function() {
                                const municipioSeleccionado = this.options[this.selectedIndex];
                                const regionalInput = document.getElementById('regional_residence');
                                const provinciaInput = document.getElementById('provincia_residence');
                                const districtSelect = document.getElementById('district_id_residence');

                                if (municipioSeleccionado.value) {
                                    // Auto-completar campos readonly de regional y provincia
                                    regionalInput.value = municipioSeleccionado.getAttribute('data-regional') || '';
                                    provinciaInput.value = municipioSeleccionado.getAttribute('data-provincia') || '';
                                    
                                    // Cargar distritos del municipio seleccionado
                                    const currentDistrictId = districtSelect.value && districtSelect.value !== 'no_aplica' && districtSelect.value !== '' 
                                        ? districtSelect.value 
                                        : null;
                                    cargarDistritos(municipioSeleccionado.value, currentDistrictId);
                                } else {
                                    // Limpiar campos
                                    regionalInput.value = '';
                                    provinciaInput.value = '';
                                    
                                    // Limpiar y deshabilitar distritos
                                    districtSelect.innerHTML = '<option value="">Seleccione primero un municipio...</option>';
                                    districtSelect.disabled = true;
                                }
                            });

                            // Inicializar el estado correcto al cargar la página
                            window.addEventListener('DOMContentLoaded', function() {
                                const municipalitySelect = document.getElementById('municipio_select_residence');
                                const selectedMunicipalityId = municipalitySelect.value;
                                const districtSelect = document.getElementById('district_id_residence');
                                
                                // Si hay un municipio seleccionado, cargar sus distritos y actualizar campos
                                if (selectedMunicipalityId) {
                                    const selectedOption = municipalitySelect.options[municipalitySelect.selectedIndex];
                                    const regionalInput = document.getElementById('regional_residence');
                                    const provinciaInput = document.getElementById('provincia_residence');
                                    
                                    regionalInput.value = selectedOption.getAttribute('data-regional') || '';
                                    provinciaInput.value = selectedOption.getAttribute('data-provincia') || '';
                                    
                                    // Cargar distritos del municipio seleccionado
                                    const currentDistrictId = @json(old('district_id', $person->residenceInformation?->district_id ?? null));
                                    cargarDistritos(selectedMunicipalityId, currentDistrictId);
                                } else {
                                    // Si no hay municipio seleccionado, deshabilitar el selector de distritos
                                    districtSelect.disabled = true;
                                    districtSelect.innerHTML = '<option value="">Seleccione primero un municipio...</option>';
                                }
                            });
                        </script>
                    </div>

                    <!-- Tab: Habilidades Educativas -->
                    <div x-show="activeTab === 'educational'" class="space-y-6">
                        <!-- Formulario para agregar nuevas habilidades educativas -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        
                            <form action="{{ route('people.educational-skills.store', $person) }}" method="POST" class="space-y-1">
                                @csrf
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <!-- Nombre de la Carrera -->
                                    <div>
                                        <label for="career" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Nombre de la Carrera <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="career" 
                                            id="career"
                                            value="{{ old('career') }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Ej: Ingeniería Informática"
                                        >
                                        @error('career')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Centro Educativo -->
                                    <div>
                                        <label for="educational_center" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Centro Educativo <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="educational_center" 
                                            id="educational_center"
                                            value="{{ old('educational_center') }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Ej: Universidad Politécnica"
                                        >
                                        @error('educational_center')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Año -->
                                    <div>
                                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Año de Graduación <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="number" 
                                            name="year" 
                                            id="year"
                                            value="{{ old('year') }}"
                                            required
                                            min="1900"
                                            max="{{ date('Y') + 10 }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="{{ date('Y') }}"
                                        >
                                        @error('year')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="">
                                    <button 
                                        type="submit"
                                        class="inline-flex items-center px-4 py-2 mt-6 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Agregar Habilidad
                                    </button>
                                </div>
                                </div>


                            </form>
                        </div>

                        <!-- Tabla de habilidades educativas -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                           

                            @if($person->educationalSkills->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Nombre de la Carrera
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Centro Educativo
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Año
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($person->educationalSkills as $skill)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $skill->career ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $skill->educational_center ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $skill->year ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <form action="{{ route('people.educational-skills.destroy', [$person, $skill]) }}" method="POST" class="inline-block delete-skill-form" data-skill-name="{{ $skill->career }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                type="submit"
                                                                class="inline-flex items-center p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                                title="Eliminar"
                                                            >
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin habilidades educativas</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Agregue una habilidad educativa usando el formulario superior.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tab: Experiencias Laborales -->
                    <div x-show="activeTab === 'work'" class="space-y-6">
                        <!-- Formulario para agregar nuevas experiencias laborales -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        
                            <form action="{{ route('people.work-experiences.store', $person) }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <!-- Primera fila: 3 campos -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Nombre de la Empresa -->
                                    <div>
                                        <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Nombre de la Empresa
                                        </label>
                                        <input 
                                            type="text" 
                                            name="company_name" 
                                            id="company_name"
                                            value="{{ old('company_name') }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Nombre de la empresa"
                                        >
                                        @error('company_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Posición -->
                                    <div>
                                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Posición
                                        </label>
                                        <input 
                                            type="text" 
                                            name="position" 
                                            id="position"
                                            value="{{ old('position') }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Cargo ocupado"
                                        >
                                        @error('position')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Año (Desde-Hasta) -->
                                    <div>
                                        <label for="year_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            AÑO (DESDE-HASTA)
                                        </label>
                                        <input 
                                            type="text" 
                                            name="year_range" 
                                            id="year_range"
                                            value="{{ old('year_range') }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Ej: 2020-2023"
                                        >
                                        @error('year_range')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Segunda fila: Textarea de logros -->
                                <div>
                                    <label for="achievements" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Logros
                                    </label>
                                    <textarea 
                                        name="achievements" 
                                        id="achievements"
                                        rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Describa sus logros en esta posición..."
                                    >{{ old('achievements') }}</textarea>
                                    @error('achievements')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Botón alineado a la derecha -->
                                <div class="flex justify-end">
                                    <button 
                                        type="submit"
                                        class="inline-flex items-center px-6 py-2.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Añadir Experiencia
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tabla de experiencias laborales -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                           
                            @if($person->workExperiences->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Empresa
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Posición
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Año
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Logros
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($person->workExperiences as $experience)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $experience->company_name ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $experience->position ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $experience->year_range ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                        <div class="max-w-xs truncate" title="{{ $experience->achievements ?? 'N/A' }}">
                                                            {{ $experience->achievements ?? 'N/A' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <form action="{{ route('people.work-experiences.destroy', [$person, $experience]) }}" method="POST" class="inline-block delete-experience-form" data-company-name="{{ $experience->company_name }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                type="submit"
                                                                class="inline-flex items-center p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                                title="Eliminar"
                                                            >
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0v2m-8-2v2m8 0v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2m8 0H8"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin experiencias laborales</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Agregue una experiencia laboral usando el formulario superior.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tab: Referencias Personales -->
                    <div x-show="activeTab === 'references'" class="space-y-6">
                        <!-- Formulario para agregar nuevas referencias personales -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        
                            <form action="{{ route('people.personal-references.store', $person) }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <!-- Primera fila: 4 campos -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <!-- Relación -->
                                    <div>
                                        <label for="relationship" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Relación
                                        </label>
                                        <select 
                                            name="relationship" 
                                            id="relationship"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        >
                                            <option value="">Seleccione...</option>
                                            <option value="padre" {{ old('relationship') == 'padre' ? 'selected' : '' }}>Padre</option>
                                            <option value="madre" {{ old('relationship') == 'madre' ? 'selected' : '' }}>Madre</option>
                                            <option value="conyuge" {{ old('relationship') == 'conyuge' ? 'selected' : '' }}>Cónyuge</option>
                                            <option value="hermano" {{ old('relationship') == 'hermano' ? 'selected' : '' }}>Hermano/a</option>
                                            <option value="tio" {{ old('relationship') == 'tio' ? 'selected' : '' }}>Tío/a</option>
                                            <option value="amigo" {{ old('relationship') == 'amigo' ? 'selected' : '' }}>Amigo/a</option>
                                            <option value="otros" {{ old('relationship') == 'otros' ? 'selected' : '' }}>Otros</option>
                                        </select>
                                        @error('relationship')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Nombre Completo -->
                                    <div>
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Nombre Completo
                                        </label>
                                        <input 
                                            type="text" 
                                            name="full_name" 
                                            id="full_name"
                                            value="{{ old('full_name') }}"
                                            required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Nombre(s) y Apellidos"
                                        >
                                        @error('full_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Cédula -->
                                    <div>
                                        <label for="cedula_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Cédula
                                        </label>
                                        <input 
                                            type="text" 
                                            name="cedula" 
                                            id="cedula_reference"
                                            value="{{ old('cedula') }}"
                                            required
                                            maxlength="13"
                                            pattern="\d{3}-\d{7}-\d{1}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Ej: 001-1234567-8"
                                            title="Formato: 000-0000000-0"
                                        >
                                        @error('cedula')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Teléfono Celular -->
                                    <div>
                                        <label for="cell_phone_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Teléfono Celular
                                        </label>
                                        <input 
                                            type="tel" 
                                            name="cell_phone" 
                                            id="cell_phone_reference"
                                            value="{{ old('cell_phone') }}"
                                            required
                                            maxlength="13"
                                            pattern="\d{4}-\d{3}-\d{4}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Ej: 8095-551-2345"
                                            title="Formato: 0000-000-0000"
                                        >
                                        @error('cell_phone')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Botón alineado a la derecha -->
                                <div class="flex justify-end">
                                    <button 
                                        type="submit"
                                        class="inline-flex items-center px-6 py-2.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Añadir Referencia
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tabla de referencias personales -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                           
                            @if($person->personalReferences->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Relación
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Nombre Completo
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Cédula
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Teléfono
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($person->personalReferences as $reference)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ ucfirst($reference->relationship ?? 'N/A') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $reference->full_name ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $reference->cedula ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $reference->cell_phone ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <form action="{{ route('people.personal-references.destroy', [$person, $reference]) }}" method="POST" class="inline-block delete-reference-form" data-reference-name="{{ $reference->full_name }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                type="submit"
                                                                class="inline-flex items-center p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                                title="Eliminar"
                                                            >
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin referencias personales</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Agregue una referencia personal usando el formulario superior.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tab: Aspiraciones -->
                    <div x-show="activeTab === 'aspirations'">
                        <form action="{{ route('people.update-aspiration', $person) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="space-y-6">
                                <!-- Formulario de Aspiraciones -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="space-y-4">
                                        <!-- Primera fila: Puesto Deseado y Sector de Interés -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Puesto Deseado -->
                                            <div>
                                                <label for="desired_position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    Puesto Deseado
                                                </label>
                                                <input 
                                                    type="text" 
                                                    name="desired_position" 
                                                    id="desired_position"
                                                    value="{{ old('desired_position', $person->aspiration->desired_position ?? '') }}"
                                                    placeholder="Ej. Gerente de Proyectos"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-800 dark:text-white sm:text-sm"
                                                >
                                                @error('desired_position')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Sector de Interés -->
                                            <div>
                                                <label for="sector_of_interest" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    Sector de Interés
                                                </label>
                                                <input 
                                                    type="text" 
                                                    name="sector_of_interest" 
                                                    id="sector_of_interest"
                                                    value="{{ old('sector_of_interest', $person->aspiration->sector_of_interest ?? '') }}"
                                                    placeholder="Ej. Tecnología, Salud, Finanzas"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-800 dark:text-white sm:text-sm"
                                                >
                                                @error('sector_of_interest')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Segunda fila: Salario Esperado -->
                                        <div>
                                            <label for="expected_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Salario Esperado (USD)
                                            </label>
                                            <input 
                                                type="number" 
                                                name="expected_salary" 
                                                id="expected_salary"
                                                value="{{ old('expected_salary', $person->aspiration->expected_salary ?? '') }}"
                                                placeholder="Ej. 50000"
                                                step="0.01"
                                                min="0"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-800 dark:text-white sm:text-sm"
                                            >
                                            @error('expected_salary')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Tipo de Contrato Preferido (Radio button - selección única) -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Tipo de Contrato Preferido
                                            </label>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                @php
                                                    $contractTypes = [
                                                        'tiempo_completo' => 'Tiempo Completo',
                                                        'medio_tiempo' => 'Medio Tiempo',
                                                        'remoto' => 'Remoto',
                                                        'hibrido' => 'Híbrido'
                                                    ];
                                                    $selectedType = old('contract_type_preference', $person->aspiration->contract_type_preference ?? null);
                                                @endphp
                                                
                                                @foreach($contractTypes as $value => $label)
                                                    <div class="flex items-center">
                                                        <input 
                                                            type="radio" 
                                                            name="contract_type_preference" 
                                                            id="contract_{{ $value }}"
                                                            value="{{ $value }}"
                                                            {{ $selectedType === $value ? 'checked' : '' }}
                                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                        >
                                                        <label for="contract_{{ $value }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                                            {{ $label }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('contract_type_preference')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Objetivos a Corto Plazo -->
                                        <div>
                                            <label for="short_term_goals" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Objetivos a Corto Plazo (1-2 años)
                                            </label>
                                            <textarea 
                                                name="short_term_goals" 
                                                id="short_term_goals"
                                                rows="4"
                                                placeholder="Describa sus metas profesionales para los próximos 1 a 2 años."
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-800 dark:text-white sm:text-sm"
                                            >{{ old('short_term_goals', $person->aspiration->short_term_goals ?? '') }}</textarea>
                                            @error('short_term_goals')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Estatus y Alcance Laboral -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Estatus Laboral -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                                    Estatus Laboral
                                                </label>
                                                <div class="space-y-2">
                                                    @php
                                                        $employmentStatuses = [
                                                            'contratado' => 'Contratado',
                                                            'disponible' => 'Disponible',
                                                            'en_proceso' => 'En Proceso',
                                                            'discapacitado' => 'Discapacitado',
                                                            'fallecido' => 'Fallecido'
                                                        ];
                                                        $selectedStatus = old('employment_status', $person->aspiration->employment_status ?? 'disponible');
                                                    @endphp
                                                    
                                                    @foreach($employmentStatuses as $value => $label)
                                                        <div class="flex items-center">
                                                            <input 
                                                                type="radio" 
                                                                name="employment_status" 
                                                                id="status_{{ $value }}"
                                                                value="{{ $value }}"
                                                                {{ $selectedStatus == $value ? 'checked' : '' }}
                                                                required
                                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                            >
                                                            <label for="status_{{ $value }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                                                {{ $label }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('employment_status')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Alcance Laboral -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                                    Alcance Laboral
                                                </label>
                                                <div class="space-y-2">
                                                    @php
                                                        $workScopes = [
                                                            'provincial' => 'Provincial',
                                                            'nacional' => 'Nacional'
                                                        ];
                                                        $selectedScope = old('work_scope', $person->aspiration->work_scope ?? 'provincial');
                                                    @endphp
                                                    
                                                    @foreach($workScopes as $value => $label)
                                                        <div class="flex items-center">
                                                            <input 
                                                                type="radio" 
                                                                name="work_scope" 
                                                                id="scope_{{ $value }}"
                                                                value="{{ $value }}"
                                                                {{ $selectedScope == $value ? 'checked' : '' }}
                                                                required
                                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                            >
                                                            <label for="scope_{{ $value }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                                                {{ $label }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('work_scope')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón Actualizar -->
                                <div class="flex justify-end pt-4">
                                    <button type="submit" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Actualizar Aspiraciones</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Tab: Depuraciones -->
                    <div x-show="activeTab === 'depuraciones'">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Historial de Depuraciones
                                </h3>
                                <a href="{{ route('work-integrities.create', ['person_id' => $person->id]) }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-3 rounded-lg transition-colors duration-200 flex items-center space-x-1.5 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Nueva Depuración</span>
                                </a>
                            </div>

                            @php
                                // Variables ya no necesarias - se eliminaron para usar cards directamente
                            @endphp

                            @if($person->workIntegrities->count() > 0)
                                <!-- Cards de Integraciones Laborales -->
                                <div class="space-y-4" x-data="{ 
                                    expandedCards: {},
                                    toggleCard(cardId) {
                                        this.expandedCards[cardId] = !this.expandedCards[cardId];
                                    }
                                }">
                                    @foreach($person->workIntegrities->sortByDesc('fecha') as $workIntegrity)
                                        @php
                                            $cardId = 'card-' . $workIntegrity->id;
                                            $itemsCount = $workIntegrity->items->count();
                                            $isCompleted = $itemsCount > 0;
                                        @endphp
                                        
                                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                            <!-- Card Header (Siempre visible) -->
                                            <div class="p-6 cursor-pointer" @click="toggleCard('{{ $cardId }}')">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1">
                                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                            Integración Laboral - {{ $workIntegrity->fecha->format('d/m/Y') }}
                                                        </h4>
                                                        <div class="mt-2 flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                                            <span class="flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                                </svg>
                                                                {{ $workIntegrity->company_name ?? 'Sin empresa' }}
                                                            </span>
                                                            <span class="flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                                {{ $itemsCount }} item(s)
                                                            </span>
                                                            <span class="flex items-center">
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isCompleted ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                                                    {{ $isCompleted ? 'Completado' : 'Pendiente' }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <!-- Botones de acción -->
                                                        <div class="flex space-x-1">
                                                            
                                                            @can('work-integrities.edit')
                                                            <a href="{{ route('work-integrities.edit', ['workIntegrity' => $workIntegrity, 'return_to_person' => $person->id]) }}" 
                                                               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                </svg>
                                                                Editar
                                                            </a>
                                                            @endcan
                                                        </div>
                                                        <!-- Icono de colapso -->
                                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" 
                                                             :class="{ 'rotate-180': expandedCards['{{ $cardId }}'] }" 
                                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Card Content (Colapsable) -->
                                            <div x-show="expandedCards['{{ $cardId }}']" 
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                                 class="border-t border-gray-200 dark:border-gray-700">
                                                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                                    <!-- Información de la Empresa -->
                                                    <div class="mb-6">
                                                        <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Información de la Empresa:</h5>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div class="space-y-3">
                                                                <div>
                                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Nombre de la Empresa:</span>
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->company_name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Sucursal:</span>
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->company_branch ?? 'N/A' }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Email:</span>
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->company_email ?? 'N/A' }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Teléfono del Representante:</span>
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->representative_phone ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="space-y-3">
                                                                <div>
                                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Código/RNC:</span>
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->company_code ?? 'N/A' }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Teléfono:</span>
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->company_phone ?? 'N/A' }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Representante:</span>
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->representative_name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="text-sm text-gray-600 dark:text-gray-400">Email del Representante:</span>
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->representative_email ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Hoja Integral de Vida -->
                                                    <div class="mb-6">
                                                        <h5 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hoja Integral de Vida</h5>
                                                        @if($workIntegrity->items->count() > 0)
                                                            <div class="overflow-x-auto">
                                                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                                                        <tr>
                                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">TIPO DE DEPURACIÓN</th>
                                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">CÓDIGO</th>
                                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">RESULTADO REAL</th>
                                                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">DESCRIPCIÓN</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                                                        @foreach($workIntegrity->items as $item)
                                                                            <tr>
                                                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                                    {{ $item->certification?->name ?? 'N/A' }}
                                                                                </td>
                                                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                                    {{ $item->reference_code ?? 'N/A' }}
                                                                                </td>
                                                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                                    {{ $item->actual_result ?? 'N/A' }}
                                                                                </td>
                                                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                                                    {{ $item->reference_name ?? 'N/A' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">No hay ítems para esta integración.</p>
                                                        @endif
                                                    </div>

                                                    <!-- Resultado -->
                                                    <div class="mt-4">
                                                        <div>
                                                            <span class="text-sm text-gray-600 dark:text-gray-400">Resultado:</span>
                                                            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-2">{{ $workIntegrity->resultado ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Sin depuraciones</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Esta persona no tiene depuraciones registradas.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('work-integrities.create', ['person_id' => $person->id]) }}" 
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Nueva Depuración
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para aplicar máscara de cédula dominicana (000-0000000-0)
        function aplicarMascaraCedula(input) {
            let value = input.value.replace(/\D/g, ''); // Solo números
            
            if (value.length <= 3) {
                input.value = value;
            } else if (value.length <= 10) {
                input.value = value.substring(0, 3) + '-' + value.substring(3);
            } else if (value.length <= 11) {
                input.value = value.substring(0, 3) + '-' + value.substring(3, 10) + '-' + value.substring(10);
            } else {
                // Limitar a 11 dígitos máximo
                input.value = value.substring(0, 3) + '-' + value.substring(3, 10) + '-' + value.substring(10, 11);
            }
        }

        // Función para aplicar máscara de teléfono (0000-000-0000)
        function aplicarMascaraTelefono(input) {
            let value = input.value.replace(/\D/g, ''); // Solo números
            
            if (value.length <= 4) {
                input.value = value;
            } else if (value.length <= 7) {
                input.value = value.substring(0, 4) + '-' + value.substring(4);
            } else if (value.length <= 11) {
                input.value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7);
            } else {
                // Limitar a 11 dígitos máximo
                input.value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7, 11);
            }
        }

        // Función para manejar teclas especiales en campos de cédula
        function manejarTeclasCedula(event) {
            const input = event.target;
            const key = event.key;
            
            // Permitir teclas de control (backspace, delete, tab, etc.)
            if (['Backspace', 'Delete', 'Tab', 'Enter', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(key)) {
                return;
            }
            
            // Solo permitir números
            if (!/^\d$/.test(key)) {
                event.preventDefault();
                return;
            }
            
            // Si ya tiene 11 dígitos, no permitir más
            const currentValue = input.value.replace(/\D/g, '');
            if (currentValue.length >= 11) {
                event.preventDefault();
                return;
            }
        }

        // Función para manejar teclas especiales en campos de teléfono
        function manejarTeclasTelefono(event) {
            const input = event.target;
            const key = event.key;
            
            // Permitir teclas de control (backspace, delete, tab, etc.)
            if (['Backspace', 'Delete', 'Tab', 'Enter', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(key)) {
                return;
            }
            
            // Solo permitir números
            if (!/^\d$/.test(key)) {
                event.preventDefault();
                return;
            }
            
            // Si ya tiene 11 dígitos, no permitir más
            const currentValue = input.value.replace(/\D/g, '');
            if (currentValue.length >= 11) {
                event.preventDefault();
                return;
            }
        }

        // Interceptar todos los formularios de eliminación de habilidades educativas
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-skill-form');
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const skillName = this.dataset.skillName || 'esta habilidad educativa';
                    
                    try {
                        const confirmed = await showConfirmation({
                            title: 'Eliminar Habilidad Educativa',
                            message: `¿Está seguro de eliminar "${skillName}"? Esta acción no se puede deshacer.`,
                            confirmText: 'Eliminar',
                            cancelText: 'Cancelar',
                            icon: 'danger',
                            confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
                            cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
                        });
                        
                        if (confirmed) {
                            // Si el usuario confirma, enviar el formulario
                            this.submit();
                        }
                    } catch (error) {
                        // Usuario canceló la acción
                        console.log('Eliminación cancelada');
                    }
                });
            });

            // Interceptar todos los formularios de eliminación de experiencias laborales
            const deleteExperienceForms = document.querySelectorAll('.delete-experience-form');
            
            deleteExperienceForms.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const companyName = this.dataset.companyName || 'esta experiencia laboral';
                    
                    try {
                        const confirmed = await showConfirmation({
                            title: 'Eliminar Experiencia Laboral',
                            message: `¿Está seguro de eliminar la experiencia en "${companyName}"? Esta acción no se puede deshacer.`,
                            confirmText: 'Eliminar',
                            cancelText: 'Cancelar',
                            icon: 'danger',
                            confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
                            cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
                        });
                        
                        if (confirmed) {
                            // Si el usuario confirma, enviar el formulario
                            this.submit();
                        }
                    } catch (error) {
                        // Usuario canceló la acción
                        console.log('Eliminación cancelada');
                    }
                });
            });

            // Interceptar todos los formularios de eliminación de referencias personales
            const deleteReferenceForms = document.querySelectorAll('.delete-reference-form');
            
            deleteReferenceForms.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const referenceName = this.dataset.referenceName || 'esta referencia personal';
                    
                    try {
                        const confirmed = await showConfirmation({
                            title: 'Eliminar Referencia Personal',
                            message: `¿Está seguro de eliminar la referencia de "${referenceName}"? Esta acción no se puede deshacer.`,
                            confirmText: 'Eliminar',
                            cancelText: 'Cancelar',
                            icon: 'danger',
                            confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
                            cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
                        });
                        
                        if (confirmed) {
                            // Si el usuario confirma, enviar el formulario
                            this.submit();
                        }
                    } catch (error) {
                        // Usuario canceló la acción
                        console.log('Eliminación cancelada');
                    }
                });
            });

            // Formato automático para cédula (000-0000000-0)
            const cedulaInput = document.getElementById('cedula_reference');
            if (cedulaInput) {
                cedulaInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // Solo números
                    
                    if (value.length > 11) {
                        value = value.substring(0, 11);
                    }
                    
                    let formattedValue = '';
                    if (value.length > 0) {
                        formattedValue = value.substring(0, 3);
                        if (value.length >= 4) {
                            formattedValue += '-' + value.substring(3, 10);
                            if (value.length >= 11) {
                                formattedValue += '-' + value.substring(10, 11);
                            }
                        }
                    }
                    
                    e.target.value = formattedValue;
                });
            }

            // Formato automático para teléfono (0000-000-0000)
            const phoneInput = document.getElementById('cell_phone_reference');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // Solo números
                    
                    if (value.length > 11) {
                        value = value.substring(0, 11);
                    }
                    
                    let formattedValue = '';
                    if (value.length > 0) {
                        formattedValue = value.substring(0, 4);
                        if (value.length >= 5) {
                            formattedValue += '-' + value.substring(4, 7);
                            if (value.length >= 8) {
                                formattedValue += '-' + value.substring(7, 11);
                            }
                        }
                    }
                    
                    e.target.value = formattedValue;
                });
            }

            // Funciones para gestionar depuraciones (data-table)
            window.viewDepuracion = function(item) {
                const id = item.id || item;
                const personId = item.person_id || '{{ $person->id }}';
                window.location.href = `{{ url('work-integrities') }}/${id}?return_to_person=${personId}`;
            };

            window.editDepuracion = function(item) {
                const id = item.id || item;
                const personId = item.person_id || '{{ $person->id }}';
                window.location.href = `{{ url('work-integrities') }}/${id}/edit?return_to_person=${personId}`;
            };

            window.deleteDepuracion = async function(item) {
                const id = item.id || item;
                const fecha = item.fecha || 'esta depuración';
                const personId = item.person_id || '{{ $person->id }}';
                
                try {
                    const confirmed = await showConfirmation({
                        title: 'Eliminar Depuración',
                        message: `¿Está seguro de eliminar la depuración del ${fecha}? Esta acción no se puede deshacer.`,
                        confirmText: 'Eliminar',
                        cancelText: 'Cancelar',
                        icon: 'danger',
                        confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
                        cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
                    });
                    
                    if (confirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ url('work-integrities') }}/${id}`;
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        
                        const returnToPersonField = document.createElement('input');
                        returnToPersonField.type = 'hidden';
                        returnToPersonField.name = 'return_to_person';
                        returnToPersonField.value = personId;
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        form.appendChild(returnToPersonField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                } catch (error) {
                    console.log('Eliminación cancelada');
                }
            };
            
            // Event listeners para campos de cédula
            const dniField = document.getElementById('dni');
            if (dniField) {
                dniField.addEventListener('input', function() {
                    aplicarMascaraCedula(this);
                });
                dniField.addEventListener('keydown', manejarTeclasCedula);
                
                // Aplicar máscara inicial si tiene valor
                if (dniField.value) {
                    aplicarMascaraCedula(dniField);
                }
            }

            const previousDniField = document.getElementById('previous_dni');
            if (previousDniField) {
                previousDniField.addEventListener('input', function() {
                    aplicarMascaraCedula(this);
                });
                previousDniField.addEventListener('keydown', manejarTeclasCedula);
                
                // Aplicar máscara inicial si tiene valor
                if (previousDniField.value) {
                    aplicarMascaraCedula(previousDniField);
                }
            }

            // Event listeners para campos de teléfono
            const cellPhoneField = document.getElementById('cell_phone');
            if (cellPhoneField) {
                cellPhoneField.addEventListener('input', function() {
                    aplicarMascaraTelefono(this);
                });
                cellPhoneField.addEventListener('keydown', manejarTeclasTelefono);
                
                // Aplicar máscara inicial si tiene valor
                if (cellPhoneField.value) {
                    aplicarMascaraTelefono(cellPhoneField);
                }
            }

            const homePhoneField = document.getElementById('home_phone');
            if (homePhoneField) {
                homePhoneField.addEventListener('input', function() {
                    aplicarMascaraTelefono(this);
                });
                homePhoneField.addEventListener('keydown', manejarTeclasTelefono);
                
                // Aplicar máscara inicial si tiene valor
                if (homePhoneField.value) {
                    aplicarMascaraTelefono(homePhoneField);
                }
            }

            // Event listeners para teléfono de contacto de emergencia
            const emergencyContactPhoneField = document.getElementById('emergency_contact_phone');
            if (emergencyContactPhoneField) {
                emergencyContactPhoneField.addEventListener('input', function() {
                    aplicarMascaraTelefono(this);
                });
                emergencyContactPhoneField.addEventListener('keydown', manejarTeclasTelefono);
                
                // Aplicar máscara inicial si tiene valor
                if (emergencyContactPhoneField.value) {
                    aplicarMascaraTelefono(emergencyContactPhoneField);
                }
            }
        });
    </script>
</x-app-layout>