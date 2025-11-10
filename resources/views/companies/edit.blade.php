<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Editar Empresa
            </h2>
            <a href="{{ route('companies.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('companies.update', $company) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Datos de la Empresa -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        
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
                                    value="{{ old('registration_date', $company->registration_date?->format('Y-m-d')) }}"
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
                                    value="{{ old('business_name', $company->business_name) }}"
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
                                    value="{{ old('branch', $company->branch) }}"
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
                                    value="{{ old('rnc', $company->rnc) }}"
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
                                    value="{{ old('industry', $company->industry) }}"
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
                                        <option value="{{ $province->id }}" {{ old('province_id', $company->province_id) == $province->id ? 'selected' : '' }}>
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
                                    value="{{ old('sector', $company->sector) }}"
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
                                    value="{{ old('landline_phone', $company->landline_phone) }}"
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
                                    value="{{ old('extension', $company->extension) }}"
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
                                    value="{{ old('email', $company->email) }}"
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

                        <!-- Grid 2 columnas para datos del representante -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Nombre y Apellidos -->
                            <div>
                                <label for="representative_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Nombre y Apellidos
                                </label>
                                <input 
                                    type="text" 
                                    name="representative_name" 
                                    id="representative_name"
                                    value="{{ old('representative_name', $company->representative_name) }}"
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
                                    value="{{ old('representative_dni', $company->representative_dni) }}"
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
                                    value="{{ old('representative_mobile', $company->representative_mobile) }}"
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
                            <div>
                                <label for="representative_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Correo Electrónico Personal
                                </label>
                                <input 
                                    type="email" 
                                    name="representative_email" 
                                    id="representative_email"
                                    value="{{ old('representative_email', $company->representative_email) }}"
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
                                    Actualizar Empresa
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para cargar municipios
        function loadMunicipalities(provinceId, selectedMunicipalityId = null) {
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
                            if (selectedMunicipalityId && municipality.id == selectedMunicipalityId) {
                                option.selected = true;
                            }
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
        }

        // Cargar municipios al cambiar la provincia
        document.getElementById('province_id').addEventListener('change', function() {
            const provinceId = this.value;
            loadMunicipalities(provinceId);
            
            // Actualizar regional automáticamente
            if (provinceId) {
                const selectedOption = this.options[this.selectedIndex];
                const provinces = @json($provinces);
                const province = provinces.find(p => p.id == provinceId);
                
                if (province && province.regional) {
                    document.getElementById('regional_name').value = province.regional.name;
                    document.getElementById('regional_id').value = province.regional.id;
                } else {
                    document.getElementById('regional_name').value = 'No disponible';
                    document.getElementById('regional_id').value = '';
                }
            } else {
                document.getElementById('regional_name').value = 'Seleccione una provincia';
                document.getElementById('regional_id').value = '';
            }
        });

        // Cargar municipios iniciales al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const provinceId = document.getElementById('province_id').value;
            const selectedMunicipalityId = '{{ old('municipality_id', $company->municipality_id) }}';
            if (provinceId) {
                loadMunicipalities(provinceId, selectedMunicipalityId);
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

