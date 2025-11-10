<x-company-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Personal Individual - Editar Persona
            </h2>
            <a href="{{ route('company.people.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                Volver a Consulta
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('company.people.update', $person) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información Personal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre *
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $person->name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Apellido *
                                </label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $person->last_name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="dni" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cédula *
                                </label>
                                <input type="text" name="dni" id="dni" value="{{ old('dni', $person->dni) }}" 
                                       placeholder="000-0000000-0" maxlength="13"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('dni')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="previous_dni" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cédula Anterior
                                </label>
                                <input type="text" name="previous_dni" id="previous_dni" value="{{ old('previous_dni', $person->previous_dni) }}" 
                                       placeholder="000-0000000-0" maxlength="13"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('previous_dni')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email *
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $person->email) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cell_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Teléfono Celular
                                </label>
                                <input type="tel" name="cell_phone" id="cell_phone" value="{{ old('cell_phone', $person->cell_phone) }}" 
                                       placeholder="0000-000-0000" maxlength="13"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('cell_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="home_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Teléfono Casa
                                </label>
                                <input type="tel" name="home_phone" id="home_phone" value="{{ old('home_phone', $person->home_phone) }}" 
                                       placeholder="0000-000-0000" maxlength="13"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('home_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Contacto de Emergencia -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre Contacto Emergencia *
                                </label>
                                <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ old('emergency_contact_name', $person->emergency_contact_name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('emergency_contact_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Teléfono Contacto Emergencia *
                                </label>
                                <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone" value="{{ old('emergency_contact_phone', $person->emergency_contact_phone) }}" 
                                       placeholder="0000-000-0000" maxlength="13"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('emergency_contact_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Información Demográfica -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fecha de Nacimiento
                                </label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $person->birth_date?->format('Y-m-d')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Edad
                                </label>
                                <input type="number" name="age" id="age" value="{{ old('age', $person->age) }}" min="0" max="120"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('age')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="marital_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Estado Civil
                                </label>
                                <select name="marital_status" id="marital_status" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="soltero" {{ old('marital_status', $person->marital_status) == 'soltero' ? 'selected' : '' }}>Soltero</option>
                                    <option value="casado" {{ old('marital_status', $person->marital_status) == 'casado' ? 'selected' : '' }}>Casado</option>
                                    <option value="viudo" {{ old('marital_status', $person->marital_status) == 'viudo' ? 'selected' : '' }}>Viudo</option>
                                </select>
                                @error('marital_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Información Laboral -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="position_applied_for" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Posición Solicitada
                                </label>
                                <input type="text" name="position_applied_for" id="position_applied_for" value="{{ old('position_applied_for', $person->position_applied_for) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('position_applied_for')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Empresa
                                </label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $person->company_name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código Empresa
                                </label>
                                <input type="text" name="company_code" id="company_code" value="{{ old('company_code', $person->company_code) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('company_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Estados del Sistema -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="verification_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Estado de Verificación
                                </label>
                                <select name="verification_status" id="verification_status" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="pendiente" {{ old('verification_status', $person->verification_status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="parcial" {{ old('verification_status', $person->verification_status) == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                    <option value="no_aplica" {{ old('verification_status', $person->verification_status) == 'no_aplica' ? 'selected' : '' }}>No Aplica</option>
                                    <option value="certificado" {{ old('verification_status', $person->verification_status) == 'certificado' ? 'selected' : '' }}>Certificado</option>
                                </select>
                                @error('verification_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Datos de Residencia -->
                        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">DATOS DE RESIDENCIA</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Regional (autocompletado) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="regional">REGIONAL</label>
                                    <input class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 focus:outline-none" 
                                           id="regional" name="regional" type="text" value="{{ old('regional', $person->residenceInformation?->province?->regional?->name) }}" readonly />
                                    @error('regional')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Provincia (autocompletado) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="provincia">PROVINCIA</label>
                                    <input class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 focus:outline-none" 
                                           id="provincia" name="provincia" type="text" value="{{ old('provincia', $person->residenceInformation?->province?->name) }}" readonly />
                                    @error('provincia')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Municipio (selector principal activo) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="municipality_id">MUNICIPIO</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                                            id="municipality_id" name="municipality_id">
                                        <option value="">Seleccione...</option>
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
                                                    {{ old('municipality_id', $person->residenceInformation?->municipality_id) == $municipality->id ? 'selected' : '' }}>
                                                {{ $municipality->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('municipality_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Distrito (filtrado dinámicamente) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="district_id">DISTRITO</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                                            id="district_id" name="district_id">
                                        <option value="">Seleccione primero un municipio...</option>
                                        <option value="no_aplica" {{ old('district_id', $person->residenceInformation?->district_id) == 'no_aplica' ? 'selected' : '' }}>No aplica</option>
                                    </select>
                                    @error('district_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Sector -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="sector">SECTOR</label>
                                    <input class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                                           id="sector" name="sector" type="text" value="{{ old('sector', $person->residenceInformation?->sector) }}" />
                                    @error('sector')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Barrio -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="neighborhood">BARRIO</label>
                                    <input class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                                           id="neighborhood" name="neighborhood" type="text" value="{{ old('neighborhood', $person->residenceInformation?->neighborhood) }}" />
                                    @error('neighborhood')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Calle y Número -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="street_and_number">CALLE Y NÚMERO</label>
                                    <input class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                                           id="street_and_number" name="street_and_number" type="text" value="{{ old('street_and_number', $person->residenceInformation?->street_and_number) }}" />
                                    @error('street_and_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Referencia de Llegada -->
                                <div class="lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="arrival_reference">REFERENCIA DE LLEGADA</label>
                                    <input class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                                           id="arrival_reference" name="arrival_reference" type="text" value="{{ old('arrival_reference', $person->residenceInformation?->arrival_reference) }}" />
                                    @error('arrival_reference')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('company.people.index') }}" 
                               class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Persona
                            </button>
                        </div>
                    </form>
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

        // Función para cargar distritos según el municipio seleccionado
        async function cargarDistritos(municipalityId, selectedDistrictId = null) {
            const districtSelect = document.getElementById('district_id');
            
            if (!municipalityId) {
                districtSelect.innerHTML = '<option value="">Seleccione primero un municipio...</option><option value="no_aplica">No aplica</option>';
                return;
            }
            
            try {
                const response = await fetch(`{{ route('company.people.districts-by-municipality') }}?municipality_id=${municipalityId}`);
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
            } catch (error) {
                console.error('Error al cargar distritos:', error);
                // En caso de error, mostrar solo "No aplica"
                districtSelect.innerHTML = '<option value="no_aplica" selected>No aplica</option>';
            }
        }

        // Función para auto-completar regional y provincia cuando se selecciona un municipio
        document.getElementById('municipality_id').addEventListener('change', function() {
            const municipioSeleccionado = this.options[this.selectedIndex];
            const regionalInput = document.getElementById('regional');
            const provinciaInput = document.getElementById('provincia');

            if (municipioSeleccionado.value) {
                // Auto-completar campos readonly
                regionalInput.value = municipioSeleccionado.getAttribute('data-regional') || '';
                provinciaInput.value = municipioSeleccionado.getAttribute('data-provincia') || '';
                
                // Cargar distritos del municipio seleccionado
                cargarDistritos(municipioSeleccionado.value);
            } else {
                // Limpiar campos
                regionalInput.value = '';
                provinciaInput.value = '';
                
                // Limpiar distritos
                const districtSelect = document.getElementById('district_id');
                districtSelect.innerHTML = '<option value="">Seleccione primero un municipio...</option><option value="no_aplica">No aplica</option>';
            }
        });

        // Verificar estado inicial al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Si hay un municipio seleccionado, cargar sus distritos
            const municipalitySelect = document.getElementById('municipality_id');
            const oldDistrictId = '{{ old("district_id", $person->residenceInformation?->district_id) }}';
            
            if (municipalitySelect.value) {
                // Trigger change para cargar regional/provincia
                const selectedOption = municipalitySelect.options[municipalitySelect.selectedIndex];
                document.getElementById('regional').value = selectedOption.getAttribute('data-regional') || '';
                document.getElementById('provincia').value = selectedOption.getAttribute('data-provincia') || '';
                
                // Cargar distritos
                cargarDistritos(municipalitySelect.value, oldDistrictId);
            }

            // Event listeners para campos de cédula
            document.getElementById('dni').addEventListener('input', function() {
                aplicarMascaraCedula(this);
            });
            document.getElementById('dni').addEventListener('keydown', manejarTeclasCedula);

            document.getElementById('previous_dni').addEventListener('input', function() {
                aplicarMascaraCedula(this);
            });
            document.getElementById('previous_dni').addEventListener('keydown', manejarTeclasCedula);

            // Event listeners para campos de teléfono
            document.getElementById('cell_phone').addEventListener('input', function() {
                aplicarMascaraTelefono(this);
            });
            document.getElementById('cell_phone').addEventListener('keydown', manejarTeclasTelefono);

            document.getElementById('home_phone').addEventListener('input', function() {
                aplicarMascaraTelefono(this);
            });
            document.getElementById('home_phone').addEventListener('keydown', manejarTeclasTelefono);

            document.getElementById('emergency_contact_phone').addEventListener('input', function() {
                aplicarMascaraTelefono(this);
            });
            document.getElementById('emergency_contact_phone').addEventListener('keydown', manejarTeclasTelefono);

            // Aplicar máscara inicial a campos si tienen valores
            const dniField = document.getElementById('dni');
            const previousDniField = document.getElementById('previous_dni');
            const cellPhoneField = document.getElementById('cell_phone');
            const homePhoneField = document.getElementById('home_phone');
            const emergencyContactPhoneField = document.getElementById('emergency_contact_phone');
            
            if (dniField.value) {
                aplicarMascaraCedula(dniField);
            }
            
            if (previousDniField.value) {
                aplicarMascaraCedula(previousDniField);
            }
            
            if (cellPhoneField.value) {
                aplicarMascaraTelefono(cellPhoneField);
            }
            
            if (homePhoneField.value) {
                aplicarMascaraTelefono(homePhoneField);
            }
            
            if (emergencyContactPhoneField.value) {
                aplicarMascaraTelefono(emergencyContactPhoneField);
            }
        });
    </script>
</x-company-layout>