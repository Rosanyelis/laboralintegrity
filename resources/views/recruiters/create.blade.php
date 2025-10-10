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
                        <input type="hidden" name="company_id" id="company_id">
                        <input type="hidden" name="person_id" id="person_id">

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
                        <div id="company_section">
                            <div class="mb-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Datos de la Empresa</h3>

                                <!-- Buscar por RNC -->
                                <div class="mb-6">
                                    <label for="rnc_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        RNC
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="text" id="rnc_search" 
                                               placeholder="Ej. 123-45678901"
                                               class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                        <button type="button" onclick="searchCompanyByRnc()" 
                                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                            Buscar
                                        </button>
                                    </div>
                                    <p id="rnc_error" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden"></p>
                                    <p id="rnc_success" class="mt-1 text-sm text-green-600 dark:text-green-400 hidden"></p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="business_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            NOMBRE DE EMPRESA
                                        </label>
                                        <input type="text" id="business_name" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>

                                    <div>
                                        <label for="branch" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            SUCURSAL
                                        </label>
                                        <input type="text" id="branch" name="branch" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>

                                    <div>
                                        <label for="company_economic_activity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            RUBRO
                                        </label>
                                        <input type="text" id="company_economic_activity" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>

                                    <div>
                                        <label for="company_province" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            PROVINCIA
                                        </label>
                                        <input type="text" id="company_province" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>

                                    <div>
                                        <label for="company_municipality" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            MUNICIPIO
                                        </label>
                                        <input type="text" id="company_municipality" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>

                                    <div>
                                        <label for="company_sector" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            SECTOR
                                        </label>
                                        <input type="text" id="company_sector" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>

                                    <div>
                                        <label for="company_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            TELÉFONO FIJO
                                        </label>
                                        <input type="text" id="company_phone" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>

                                    <div>
                                        <label for="company_extension" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            EXTENSIÓN
                                        </label>
                                        <input type="text" id="company_extension" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="company_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            CORREO
                                        </label>
                                        <input type="email" id="company_email" 
                                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                               readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datos del Representante Autorizado -->
                        <div class="mb-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Datos Representante Autorizado</h3>

                            <!-- Buscar por Cédula -->
                            <div class="mb-6">
                                <label for="dni_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CÉDULA
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" id="dni_search" 
                                           placeholder="Ej. 001-1234567-8"
                                           maxlength="13"
                                           class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                    <button type="button" onclick="searchPersonByDni()" 
                                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                        Buscar
                                    </button>
                                </div>
                                <p id="dni_error" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden"></p>
                                <p id="dni_success" class="mt-1 text-sm text-green-600 dark:text-green-400 hidden"></p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="person_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        NOMBRE
                                    </label>
                                    <input type="text" id="person_name" 
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                           readonly>
                                </div>

                                <div>
                                    <label for="person_last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        APELLIDO
                                    </label>
                                    <input type="text" id="person_last_name" 
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                           readonly>
                                </div>

                                <div>
                                    <label for="person_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        TELÉFONO
                                    </label>
                                    <input type="text" id="person_phone" 
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white bg-gray-100" 
                                           readonly>
                                </div>

                                <div>
                                    <label for="person_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        CORREO
                                    </label>
                                    <input type="email" id="person_email" 
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle de la sección de empresa
        document.getElementById('apply_company').addEventListener('change', function() {
            const companySection = document.getElementById('company_section');
            const companyIdInput = document.getElementById('company_id');
            
            if (this.checked) {
                companySection.style.display = 'block';
            } else {
                companySection.style.display = 'none';
                companyIdInput.value = '';
                // Limpiar campos de empresa
                clearCompanyFields();
            }
        });

        // Buscar empresa por RNC
        async function searchCompanyByRnc() {
            const rncInput = document.getElementById('rnc_search');
            const rnc = rncInput.value.trim();
            
            if (!rnc) {
                showError('rnc', 'Por favor ingrese un RNC');
                return;
            }

            try {
                const response = await fetch(`{{ route('recruiters.search-by-rnc') }}?rnc=${encodeURIComponent(rnc)}`);
                const data = await response.json();

                                if (response.ok) {
                                    // Llenar campos con los datos de la empresa
                                    document.getElementById('company_id').value = data.id;
                                    document.getElementById('business_name').value = data.business_name || '';
                                    document.getElementById('branch').value = data.branch || '';
                                    document.getElementById('company_economic_activity').value = data.economic_activity || '';
                                    document.getElementById('company_province').value = data.province || '';
                                    document.getElementById('company_municipality').value = data.municipality || '';
                                    document.getElementById('company_sector').value = data.sector || '';
                                    document.getElementById('company_phone').value = data.phone || '';
                                    document.getElementById('company_extension').value = data.extension || '';
                                    document.getElementById('company_email').value = data.email || '';
                                    
                                    showSuccess('rnc', 'Empresa encontrada exitosamente');
                                } else {
                    showError('rnc', data.error || 'No se encontró la empresa');
                    clearCompanyFields();
                }
            } catch (error) {
                showError('rnc', 'Error al buscar la empresa');
                clearCompanyFields();
            }
        }

        // Buscar persona por cédula
        async function searchPersonByDni() {
            const dniInput = document.getElementById('dni_search');
            const dni = dniInput.value.trim();
            
            if (!dni) {
                showError('dni', 'Por favor ingrese una cédula');
                return;
            }

            try {
                const response = await fetch(`{{ route('recruiters.search-by-dni') }}?dni=${encodeURIComponent(dni)}`);
                const data = await response.json();

                if (response.ok) {
                    // Llenar campos con los datos de la persona
                    document.getElementById('person_id').value = data.id;
                    document.getElementById('person_name').value = data.name || '';
                    document.getElementById('person_last_name').value = data.last_name || '';
                    document.getElementById('person_phone').value = data.cell_phone || '';
                    document.getElementById('person_email').value = data.email || '';
                    
                    showSuccess('dni', 'Persona encontrada exitosamente');
                } else {
                    showError('dni', data.error || 'No se encontró la persona');
                    clearPersonFields();
                }
            } catch (error) {
                showError('dni', 'Error al buscar la persona');
                clearPersonFields();
            }
        }

        function clearCompanyFields() {
            document.getElementById('company_id').value = '';
            document.getElementById('business_name').value = '';
            document.getElementById('branch').value = '';
            document.getElementById('company_economic_activity').value = '';
            document.getElementById('company_province').value = '';
            document.getElementById('company_municipality').value = '';
            document.getElementById('company_sector').value = '';
            document.getElementById('company_phone').value = '';
            document.getElementById('company_extension').value = '';
            document.getElementById('company_email').value = '';
        }

        function clearPersonFields() {
            document.getElementById('person_id').value = '';
            document.getElementById('person_name').value = '';
            document.getElementById('person_last_name').value = '';
            document.getElementById('person_phone').value = '';
            document.getElementById('person_email').value = '';
        }

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

        // Función para aplicar máscara de cédula (000-0000000-0)
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

        // Función para manejar teclas en campo de cédula
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

        // Aplicar máscara al campo de búsqueda de cédula
        document.getElementById('dni_search').addEventListener('input', function() {
            aplicarMascaraCedula(this);
        });

        document.getElementById('dni_search').addEventListener('keydown', manejarTeclasCedula);

        // Validar formulario antes de enviar
        document.getElementById('recruiterForm').addEventListener('submit', function(e) {
            const personId = document.getElementById('person_id').value;
            
            if (!personId) {
                e.preventDefault();
                alert('Debe buscar y seleccionar un representante autorizado');
                return false;
            }

            const applyCompany = document.getElementById('apply_company').checked;
            if (applyCompany) {
                const companyId = document.getElementById('company_id').value;
                if (!companyId) {
                    e.preventDefault();
                    alert('Debe buscar y seleccionar una empresa');
                    return false;
                }
            }
        });
    </script>
</x-app-layout>

