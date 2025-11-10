<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro de Empresa - Integridad Laboral</title>
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
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
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
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Paso <span x-text="currentStep"></span> de 3</span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="Math.round((currentStep / 3) * 100) + '%'"></span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-primary h-2 rounded-full transition-all duration-300" :style="'width: ' + (currentStep / 3) * 100 + '%'"></div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <form method="POST" action="{{ route('public.company-registration.store') }}" @submit="submitForm($event)">
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

                    <!-- Paso 1: Datos de la Empresa -->
                    <div x-show="currentStep === 1" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Datos de la Empresa</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nombre de Empresa -->
                            <div class="md:col-span-2">
                                <label for="business_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Nombre de la Empresa <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="business_name" 
                                    name="business_name" 
                                    x-model="formData.business_name"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Nombre completo de la empresa"
                                >
                            </div>

                            <!-- Sucursal -->
                            <div>
                                <label for="branch" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Sucursal
                                </label>
                                <input 
                                    type="text" 
                                    id="branch" 
                                    name="branch" 
                                    x-model="formData.branch"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Nombre de la sucursal"
                                >
                            </div>

                            <!-- RNC -->
                            <div>
                                <label for="rnc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    RNC
                                </label>
                                <input 
                                    type="text" 
                                    id="rnc" 
                                    name="rnc" 
                                    x-model="formData.rnc"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="RNC de la empresa"
                                >
                            </div>

                            <!-- Rubro -->
                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Rubro/Industria
                                </label>
                                <input 
                                    type="text" 
                                    id="industry" 
                                    name="industry" 
                                    x-model="formData.industry"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Rubro o industria"
                                >
                            </div>

                            <!-- Provincia -->
                            <div>
                                <label for="province_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Provincia <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="province_id" 
                                    name="province_id" 
                                    x-model="formData.province_id"
                                    @change="loadMunicipalities()"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                >
                                    <option value="">Seleccione una provincia</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Municipio -->
                            <div>
                                <label for="municipality_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Municipio <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="municipality_id" 
                                    name="municipality_id" 
                                    x-model="formData.municipality_id"
                                    required
                                    :disabled="!formData.province_id"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary disabled:bg-gray-100 disabled:dark:bg-gray-600"
                                >
                                    <option value="">Seleccione primero una provincia</option>
                                    <template x-for="municipality in municipalities" :key="municipality.id">
                                        <option :value="municipality.id" x-text="municipality.name"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Sector -->
                            <div>
                                <label for="sector" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Sector
                                </label>
                                <input 
                                    type="text" 
                                    id="sector" 
                                    name="sector" 
                                    x-model="formData.sector"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Sector o dirección"
                                >
                            </div>

                            <!-- Teléfono Fijo -->
                            <div>
                                <label for="landline_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Teléfono Fijo
                                </label>
                                <input 
                                    type="tel" 
                                    id="landline_phone" 
                                    name="landline_phone" 
                                    x-model="formData.landline_phone"
                                    maxlength="13"
                                    pattern="\d{4}-\d{3}-\d{4}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="0000-000-0000"
                                >
                            </div>

                            <!-- Extensión -->
                            <div>
                                <label for="extension" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Extensión
                                </label>
                                <input 
                                    type="text" 
                                    id="extension" 
                                    name="extension" 
                                    x-model="formData.extension"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Extensión telefónica"
                                >
                            </div>

                            <!-- Correo Electrónico -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Correo Electrónico
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    x-model="formData.email"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="correo@empresa.com"
                                >
                            </div>
                        </div>

                        <!-- Botones de Navegación -->
                        <div class="flex justify-end mt-6">
                            <button 
                                type="button" 
                                @click="nextStep()"
                                class="px-6 py-2 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors duration-200">
                                Siguiente
                            </button>
                        </div>
                    </div>

                    <!-- Paso 2: Datos del Representante -->
                    <div x-show="currentStep === 2" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Datos del Representante Autorizado</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nombre y Apellidos -->
                            <div class="md:col-span-2">
                                <label for="representative_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Nombre y Apellidos
                                </label>
                                <input 
                                    type="text" 
                                    id="representative_name" 
                                    name="representative_name" 
                                    x-model="formData.representative_name"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Nombre completo del representante"
                                >
                            </div>

                            <!-- Cédula -->
                            <div>
                                <label for="representative_dni" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Cédula
                                </label>
                                <input 
                                    type="text" 
                                    id="representative_dni" 
                                    name="representative_dni" 
                                    x-model="formData.representative_dni"
                                    maxlength="13"
                                    pattern="\d{3}-\d{7}-\d{1}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="000-0000000-0"
                                >
                            </div>

                            <!-- Teléfono Móvil -->
                            <div>
                                <label for="representative_mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Teléfono Móvil
                                </label>
                                <input 
                                    type="tel" 
                                    id="representative_mobile" 
                                    name="representative_mobile" 
                                    x-model="formData.representative_mobile"
                                    maxlength="13"
                                    pattern="\d{4}-\d{3}-\d{4}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="0000-000-0000"
                                >
                            </div>

                            <!-- Correo Electrónico Personal -->
                            <div class="md:col-span-2">
                                <label for="representative_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Correo Electrónico Personal
                                </label>
                                <input 
                                    type="email" 
                                    id="representative_email" 
                                    name="representative_email" 
                                    x-model="formData.representative_email"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="correo@personal.com"
                                >
                            </div>
                        </div>

                        <!-- Botones de Navegación -->
                        <div class="flex justify-between mt-6">
                            <button 
                                type="button" 
                                @click="previousStep()"
                                class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg transition-colors duration-200">
                                Anterior
                            </button>
                            <button 
                                type="button" 
                                @click="nextStep()"
                                class="px-6 py-2 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors duration-200">
                                Siguiente
                            </button>
                        </div>
                    </div>

                    <!-- Paso 3: Datos de Usuario -->
                    <div x-show="currentStep === 3" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Datos de Usuario</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="user_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="user_email" 
                                    name="user_email" 
                                    x-model="formData.user_email"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="correo@empresa.com"
                                >
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Este será tu correo para iniciar sesión</p>
                            </div>

                            <!-- Contraseña -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    x-model="formData.password"
                                    required
                                    minlength="8"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Mínimo 8 caracteres"
                                >
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 uppercase">
                                    Confirmar Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    x-model="formData.password_confirmation"
                                    required
                                    minlength="8"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Confirma tu contraseña"
                                >
                            </div>
                        </div>

                        <!-- Botones de Navegación -->
                        <div class="flex justify-between mt-6">
                            <button 
                                type="button" 
                                @click="previousStep()"
                                class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg transition-colors duration-200">
                                Anterior
                            </button>
                            <button 
                                type="submit" 
                                :disabled="isSubmitting"
                                class="px-6 py-2 bg-primary hover:bg-primary/90 text-white font-bold rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!isSubmitting">Registrar Empresa</span>
                                <span x-show="isSubmitting">Registrando...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Funciones para aplicar máscaras
        function aplicarMascaraCedula(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length <= 3) {
                input.value = value;
            } else if (value.length <= 10) {
                input.value = value.substring(0, 3) + '-' + value.substring(3);
            } else if (value.length <= 11) {
                input.value = value.substring(0, 3) + '-' + value.substring(3, 10) + '-' + value.substring(10);
            } else {
                input.value = value.substring(0, 3) + '-' + value.substring(3, 10) + '-' + value.substring(10, 11);
            }
        }

        function aplicarMascaraTelefono(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length <= 4) {
                input.value = value;
            } else if (value.length <= 7) {
                input.value = value.substring(0, 4) + '-' + value.substring(4);
            } else if (value.length <= 11) {
                input.value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7);
            } else {
                input.value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7, 11);
            }
        }

        function manejarTeclasCedula(event) {
            const key = event.key;
            if (['Backspace', 'Delete', 'Tab', 'Enter', 'ArrowLeft', 'ArrowRight'].includes(key)) {
                return;
            }
            if (!/^\d$/.test(key)) {
                event.preventDefault();
                return;
            }
            const currentValue = event.target.value.replace(/\D/g, '');
            if (currentValue.length >= 11) {
                event.preventDefault();
            }
        }

        function manejarTeclasTelefono(event) {
            const key = event.key;
            if (['Backspace', 'Delete', 'Tab', 'Enter', 'ArrowLeft', 'ArrowRight'].includes(key)) {
                return;
            }
            if (!/^\d$/.test(key)) {
                event.preventDefault();
                return;
            }
            const currentValue = event.target.value.replace(/\D/g, '');
            if (currentValue.length >= 11) {
                event.preventDefault();
            }
        }

        function wizardForm() {
            return {
                currentStep: 1,
                isSubmitting: false,
                municipalities: [],
                formData: {
                    business_name: '',
                    branch: '',
                    rnc: '',
                    industry: '',
                    province_id: '',
                    municipality_id: '',
                    sector: '',
                    landline_phone: '',
                    extension: '',
                    email: '',
                    representative_name: '',
                    representative_dni: '',
                    representative_mobile: '',
                    representative_email: '',
                    user_email: '',
                    password: '',
                    password_confirmation: ''
                },
                
                init() {
                    // Cargar datos guardados si existen
                    const saved = sessionStorage.getItem('companyRegistrationData');
                    if (saved) {
                        this.formData = { ...this.formData, ...JSON.parse(saved) };
                    }
                    
                    // Aplicar máscaras
                    this.$nextTick(() => {
                        this.applyMasks();
                    });
                    
                    // Cargar municipios si hay provincia seleccionada
                    if (this.formData.province_id) {
                        this.loadMunicipalities();
                    }
                },
                
                applyMasks() {
                    // Cédula del representante
                    const dniField = document.getElementById('representative_dni');
                    if (dniField) {
                        dniField.addEventListener('input', function() {
                            aplicarMascaraCedula(this);
                        });
                        dniField.addEventListener('keydown', manejarTeclasCedula);
                        if (dniField.value) {
                            aplicarMascaraCedula(dniField);
                        }
                    }
                    
                    // Teléfonos
                    const landlineField = document.getElementById('landline_phone');
                    if (landlineField) {
                        landlineField.addEventListener('input', function() {
                            aplicarMascaraTelefono(this);
                        });
                        landlineField.addEventListener('keydown', manejarTeclasTelefono);
                        if (landlineField.value) {
                            aplicarMascaraTelefono(landlineField);
                        }
                    }
                    
                    const mobileField = document.getElementById('representative_mobile');
                    if (mobileField) {
                        mobileField.addEventListener('input', function() {
                            aplicarMascaraTelefono(this);
                        });
                        mobileField.addEventListener('keydown', manejarTeclasTelefono);
                        if (mobileField.value) {
                            aplicarMascaraTelefono(mobileField);
                        }
                    }
                },
                
                loadMunicipalities() {
                    if (!this.formData.province_id) {
                        this.municipalities = [];
                        this.formData.municipality_id = '';
                        return;
                    }
                    
                    fetch(`{{ route('public.company-registration.municipalities-by-province') }}?province_id=${this.formData.province_id}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.municipalities = data;
                    })
                    .catch(error => {
                        console.error('Error loading municipalities:', error);
                    });
                },
                
                nextStep() {
                    if (this.validateStep()) {
                        this.saveToSession();
                        this.currentStep++;
                        this.$nextTick(() => {
                            this.applyMasks();
                        });
                    }
                },
                
                previousStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                        this.$nextTick(() => {
                            this.applyMasks();
                        });
                    }
                },
                
                validateStep() {
                    const form = document.querySelector('form');
                    const stepElement = form.querySelector(`[x-show="currentStep === ${this.currentStep}"]`);
                    const inputs = stepElement.querySelectorAll('input[required], select[required]');
                    
                    let isValid = true;
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            isValid = false;
                            input.classList.add('border-red-500');
                        } else {
                            input.classList.remove('border-red-500');
                        }
                    });
                    
                    // Validación especial para paso 3 (contraseñas)
                    if (this.currentStep === 3) {
                        if (this.formData.password !== this.formData.password_confirmation) {
                            alert('Las contraseñas no coinciden.');
                            isValid = false;
                        }
                        if (this.formData.password.length < 8) {
                            alert('La contraseña debe tener al menos 8 caracteres.');
                            isValid = false;
                        }
                    }
                    
                    if (!isValid) {
                        alert('Por favor complete todos los campos requeridos antes de continuar.');
                    }
                    
                    return isValid;
                },
                
                saveToSession() {
                    sessionStorage.setItem('companyRegistrationData', JSON.stringify(this.formData));
                },
                
                submitForm(event) {
                    if (this.validateStep()) {
                        this.isSubmitting = true;
                        sessionStorage.removeItem('companyRegistrationData');
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

