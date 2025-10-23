<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar Nuevo Reclutador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('recruiters.store') }}" id="recruiterForm">
                        @csrf

                        <!-- Hidden fields para IDs -->

                        <!-- Fecha de Registro y Código -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="registration_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    FECHA REGISTRO
                                </label>
                                <input type="date" name="registration_date" id="registration_date" 
                                       value="{{ old('registration_date', date('Y-m-d')) }}"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('registration_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Checkbox: Aplica Empresa -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="apply_company" 
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" 
                                       checked>
                                <label for="apply_company" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    ¿Aplica registro de empresa?
                                </label>
                            </div>
                        </div>

                        <!-- Sección de Empresa (se oculta si no aplica) -->
                        <div id="company_section" x-data="{
                            formData: {
                                company_id: '',
                                company_code: '',
                                company_name: '',
                                company_branch: '',
                                company_industry: '',
                                company_phone: '',
                                company_email: '',
                                company_province: '',
                                company_municipality: '',
                                company_sector: '',
                                company_extension: '',
                                representative_name: '',
                                representative_phone: '',
                                representative_email: ''
                            }
                        }">
                            <div class="mb-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Datos de la Empresa</h3>

                                <!-- Búsqueda de empresa con autocompletado -->
                                <div class="mb-6">
                                    <x-company-search 
                                        :searchRoute="route('recruiters.search-companies')"
                                        label="Buscar Empresa"
                                        placeholder="Buscar por código único, RNC o nombre de empresa..."
                                        x-model="formData"
                                    />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Columna izquierda -->
                                    
                                        <div>
                                            <label for="business_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                NOMBRE DE EMPRESA
                                            </label>
                                            <input type="text" 
                                                   x-model="formData.company_name"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>

                                        <div>
                                            <label for="branch" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                SUCURSAL
                                            </label>
                                            <input type="text" 
                                                   x-model="formData.company_branch"
                                                   name="branch" 
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>

                                        <div>
                                            <label for="company_industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                RUBRO
                                            </label>
                                            <input type="text" 
                                                   x-model="formData.company_industry"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>

                                        <div>
                                            <label for="company_province" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                PROVINCIA
                                            </label>
                                            <input type="text" 
                                                   x-model="formData.company_province"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>

                                        <div>
                                            <label for="company_municipality" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                MUNICIPIO
                                            </label>
                                            <input type="text" 
                                                   x-model="formData.company_municipality"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>

                                        <div>
                                            <label for="company_sector" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                SECTOR
                                            </label>
                                            <input type="text" 
                                                   x-model="formData.company_sector"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>


                                        <div>
                                            <label for="company_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                TELÉFONO FIJO
                                            </label>
                                            <input type="text" 
                                                   x-model="formData.company_phone"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>

                                        <div>
                                            <label for="company_extension" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                EXTENSIÓN
                                            </label>
                                            <input type="text" 
                                                   x-model="formData.company_extension"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="company_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                CORREO
                                            </label>
                                            <input type="email" 
                                                   x-model="formData.company_email"
                                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                                   readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <!-- Campo hidden para company_id -->
                                <input type="hidden" name="company_id" x-model="formData.company_id">
                            </div>
                        

                            <!-- Datos del Representante Autorizado -->
                            <div class="mb-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg" x-data="{
                                personData: {
                                    person_id: '',
                                    person_dni: '',
                                    person_name: '',
                                    person_last_name: '',
                                    person_phone: '',
                                    person_email: ''
                                }
                            }">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Datos Representante Autorizado</h3>

                                <!-- Búsqueda de persona con autocompletado -->
                                <div class="mb-6">
                                    <x-recruiter-person-search 
                                        :searchRoute="route('recruiters.search-people')"
                                        label="Buscar Persona por Cédula"
                                        placeholder="Buscar por cédula o nombre..."
                                        x-model="personData"
                                        required
                                    />
                                    <input type="hidden" name="person_id" x-model="personData.person_id">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="person_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            NOMBRE
                                        </label>
                                        <input type="text" 
                                            x-model="personData.person_name"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                            readonly>
                                    </div>

                                    <div>
                                        <label for="person_last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            APELLIDO
                                        </label>
                                        <input type="text" 
                                            x-model="personData.person_last_name"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                            readonly>
                                    </div>

                                    <div>
                                        <label for="person_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            TELÉFONO
                                        </label>
                                        <input type="text" 
                                            x-model="personData.person_phone"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                            readonly>
                                    </div>

                                    <div>
                                        <label for="person_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            CORREO
                                        </label>
                                        <input type="email" 
                                            x-model="personData.person_email"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('recruiters.index') }}" 
                                class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
                                    Cancelar
                                </a>
                                <button type="submit" 
                                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                    Registrar Reclutador
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle de la sección de empresa
        document.getElementById('apply_company').addEventListener('change', function() {
            const companySection = document.getElementById('company_section');
            
            if (this.checked) {
                companySection.style.display = 'block';
            } else {
                companySection.style.display = 'none';
                // Limpiar campos de empresa usando Alpine.js
                const alpineData = Alpine.$data(companySection);
                if (alpineData && alpineData.formData) {
                    alpineData.formData.company_id = '';
                    alpineData.formData.company_code = '';
                    alpineData.formData.company_name = '';
                    alpineData.formData.company_branch = '';
                    alpineData.formData.company_industry = '';
                    alpineData.formData.company_phone = '';
                    alpineData.formData.company_email = '';
                    alpineData.formData.company_province = '';
                    alpineData.formData.company_municipality = '';
                    alpineData.formData.company_sector = '';
                    alpineData.formData.company_extension = '';
                    alpineData.formData.representative_name = '';
                    alpineData.formData.representative_phone = '';
                    alpineData.formData.representative_email = '';
                }
            }
        });


        function showError(field, message) {
            const errorElement = document.getElementById(`${field}_error`);
            const successElement = document.getElementById(`${field}_success`);
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
            successElement.classList.add('hidden');
        }

        function showSuccess(field, message) {
            const errorElement = document.getElementById(`${field}_error`);
            const successElement = document.getElementById(`${field}_success`);
            successElement.textContent = message;
            successElement.classList.remove('hidden');
            errorElement.classList.add('hidden');
        }


        // Validar formulario antes de enviar
        document.getElementById('recruiterForm').addEventListener('submit', function(e) {
            // Validar que se haya seleccionado una persona
            const personSection = document.querySelector('[x-data*="personData"]');
            const alpineData = Alpine.$data(personSection);
            const personId = alpineData && alpineData.personData ? alpineData.personData.person_id : '';
            
            if (!personId) {
                e.preventDefault();
                alert('Debe buscar y seleccionar un representante autorizado');
                return false;
            }

            const applyCompany = document.getElementById('apply_company').checked;
            if (applyCompany) {
                const companySection = document.getElementById('company_section');
                const alpineData = Alpine.$data(companySection);
                const companyId = alpineData && alpineData.formData ? alpineData.formData.company_id : '';
                
                if (!companyId) {
                    e.preventDefault();
                    alert('Debe buscar y seleccionar una empresa');
                    return false;
                }
            }
        });
    </script>
</x-app-layout>

