<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Crear Nueva Empresa
            </h2>
            <a href="{{ route('companies.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('companies.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Datos de la Empresa -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        
                        <!-- Buscador de RNC -->
                        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg">
                            <label for="search_rnc" class="block text-sm font-medium text-blue-800 dark:text-blue-300 mb-2 uppercase">
                                Buscar Empresa por RNC
                            </label>
                            <div class="flex gap-3">
                                <input 
                                    type="text" 
                                    id="search_rnc"
                                    class="flex-1 px-3 py-2 border border-blue-300 dark:border-blue-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Ingrese el RNC para verificar si existe"
                                >
                                <button 
                                    type="button"
                                    id="btn_search_rnc"
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                    <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Buscar
                                </button>
                            </div>
                            
                            <!-- Mensaje de resultado -->
                            <div id="rnc_result" class="mt-3 hidden"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Fecha de Registro -->
                            <div>
                                <label for="registration_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Fecha de Registro <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="registration_date" 
                                    id="registration_date"
                                    value="{{ old('registration_date', date('Y-m-d')) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('registration_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nombre de Empresa -->
                            <div class="md:col-span-3">
                                <label for="business_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Nombre de Empresa <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="business_name" 
                                    id="business_name"
                                    value="{{ old('business_name') }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Nombre de la empresa"
                                >
                                @error('business_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sucursal -->
                            <div>
                                <label for="branch" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Sucursal
                                </label>
                                <input 
                                    type="text" 
                                    name="branch" 
                                    id="branch"
                                    value="{{ old('branch') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Nombre de la sucursal"
                                >
                                @error('branch')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- RNC -->
                            <div>
                                <label for="rnc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    RNC
                                </label>
                                <input 
                                    type="text" 
                                    name="rnc" 
                                    id="rnc"
                                    value="{{ old('rnc') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="RNC de la empresa"
                                >
                                @error('rnc')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Rubro -->
                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Rubro
                                </label>
                                <input 
                                    type="text" 
                                    name="industry" 
                                    id="industry"
                                    value="{{ old('industry') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Rubro o industria"
                                >
                                @error('industry')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        
                            <!-- Provincia -->
                            <div>
                                <label for="province_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Provincia <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="province_id" 
                                    id="province_id"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="">Seleccione una provincia</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Municipio -->
                            <div>
                                <label for="municipality_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Municipio <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="municipality_id" 
                                    id="municipality_id"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="">Seleccione primero una provincia</option>
                                </select>
                                @error('municipality_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sector -->
                            <div >
                                <label for="sector" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Sector
                                </label>
                                <input 
                                    type="text" 
                                    name="sector" 
                                    id="sector"
                                    value="{{ old('sector') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Sector o dirección"
                                >
                                @error('sector')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        
                            <!-- Teléfono Fijo -->
                            <div>
                                <label for="landline_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Teléfono Fijo
                                </label>
                                <input 
                                    type="text" 
                                    name="landline_phone" 
                                    id="landline_phone"
                                    value="{{ old('landline_phone') }}"
                                    maxlength="13"
                                    pattern="\d{4}-\d{3}-\d{4}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: 8095-555-1234"
                                    title="Formato: 0000-000-0000"
                                >
                                @error('landline_phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Extensión -->
                            <div>
                                <label for="extension" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Extensión
                                </label>
                                <input 
                                    type="text" 
                                    name="extension" 
                                    id="extension"
                                    value="{{ old('extension') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Extensión telefónica"
                                >
                                @error('extension')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Correo -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Correo Electrónico
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    value="{{ old('email') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="correo@empresa.com"
                                >
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 ">Datos del Representante Autorizado</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Nombre y Apellidos -->
                            <div class="md:col-span-2">
                                <label for="representative_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Nombre y Apellidos
                                </label>
                                <input 
                                    type="text" 
                                    name="representative_name" 
                                    id="representative_name"
                                    value="{{ old('representative_name') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Nombre completo del representante"
                                >
                                @error('representative_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cédula -->
                            <div>
                                <label for="representative_dni" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Cédula
                                </label>
                                <input 
                                    type="text" 
                                    name="representative_dni" 
                                    id="representative_dni"
                                    value="{{ old('representative_dni') }}"
                                    maxlength="13"
                                    pattern="\d{3}-\d{7}-\d{1}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: 001-1234567-8"
                                    title="Formato: 000-0000000-0"
                                >
                                @error('representative_dni')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono Móvil -->
                            <div>
                                <label for="representative_mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Teléfono Móvil
                                </label>
                                <input 
                                    type="tel" 
                                    name="representative_mobile" 
                                    id="representative_mobile"
                                    value="{{ old('representative_mobile') }}"
                                    maxlength="13"
                                    pattern="\d{4}-\d{3}-\d{4}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: 8095-551-2345"
                                    title="Formato: 0000-000-0000"
                                >
                                @error('representative_mobile')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Correo Electrónico Personal -->
                            <div class="md:col-span-2">
                                <label for="representative_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Correo Electrónico Personal
                                </label>
                                <input 
                                    type="email" 
                                    name="representative_email" 
                                    id="representative_email"
                                    value="{{ old('representative_email') }}"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="correo@personal.com"
                                >
                                @error('representative_email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('companies.index') }}" 
                            class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Crear Empresa
                            </button>
                        </div>
                    </div>
                    
                </div>

                
            </form>
        </div>
    </div>

    <script>
        // Cargar municipios cuando se selecciona una provincia
        document.getElementById('province_id').addEventListener('change', function() {
            const provinceId = this.value;
            const municipalitySelect = document.getElementById('municipality_id');
            
            // Limpiar opciones actuales
            municipalitySelect.innerHTML = '<option value="">Cargando municipios...</option>';
            municipalitySelect.disabled = true;
            
            if (provinceId) {
                fetch(`{{ url('companies/municipalities') }}/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        municipalitySelect.innerHTML = '<option value="">Seleccione un municipio</option>';
                        data.forEach(municipality => {
                            const option = document.createElement('option');
                            option.value = municipality.id;
                            option.textContent = municipality.name;
                            municipalitySelect.appendChild(option);
                        });
                        municipalitySelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error al cargar municipios:', error);
                        municipalitySelect.innerHTML = '<option value="">Error al cargar municipios</option>';
                    });
            } else {
                municipalitySelect.innerHTML = '<option value="">Seleccione primero una provincia</option>';
                municipalitySelect.disabled = false;
            }
        });

        // Buscar empresa por RNC
        const searchRncInput = document.getElementById('search_rnc');
        const btnSearchRnc = document.getElementById('btn_search_rnc');
        const rncResult = document.getElementById('rnc_result');
        const submitButton = document.querySelector('button[type="submit"]');
        let companyExists = false;

        function searchByRnc() {
            const rnc = searchRncInput.value.trim();
            
            if (!rnc) {
                rncResult.innerHTML = `
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/20 border border-yellow-400 dark:border-yellow-600 rounded-md">
                        <p class="text-sm text-yellow-800 dark:text-yellow-300">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Por favor ingrese un RNC para buscar.
                        </p>
                    </div>
                `;
                rncResult.classList.remove('hidden');
                return;
            }

            // Mostrar indicador de carga
            btnSearchRnc.disabled = true;
            btnSearchRnc.innerHTML = `
                <svg class="animate-spin h-5 w-5 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Buscando...
            `;

            fetch(`{{ url('companies/check-rnc') }}/${encodeURIComponent(rnc)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        companyExists = true;
                        rncResult.innerHTML = `
                            <div class="p-4 bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-600 rounded-md">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.732 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-2">
                                            ⚠️ Empresa Ya Registrada
                                        </h4>
                                        <p class="text-sm text-red-700 dark:text-red-400 mb-2">
                                            <strong>Esta empresa ya existe en el sistema:</strong>
                                        </p>
                                        <ul class="text-sm text-red-700 dark:text-red-400 space-y-1 ml-4">
                                            <li>• <strong>Nombre:</strong> ${data.company.business_name}</li>
                                            <li>• <strong>RNC:</strong> ${data.company.rnc}</li>
                                            ${data.company.branch ? `<li>• <strong>Sucursal:</strong> ${data.company.branch}</li>` : ''}
                                        </ul>
                                        <p class="text-sm text-red-800 dark:text-red-300 font-semibold mt-3">
                                            No se puede crear una empresa duplicada con el mismo RNC.
                                        </p>
                                        <a href="{{ url('companies') }}/${data.company.id}" 
                                           class="inline-block mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-md transition-colors">
                                            Ver Empresa Existente
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        rncResult.classList.remove('hidden');
                        
                        // Deshabilitar el botón de crear
                        submitButton.disabled = true;
                        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                        submitButton.title = 'No se puede crear una empresa con RNC duplicado';
                    } else {
                        companyExists = false;
                        rncResult.innerHTML = `
                            <div class="p-3 bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-600 rounded-md">
                                <p class="text-sm text-green-800 dark:text-green-300">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    ✓ RNC disponible. No existe ninguna empresa registrada con este RNC.
                                </p>
                            </div>
                        `;
                        rncResult.classList.remove('hidden');
                        
                        // Habilitar el botón de crear
                        submitButton.disabled = false;
                        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        submitButton.title = '';
                    }
                })
                .catch(error => {
                    console.error('Error al buscar RNC:', error);
                    rncResult.innerHTML = `
                        <div class="p-3 bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-600 rounded-md">
                            <p class="text-sm text-red-800 dark:text-red-300">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Error al verificar el RNC. Por favor, intente nuevamente.
                            </p>
                        </div>
                    `;
                    rncResult.classList.remove('hidden');
                })
                .finally(() => {
                    // Restaurar botón
                    btnSearchRnc.disabled = false;
                    btnSearchRnc.innerHTML = `
                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    `;
                });
        }

        // Evento click en el botón de búsqueda
        btnSearchRnc.addEventListener('click', searchByRnc);

        // Evento Enter en el campo de búsqueda
        searchRncInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchByRnc();
            }
        });

        // Validación adicional antes de enviar el formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            if (companyExists) {
                e.preventDefault();
                showError('No se puede crear una empresa con un RNC que ya existe en el sistema.', 'Error de Validación');
            }
        });

        // Formato automático para cédula del representante (000-0000000-0)
        const cedulaRepInput = document.getElementById('representative_dni');
        if (cedulaRepInput) {
            cedulaRepInput.addEventListener('input', function(e) {
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

        // Formato automático para teléfono fijo de la empresa (0000-000-0000)
        const landlinePhoneInput = document.getElementById('landline_phone');
        if (landlinePhoneInput) {
            landlinePhoneInput.addEventListener('input', function(e) {
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

        // Formato automático para teléfono móvil del representante (0000-000-0000)
        const phoneRepInput = document.getElementById('representative_mobile');
        if (phoneRepInput) {
            phoneRepInput.addEventListener('input', function(e) {
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
    </script>
</x-app-layout>

