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

    <div class="py-6" x-data="tabManager()" data-active-tab="{{ session('activeTab', 'personal') }}">
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
                                                id="cell_phone" name="cell_phone" type="tel" value="{{ old('cell_phone', $person->cell_phone) }}" placeholder="0000-000-0000" maxlength="12" required />
                                            @error('cell_phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Teléfono Fijo -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="home_phone">TELÉFONO FIJO</label>
                                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                id="home_phone" name="home_phone" type="tel" value="{{ old('home_phone', $person->home_phone) }}" placeholder="0000-000-0000" maxlength="12" />
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
                                                id="emergency_contact_phone" name="emergency_contact_phone" type="tel" value="{{ old('emergency_contact_phone', $person->emergency_contact_phone) }}" placeholder="0000-000-0000" maxlength="12" required />
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
                                                   value="{{ old('regional', $person->residenceInformation->province->regional->name ?? '') }}"
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
                                                   value="{{ old('provincia', $person->residenceInformation->province->name ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                                   readonly />
                                        </div>
                                        
                                        <!-- Municipio (readonly) -->
                                        <div>
                                            <label for="municipio_residence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                MUNICIPIO
                                            </label>
                                            <input type="text" 
                                                   id="municipio_residence" 
                                                   name="municipio"
                                                   value="{{ old('municipio', $person->residenceInformation->municipality->name ?? '') }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                                   readonly />
                                            
                                            <!-- Selector de municipio (solo visible cuando distrito = "no_aplica") -->
                                            <select id="municipio_select_residence" 
                                                    name="municipality_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                                    style="display: none;">
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
                                                            {{ old('municipality_id', $person->residenceInformation->municipality_id ?? '') == $municipality->id ? 'selected' : '' }}>
                                                        {{ $municipality->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Distrito (select) -->
                                        <div>
                                            <label for="district_id_residence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                DISTRITO
                                            </label>
                                            <select id="district_id_residence" 
                                                    name="district_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm">
                                                <option value="">Seleccione...</option>
                                                <option value="no_aplica" {{ old('district_id', $person->residenceInformation->district_id ?? '') == 'no_aplica' || (!$person->residenceInformation->district_id && $person->residenceInformation) ? 'selected' : '' }}>No aplica</option>
                                                @foreach($districts as $district)
                                                    @php
                                                        $regional = $district->municipality && $district->municipality->province && $district->municipality->province->regional 
                                                            ? $district->municipality->province->regional->name 
                                                            : '';
                                                        $provincia = $district->municipality && $district->municipality->province 
                                                            ? $district->municipality->province->name 
                                                            : '';
                                                        $municipio = $district->municipality 
                                                            ? $district->municipality->name 
                                                            : '';
                                                    @endphp
                                                    <option value="{{ $district->id }}" 
                                                            data-regional="{{ $regional }}"
                                                            data-provincia="{{ $provincia }}"
                                                            data-municipio="{{ $municipio }}"
                                                            {{ old('district_id', $person->residenceInformation->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                                        {{ $district->name }}
                                                    </option>
                                                @endforeach
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
                                                   value="{{ old('sector', $person->residenceInformation->sector ?? '') }}"
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
                                                   value="{{ old('neighborhood', $person->residenceInformation->neighborhood ?? '') }}"
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
                                                   value="{{ old('street_and_number', $person->residenceInformation->street_and_number ?? '') }}"
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
                                                   value="{{ old('arrival_reference', $person->residenceInformation->arrival_reference ?? '') }}"
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
                            // Función para auto-completar campos cuando se selecciona un distrito
                            document.getElementById('district_id_residence').addEventListener('change', function() {
                                const distritoSeleccionado = this.options[this.selectedIndex];
                                const regionalInput = document.getElementById('regional_residence');
                                const provinciaInput = document.getElementById('provincia_residence');
                                const municipioInput = document.getElementById('municipio_residence');
                                const municipioSelect = document.getElementById('municipio_select_residence');

                                if (distritoSeleccionado.value === 'no_aplica') {
                                    // Mostrar selector de municipios y ocultar input readonly
                                    municipioSelect.style.display = 'block';
                                    municipioInput.style.display = 'none';
                                    // Limpiar campos readonly
                                    regionalInput.value = '';
                                    provinciaInput.value = '';
                                    municipioInput.value = '';
                                } else if (distritoSeleccionado.value) {
                                    // Ocultar selector de municipios y mostrar input readonly
                                    municipioSelect.style.display = 'none';
                                    municipioInput.style.display = 'block';
                                    // Auto-completar con datos del distrito
                                    regionalInput.value = distritoSeleccionado.getAttribute('data-regional') || '';
                                    provinciaInput.value = distritoSeleccionado.getAttribute('data-provincia') || '';
                                    municipioInput.value = distritoSeleccionado.getAttribute('data-municipio') || '';
                                } else {
                                    // Limpiar todo
                                    municipioSelect.style.display = 'none';
                                    municipioInput.style.display = 'block';
                                    regionalInput.value = '';
                                    provinciaInput.value = '';
                                    municipioInput.value = '';
                                }
                            });

                            // Función para auto-completar campos cuando se selecciona un municipio (caso "no_aplica")
                            document.getElementById('municipio_select_residence').addEventListener('change', function() {
                                const municipioSeleccionado = this.options[this.selectedIndex];
                                const regionalInput = document.getElementById('regional_residence');
                                const provinciaInput = document.getElementById('provincia_residence');
                                const municipioInput = document.getElementById('municipio_residence');

                                if (municipioSeleccionado.value) {
                                    regionalInput.value = municipioSeleccionado.getAttribute('data-regional') || '';
                                    provinciaInput.value = municipioSeleccionado.getAttribute('data-provincia') || '';
                                    municipioInput.value = municipioSeleccionado.options[municipioSeleccionado.selectedIndex].text;
                                } else {
                                    regionalInput.value = '';
                                    provinciaInput.value = '';
                                    municipioInput.value = '';
                                }
                            });
                            
                            // Inicializar el estado correcto al cargar la página
                            window.addEventListener('DOMContentLoaded', function() {
                                const districtSelect = document.getElementById('district_id_residence');
                                const selectedOption = districtSelect.options[districtSelect.selectedIndex];
                                
                                if (selectedOption.value === 'no_aplica') {
                                    document.getElementById('municipio_select_residence').style.display = 'block';
                                    document.getElementById('municipio_residence').style.display = 'none';
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

    <script>
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
        });
    </script>
</x-app-layout>