<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro de Persona - Integridad Laboral</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&amp;display=swap" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1173d4",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922"
                    },
                    fontFamily: {
                        "display": ["Manrope"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    }
                }
            }
        }
    </script>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
    <div class="min-h-screen py-8" x-data="wizardForm()">
        <!-- Header -->
        <header class="container mx-auto px-4 mb-8">
            <div class="flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 text-primary">
                        <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wider">Integridad Laboral</h1>
                </a>
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white bg-transparent rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 transition-colors">
                    Iniciar Sesión
                </a>
            </div>
        </header>

        <!-- Progress Bar -->
        <div class="container mx-auto px-4 mb-8">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Paso <span x-text="currentStep"></span> de 7</span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="Math.round((currentStep / 7) * 100) + '%'"></span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-primary h-2 rounded-full transition-all duration-300" :style="'width: ' + (currentStep / 7) * 100 + '%'"></div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <form method="POST" action="{{ route('public.person-registration.store') }}" enctype="multipart/form-data" @submit="submitForm($event)">
                    @csrf

                    <!-- Mensajes de Error -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Por favor corrige los siguientes errores:</h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Paso 1: Información Personal -->
                    <div x-show="currentStep === 1" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Información Personal</h2>
                        
                        <!-- Foto de Perfil -->
                        <div class="mb-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">FOTO DE PERFIL (Opcional)</label>
                            <div class="flex items-center space-x-6">
                                <div class="relative">
                                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                        <template x-if="previewImage">
                                            <img :src="previewImage" alt="Preview" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!previewImage">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="profile_photo" class="bg-primary hover:bg-primary/90 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 cursor-pointer inline-block">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        Subir foto
                                    </label>
                                    <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/jpg,image/png,image/gif" @change="handleFileSelect($event)" class="hidden">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Permitido JPG, GIF o PNG. Tamaño máximo de 800K</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="name">NOMBRE *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="name" name="name" type="text" x-model="formData.name" required />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Apellidos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="last_name">APELLIDOS *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="last_name" name="last_name" type="text" x-model="formData.last_name" required />
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cédula -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="dni">CÉDULA *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="dni" name="dni" type="text" x-model="formData.dni" placeholder="000-0000000-0" maxlength="13" pattern="\d{3}-\d{7}-\d{1}" required />
                                @error('dni')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cédula Anterior -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="previous_dni">CÉDULA ANTERIOR</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="previous_dni" name="previous_dni" type="text" x-model="formData.previous_dni" placeholder="000-0000000-0" maxlength="13" />
                                @error('previous_dni')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Género -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="gender">SEXO</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="gender" name="gender" x-model="formData.gender">
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="otro">Otro</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nacionalidad -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="country">NACIONALIDAD *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="country" name="country" type="text" x-model="formData.country" required />
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lugar de Nacimiento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="birth_place">LUGAR DE NACIMIENTO *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="birth_place" name="birth_place" type="text" x-model="formData.birth_place" required />
                                @error('birth_place')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fecha de Nacimiento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="birth_date">FECHA DE NACIMIENTO *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="birth_date" name="birth_date" type="date" x-model="formData.birth_date" @change="calculateAge()" required />
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Edad -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="age">EDAD</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="age" name="age" type="number" x-model="formData.age" min="0" max="120" readonly />
                                @error('age')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Estado Civil -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="marital_status">ESTADO CIVIL</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="marital_status" name="marital_status" x-model="formData.marital_status">
                                    <option value="">Seleccionar...</option>
                                    <option value="soltero">Soltero</option>
                                    <option value="casado">Casado</option>
                                    <option value="viudo">Viudo</option>
                                </select>
                                @error('marital_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="email">CORREO ELECTRÓNICO *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="email" name="email" type="email" x-model="formData.email" required />
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono Móvil -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="cell_phone">TELÉFONO MÓVIL *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="cell_phone" name="cell_phone" type="tel" x-model="formData.cell_phone" placeholder="0000-000-0000" maxlength="13" pattern="\d{4}-\d{3}-\d{4}" required />
                                @error('cell_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono Fijo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="home_phone">TELÉFONO FIJO</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="home_phone" name="home_phone" type="tel" x-model="formData.home_phone" placeholder="0000-000-0000" maxlength="13" />
                                @error('home_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Red Social 1 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="social_media_1">RED SOCIAL 1</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="social_media_1" name="social_media_1" type="text" x-model="formData.social_media_1" placeholder="Facebook, Instagram, etc." />
                                @error('social_media_1')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Red Social 2 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="social_media_2">RED SOCIAL 2</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="social_media_2" name="social_media_2" type="text" x-model="formData.social_media_2" placeholder="LinkedIn, Twitter, etc." />
                                @error('social_media_2')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipo de Sangre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="blood_type">TIPO DE SANGRE</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="blood_type" name="blood_type" x-model="formData.blood_type">
                                    <option value="">Seleccionar...</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                                @error('blood_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alergias a Medicamentos -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="medication_allergies">ALERGIAS A MEDICAMENTOS</label>
                                <textarea class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="medication_allergies" name="medication_allergies" rows="2" x-model="formData.medication_allergies" placeholder="Describa las alergias a medicamentos..."></textarea>
                                @error('medication_allergies')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Enfermedades -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="illnesses">ENFERMEDADES</label>
                                <textarea class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="illnesses" name="illnesses" rows="2" x-model="formData.illnesses" placeholder="Describa enfermedades crónicas o condiciones médicas..."></textarea>
                                @error('illnesses')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nombre Contacto Emergencia -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="emergency_contact_name">NOMBRE CONTACTO EMERGENCIA *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="emergency_contact_name" name="emergency_contact_name" type="text" x-model="formData.emergency_contact_name" required />
                                @error('emergency_contact_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono Contacto Emergencia -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="emergency_contact_phone">TELÉFONO CONTACTO EMERGENCIA *</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="emergency_contact_phone" name="emergency_contact_phone" type="tel" x-model="formData.emergency_contact_phone" placeholder="0000-000-0000" maxlength="13" pattern="\d{4}-\d{3}-\d{4}" required />
                                @error('emergency_contact_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Otros Contactos de Emergencia -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="other_emergency_contacts">OTROS CONTACTOS DE EMERGENCIA</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="other_emergency_contacts" name="other_emergency_contacts" type="text" x-model="formData.other_emergency_contacts" placeholder="Información adicional de contactos de emergencia..." />
                                @error('other_emergency_contacts')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Paso 2: Información Residencial -->
                    <div x-show="currentStep === 2" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Información Residencial</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Regional (readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">REGIONAL</label>
                                <input type="text" 
                                    :value="selectedRegional" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                    readonly />
                            </div>
                            
                            <!-- Provincia (readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">PROVINCIA</label>
                                <input type="text" 
                                    :value="selectedProvince" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                    readonly />
                            </div>
                            
                            <!-- Municipio -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="municipality_id">MUNICIPIO *</label>
                                <select id="municipality_id" 
                                    name="municipality_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                    x-model="formData.municipality_id"
                                    @change="loadDistricts()"
                                    required>
                                    <option value="">Seleccione un municipio...</option>
                                    @foreach($municipalities as $municipality)
                                        <option value="{{ $municipality->id }}" 
                                            data-regional="{{ $municipality->province?->regional?->name ?? '' }}"
                                            data-province="{{ $municipality->province?->name ?? '' }}">
                                            {{ $municipality->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('municipality_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Distrito -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="district_id">DISTRITO</label>
                                <select id="district_id" 
                                    name="district_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                    x-model="formData.district_id"
                                    :disabled="!formData.municipality_id">
                                    <option value="">Seleccione primero un municipio...</option>
                                    <template x-for="district in districts" :key="district.id">
                                        <option :value="district.id" x-text="district.name"></option>
                                    </template>
                                    <option value="no_aplica">No aplica</option>
                                </select>
                                @error('district_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sector -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="sector">SECTOR</label>
                                <input type="text" 
                                    name="sector" 
                                    id="sector"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                    x-model="formData.sector">
                                @error('sector')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Barrio -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="neighborhood">BARRIO</label>
                                <input type="text" 
                                    name="neighborhood" 
                                    id="neighborhood"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                    x-model="formData.neighborhood">
                                @error('neighborhood')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Calle y Número -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="street_and_number">CALLE Y NÚMERO</label>
                                <input type="text" 
                                    name="street_and_number" 
                                    id="street_and_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                    x-model="formData.street_and_number">
                                @error('street_and_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Referencia de Llegada -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="arrival_reference">REFERENCIA DE LLEGADA</label>
                                <textarea class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="arrival_reference" name="arrival_reference" rows="3" x-model="formData.arrival_reference" placeholder="Indicaciones para llegar a su residencia..."></textarea>
                                @error('arrival_reference')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Paso 3: Habilidades Educativas -->
                    <div x-show="currentStep === 3" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Habilidades Educativas</h2>
                        
                        <div class="space-y-4">
                            <template x-for="(skill, index) in formData.educational_skills" :key="index">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="font-medium text-gray-900 dark:text-white">Habilidad Educativa <span x-text="index + 1"></span></h3>
                                        <button type="button" @click="removeEducationalSkill(index)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">CARRERA *</label>
                                            <input type="text" 
                                                :name="'educational_skills[' + index + '][career]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="skill.career"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">CENTRO EDUCATIVO *</label>
                                            <input type="text" 
                                                :name="'educational_skills[' + index + '][educational_center]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="skill.educational_center"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">AÑO DE GRADUACIÓN *</label>
                                            <input type="number" 
                                                :name="'educational_skills[' + index + '][year]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="skill.year"
                                                min="1900"
                                                :max="{{ date('Y') + 10 }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            
                            <button type="button" @click="addEducationalSkill()" class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                + Agregar Otra Habilidad Educativa
                            </button>
                        </div>
                    </div>

                    <!-- Paso 4: Experiencias Laborales -->
                    <div x-show="currentStep === 4" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Experiencias Laborales</h2>
                        
                        <div class="space-y-4">
                            <template x-for="(experience, index) in formData.work_experiences" :key="index">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="font-medium text-gray-900 dark:text-white">Experiencia Laboral <span x-text="index + 1"></span></h3>
                                        <button type="button" @click="removeWorkExperience(index)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">NOMBRE DE LA EMPRESA *</label>
                                            <input type="text" 
                                                :name="'work_experiences[' + index + '][company_name]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="experience.company_name"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">POSICIÓN *</label>
                                            <input type="text" 
                                                :name="'work_experiences[' + index + '][position]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="experience.position"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">RANGO DE AÑOS *</label>
                                            <input type="text" 
                                                :name="'work_experiences[' + index + '][year_range]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="experience.year_range"
                                                placeholder="Ej: 2020-2023"
                                                required>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">LOGROS</label>
                                            <textarea 
                                                :name="'work_experiences[' + index + '][achievements]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                rows="3"
                                                x-model="experience.achievements"
                                                placeholder="Describa los logros alcanzados en esta posición..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            
                            <button type="button" @click="addWorkExperience()" class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                + Agregar Otra Experiencia Laboral
                            </button>
                        </div>
                    </div>

                    <!-- Paso 5: Referencias Personales -->
                    <div x-show="currentStep === 5" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Referencias Personales</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Debe agregar al menos una referencia personal.</p>
                        
                        <div class="space-y-4">
                            <template x-for="(reference, index) in formData.personal_references" :key="index">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="font-medium text-gray-900 dark:text-white">Referencia <span x-text="index + 1"></span></h3>
                                        <button type="button" @click="removePersonalReference(index)" :disabled="formData.personal_references.length <= 1" 
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">RELACIÓN *</label>
                                            <select 
                                                :name="'personal_references[' + index + '][relationship]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="reference.relationship"
                                                required>
                                                <option value="">Seleccionar...</option>
                                                <option value="padre">Padre</option>
                                                <option value="madre">Madre</option>
                                                <option value="conyuge">Cónyuge</option>
                                                <option value="hermano">Hermano</option>
                                                <option value="tio">Tío</option>
                                                <option value="amigo">Amigo</option>
                                                <option value="otros">Otros</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">NOMBRE COMPLETO *</label>
                                            <input type="text" 
                                                :name="'personal_references[' + index + '][full_name]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="reference.full_name"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">CÉDULA *</label>
                                            <input type="text" 
                                                :name="'personal_references[' + index + '][cedula]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="reference.cedula"
                                                placeholder="000-0000000-0"
                                                maxlength="13"
                                                pattern="\d{3}-\d{7}-\d{1}"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">TELÉFONO CELULAR *</label>
                                            <input type="tel" 
                                                :name="'personal_references[' + index + '][cell_phone]'"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm"
                                                x-model="reference.cell_phone"
                                                placeholder="0000-000-0000"
                                                maxlength="13"
                                                pattern="\d{4}-\d{3}-\d{4}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            
                            <button type="button" @click="addPersonalReference()" class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                + Agregar Otra Referencia
                            </button>
                        </div>
                    </div>

                    <!-- Paso 6: Aspiraciones -->
                    <div x-show="currentStep === 6" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Aspiraciones</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="desired_position">POSICIÓN DESEADA</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="desired_position" name="desired_position" type="text" x-model="formData.desired_position" />
                                @error('desired_position')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="sector_of_interest">SECTOR DE INTERÉS</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="sector_of_interest" name="sector_of_interest" type="text" x-model="formData.sector_of_interest" />
                                @error('sector_of_interest')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="expected_salary">SALARIO ESPERADO</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="expected_salary" name="expected_salary" type="number" step="0.01" min="0" x-model="formData.expected_salary" />
                                @error('expected_salary')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="contract_type_preference">TIPO DE CONTRATO PREFERIDO</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="contract_type_preference" name="contract_type_preference" x-model="formData.contract_type_preference">
                                    <option value="">Seleccionar...</option>
                                    <option value="tiempo_completo">Tiempo Completo</option>
                                    <option value="medio_tiempo">Medio Tiempo</option>
                                    <option value="remoto">Remoto</option>
                                    <option value="hibrido">Híbrido</option>
                                </select>
                                @error('contract_type_preference')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="employment_status">ESTATUS LABORAL *</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="employment_status" name="employment_status" x-model="formData.employment_status" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="contratado">Contratado</option>
                                    <option value="disponible">Disponible</option>
                                    <option value="en_proceso">En Proceso</option>
                                    <option value="discapacitado">Discapacitado</option>
                                    <option value="fallecido">Fallecido</option>
                                </select>
                                @error('employment_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="work_scope">ALCANCE LABORAL *</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="work_scope" name="work_scope" x-model="formData.work_scope" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="provincial">Provincial</option>
                                    <option value="nacional">Nacional</option>
                                </select>
                                @error('work_scope')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="short_term_goals">METAS A CORTO PLAZO</label>
                                <textarea class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="short_term_goals" name="short_term_goals" rows="4" x-model="formData.short_term_goals" placeholder="Describa sus metas profesionales a corto plazo..."></textarea>
                                @error('short_term_goals')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Paso 7: Creación de Usuario y Confirmación -->
                    <div x-show="currentStep === 7" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Crear Cuenta y Confirmar</h2>
                        
                        <div class="space-y-6">
                            <!-- Información de Usuario -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="font-medium text-gray-900 dark:text-white mb-4">Información de Acceso</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1">CORREO ELECTRÓNICO</label>
                                        <input type="email" 
                                            :value="formData.email" 
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                            readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="password">CONTRASEÑA *</label>
                                        <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                            id="password" name="password" type="password" x-model="formData.password" minlength="8" required />
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase mb-1" for="password_confirmation">CONFIRMAR CONTRASEÑA *</label>
                                        <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                            id="password_confirmation" name="password_confirmation" type="password" x-model="formData.password_confirmation" minlength="8" required />
                                    </div>
                                </div>
                            </div>

                            <!-- Términos y Condiciones -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <label class="flex items-start">
                                    <input type="checkbox" 
                                        name="terms_accepted" 
                                        value="1"
                                        class="mt-1 rounded border-gray-300 text-primary focus:ring-primary"
                                        required>
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Acepto los términos y condiciones del servicio. *
                                    </span>
                                </label>
                                @error('terms_accepted')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Resumen -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="font-medium text-gray-900 dark:text-white mb-4">Resumen de Información</h3>
                                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                    <p><strong>Nombre:</strong> <span x-text="formData.name + ' ' + formData.last_name"></span></p>
                                    <p><strong>Cédula:</strong> <span x-text="formData.dni"></span></p>
                                    <p><strong>Email:</strong> <span x-text="formData.email"></span></p>
                                    <p><strong>Habilidades Educativas:</strong> <span x-text="formData.educational_skills.length"></span></p>
                                    <p><strong>Experiencias Laborales:</strong> <span x-text="formData.work_experiences.length"></span></p>
                                    <p><strong>Referencias Personales:</strong> <span x-text="formData.personal_references.length"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Navegación -->
                    <div class="mt-8 flex justify-between">
                        <button type="button" 
                            @click="previousStep()" 
                            x-show="currentStep > 1"
                            class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200">
                            Anterior
                        </button>
                        <div class="ml-auto"></div>
                        <button type="button" 
                            @click="nextStep()" 
                            x-show="currentStep < 7"
                            class="bg-primary hover:bg-primary/90 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200">
                            Siguiente
                        </button>
                        <button type="submit" 
                            x-show="currentStep === 7"
                            :disabled="isSubmitting"
                            class="bg-primary hover:bg-primary/90 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isSubmitting">Finalizar Registro y Generar CV</span>
                            <span x-show="isSubmitting">Procesando...</span>
                        </button>
                    </div>
                </form>
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

        function wizardForm() {
            return {
                currentStep: 1,
                previewImage: null,
                isSubmitting: false,
                districts: [],
                selectedRegional: '',
                selectedProvince: '',
                formData: {
                    name: '',
                    last_name: '',
                    dni: '',
                    previous_dni: '',
                    gender: '',
                    country: '',
                    birth_place: '',
                    birth_date: '',
                    age: '',
                    marital_status: '',
                    email: '',
                    cell_phone: '',
                    home_phone: '',
                    social_media_1: '',
                    social_media_2: '',
                    blood_type: '',
                    medication_allergies: '',
                    illnesses: '',
                    emergency_contact_name: '',
                    emergency_contact_phone: '',
                    other_emergency_contacts: '',
                    municipality_id: '',
                    district_id: '',
                    sector: '',
                    neighborhood: '',
                    street_and_number: '',
                    arrival_reference: '',
                    educational_skills: [],
                    work_experiences: [],
                    personal_references: [{ relationship: '', full_name: '', cedula: '', cell_phone: '' }],
                    desired_position: '',
                    sector_of_interest: '',
                    expected_salary: '',
                    contract_type_preference: '',
                    short_term_goals: '',
                    employment_status: '',
                    work_scope: '',
                    password: '',
                    password_confirmation: ''
                },
                
                init() {
                    // Cargar datos de sesión si existen
                    const savedData = sessionStorage.getItem('personRegistrationData');
                    if (savedData) {
                        this.formData = { ...this.formData, ...JSON.parse(savedData) };
                    }
                    
                    // Cargar distritos si hay municipio seleccionado
                    if (this.formData.municipality_id) {
                        this.loadDistricts();
                    }
                    
                    // Aplicar máscaras a campos de cédula y teléfono
                    this.$nextTick(() => {
                        this.applyMasks();
                    });
                },
                
                applyMasks() {
                    // Aplicar máscara a cédula
                    const dniField = document.getElementById('dni');
                    if (dniField) {
                        dniField.addEventListener('input', function() {
                            aplicarMascaraCedula(this);
                        });
                        dniField.addEventListener('keydown', manejarTeclasCedula);
                        if (dniField.value) {
                            aplicarMascaraCedula(dniField);
                        }
                    }

                    // Aplicar máscara a cédula anterior
                    const previousDniField = document.getElementById('previous_dni');
                    if (previousDniField) {
                        previousDniField.addEventListener('input', function() {
                            aplicarMascaraCedula(this);
                        });
                        previousDniField.addEventListener('keydown', manejarTeclasCedula);
                        if (previousDniField.value) {
                            aplicarMascaraCedula(previousDniField);
                        }
                    }

                    // Aplicar máscara a teléfono móvil
                    const cellPhoneField = document.getElementById('cell_phone');
                    if (cellPhoneField) {
                        cellPhoneField.addEventListener('input', function() {
                            aplicarMascaraTelefono(this);
                        });
                        cellPhoneField.addEventListener('keydown', manejarTeclasTelefono);
                        if (cellPhoneField.value) {
                            aplicarMascaraTelefono(cellPhoneField);
                        }
                    }

                    // Aplicar máscara a teléfono fijo
                    const homePhoneField = document.getElementById('home_phone');
                    if (homePhoneField) {
                        homePhoneField.addEventListener('input', function() {
                            aplicarMascaraTelefono(this);
                        });
                        homePhoneField.addEventListener('keydown', manejarTeclasTelefono);
                        if (homePhoneField.value) {
                            aplicarMascaraTelefono(homePhoneField);
                        }
                    }

                    // Aplicar máscara a teléfono de emergencia
                    const emergencyPhoneField = document.getElementById('emergency_contact_phone');
                    if (emergencyPhoneField) {
                        emergencyPhoneField.addEventListener('input', function() {
                            aplicarMascaraTelefono(this);
                        });
                        emergencyPhoneField.addEventListener('keydown', manejarTeclasTelefono);
                        if (emergencyPhoneField.value) {
                            aplicarMascaraTelefono(emergencyPhoneField);
                        }
                    }
                    
                    // Aplicar máscaras a campos dinámicos de referencias personales
                    this.applyReferenceMasks();
                },
                
                applyReferenceMasks() {
                    // Aplicar máscaras a todos los campos de cédula y teléfono en referencias
                    // Solo aplicar si no tienen el atributo data-mask-applied
                    document.querySelectorAll('input[name*="[cedula]"]:not([data-mask-applied])').forEach(input => {
                        input.setAttribute('data-mask-applied', 'true');
                        input.addEventListener('input', function() {
                            aplicarMascaraCedula(this);
                        });
                        input.addEventListener('keydown', manejarTeclasCedula);
                    });
                    
                    document.querySelectorAll('input[name*="[cell_phone]"]:not([data-mask-applied])').forEach(input => {
                        input.setAttribute('data-mask-applied', 'true');
                        input.addEventListener('input', function() {
                            aplicarMascaraTelefono(this);
                        });
                        input.addEventListener('keydown', manejarTeclasTelefono);
                    });
                },
                
                nextStep() {
                    if (this.validateStep()) {
                        this.saveToSession();
                        this.currentStep++;
                        // Aplicar máscaras cuando se cambia de paso
                        this.$nextTick(() => {
                            this.applyMasks();
                        });
                    }
                },
                
                previousStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                        // Aplicar máscaras cuando se cambia de paso
                        this.$nextTick(() => {
                            this.applyMasks();
                        });
                    }
                },
                
                validateStep() {
                    const form = document.querySelector('form');
                    const stepElement = form.querySelector(`[x-show="currentStep === ${this.currentStep}"]`);
                    const inputs = stepElement.querySelectorAll('input[required], select[required], textarea[required]');
                    
                    let isValid = true;
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            isValid = false;
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                    });
                    
                    // Validación especial para paso 5 (referencias)
                    if (this.currentStep === 5 && this.formData.personal_references.length < 1) {
                        alert('Debe agregar al menos una referencia personal.');
                        isValid = false;
                    }
                    
                    if (!isValid) {
                        alert('Por favor complete todos los campos requeridos antes de continuar.');
                    }
                    
                    return isValid;
                },
                
                saveToSession() {
                    sessionStorage.setItem('personRegistrationData', JSON.stringify(this.formData));
                },
                
                calculateAge() {
                    if (this.formData.birth_date) {
                        const birthDate = new Date(this.formData.birth_date);
                        const today = new Date();
                        let age = today.getFullYear() - birthDate.getFullYear();
                        const monthDiff = today.getMonth() - birthDate.getMonth();
                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }
                        this.formData.age = age;
                    }
                },
                
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (file.size > 800 * 1024) {
                            alert('El archivo es demasiado grande. El tamaño máximo es 800KB.');
                            event.target.value = '';
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewImage = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },
                
                loadDistricts() {
                    if (!this.formData.municipality_id) {
                        this.districts = [];
                        this.selectedRegional = '';
                        this.selectedProvince = '';
                        return;
                    }
                    
                    const select = document.getElementById('municipality_id');
                    const selectedOption = select.options[select.selectedIndex];
                    this.selectedRegional = selectedOption.getAttribute('data-regional') || '';
                    this.selectedProvince = selectedOption.getAttribute('data-province') || '';
                    
                    fetch(`{{ route('public.person-registration.districts-by-municipality') }}?municipality_id=${this.formData.municipality_id}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.districts = data;
                    })
                    .catch(error => {
                        console.error('Error loading districts:', error);
                    });
                },
                
                addEducationalSkill() {
                    this.formData.educational_skills.push({
                        career: '',
                        educational_center: '',
                        year: ''
                    });
                },
                
                removeEducationalSkill(index) {
                    this.formData.educational_skills.splice(index, 1);
                },
                
                addWorkExperience() {
                    this.formData.work_experiences.push({
                        company_name: '',
                        position: '',
                        year_range: '',
                        achievements: ''
                    });
                },
                
                removeWorkExperience(index) {
                    this.formData.work_experiences.splice(index, 1);
                },
                
                addPersonalReference() {
                    this.formData.personal_references.push({
                        relationship: '',
                        full_name: '',
                        cedula: '',
                        cell_phone: ''
                    });
                    // Aplicar máscaras a los nuevos campos
                    this.$nextTick(() => {
                        this.applyReferenceMasks();
                    });
                },
                
                removePersonalReference(index) {
                    if (this.formData.personal_references.length > 1) {
                        this.formData.personal_references.splice(index, 1);
                    }
                },
                
                submitForm(event) {
                    if (this.validateStep()) {
                        this.isSubmitting = true;
                        // Limpiar sessionStorage antes de enviar
                        sessionStorage.removeItem('personRegistrationData');
                        // Permitir que el formulario se envíe normalmente
                        return true;
                    } else {
                        event.preventDefault();
                        this.isSubmitting = false;
                        return false;
                    }
                }
            }
        }
    </script>
</body>
</html>

