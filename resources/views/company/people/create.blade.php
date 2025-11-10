<x-company-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                REGISTRO DE PERSONAS DE LA EMPRESA
            </h2>
            <a href="{{ route('company.people.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 md:p-12">
                <form method="POST" action="{{ route('company.people.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="name">NOMBRE</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="name" name="name" type="text" value="{{ old('name') }}" required />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="last_name">APELLIDOS</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required />
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cédula -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="dni">CÉDULA</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="dni" name="dni" type="text" value="{{ old('dni') }}" placeholder="000-0000000-0" maxlength="13" />
                            @error('dni')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cédula Anterior -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="previous_dni">CÉDULA ANTERIOR</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="previous_dni" name="previous_dni" type="text" value="{{ old('previous_dni') }}" placeholder="000-0000000-0" maxlength="13" />
                            @error('previous_dni')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sexo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="gender">SEXO</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="gender" name="gender">
                                <option value="">Seleccione...</option>
                                <option value="masculino" {{ old('gender') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('gender') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ocupación -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="position_applied_for">OCUPACIÓN</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="position_applied_for" name="position_applied_for" type="text" value="{{ old('position_applied_for') }}" />
                            @error('position_applied_for')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado Civil -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="marital_status">ESTADO CIVIL</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                    id="marital_status" name="marital_status">
                                <option value="">Seleccione...</option>
                                <option value="soltero" {{ old('marital_status') == 'soltero' ? 'selected' : '' }}>Soltero/a</option>
                                <option value="casado" {{ old('marital_status') == 'casado' ? 'selected' : '' }}>Casado/a</option>
                                <option value="viudo" {{ old('marital_status') == 'viudo' ? 'selected' : '' }}>Viudo/a</option>
                            </select>
                            @error('marital_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="birth_date">FECHA DE NACIMIENTO</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="birth_date" name="birth_date" type="date" value="{{ old('birth_date') }}" />
                            @error('birth_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Edad -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="age">EDAD</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                   id="age" name="age" type="number" value="{{ old('age') }}" min="0" max="120" readonly />
                            @error('age')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lugar de Nacimiento -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="birth_place">LUGAR DE NACIMIENTO</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="birth_place" name="birth_place" type="text" value="{{ old('birth_place') }}" />
                            @error('birth_place')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nacionalidad -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="country">NACIONALIDAD</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="country" name="country" type="text" value="{{ old('country') }}" />
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono Móvil -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="cell_phone">TELÉFONO MÓVIL</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="cell_phone" name="cell_phone" type="tel" value="{{ old('cell_phone') }}" placeholder="0000-000-0000" maxlength="13" />
                            @error('cell_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono Fijo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="home_phone">TELÉFONO FIJO</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="home_phone" name="home_phone" type="tel" value="{{ old('home_phone') }}" placeholder="0000-000-0000" maxlength="13" />
                            @error('home_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="email">CORREO ELECTRÓNICO</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="email" name="email" type="email" value="{{ old('email') }}" required />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo de Sangre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="blood_type">TIPO DE SANGRE</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                id="blood_type" name="blood_type">
                                <option value="">Seleccionar...</option>
                                <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            @error('blood_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alérgico a Medicamento -->
                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="medication_allergies">ALÉRGICO A MEDICAMENTO</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="medication_allergies" name="medication_allergies" placeholder="Si no aplica, dejar en blanco" type="text" value="{{ old('medication_allergies') }}" />
                            @error('medication_allergies')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Enfermedad que Padece -->
                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="illnesses">ENFERMEDAD QUE PADECE</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="illnesses" name="illnesses" placeholder="Si no aplica, dejar en blanco" type="text" value="{{ old('illnesses') }}" />
                            @error('illnesses')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nombre Contacto Emergencia -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="emergency_contact_name">NOMBRE CONTACTO EMERGENCIA</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                id="emergency_contact_name" name="emergency_contact_name" type="text" value="{{ old('emergency_contact_name') }}" required />
                            @error('emergency_contact_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono Contacto Emergencia -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="emergency_contact_phone">TELÉFONO CONTACTO EMERGENCIA</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                id="emergency_contact_phone" name="emergency_contact_phone" type="tel" value="{{ old('emergency_contact_phone') }}" placeholder="0000-000-0000" maxlength="13" required />
                            @error('emergency_contact_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Otros Contactos de Emergencia -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="other_emergency_contacts">OTROS CONTACTOS DE EMERGENCIA</label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                id="other_emergency_contacts" name="other_emergency_contacts" placeholder="Información adicional de contactos de emergencia..." value="{{ old('other_emergency_contacts') }}" />
                            @error('other_emergency_contacts')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Datos de Residencia -->
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">DATOS DE RESIDENCIA</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Regional (autocompletado) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="regional">REGIONAL</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                       id="regional" name="regional" type="text" value="{{ old('regional') }}" readonly />
                                @error('regional')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Provincia (autocompletado) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="provincia">PROVINCIA</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                       id="provincia" name="provincia" type="text" value="{{ old('provincia') }}" readonly />
                                @error('provincia')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Municipio (selector principal activo) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="municipality_id">MUNICIPIO *</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                        id="municipality_id" name="municipality_id" required>
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
                                                {{ old('municipality_id') == $municipality->id ? 'selected' : '' }}>
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
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="district_id">DISTRITO</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                        id="district_id" name="district_id">
                                    <option value="">Seleccione primero un municipio...</option>
                                    <option value="no_aplica">No aplica</option>
                                </select>
                                @error('district_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Sector -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="sector">SECTOR</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                       id="sector" name="sector" type="text" value="{{ old('sector') }}" />
                                @error('sector')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Barrio -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="neighborhood">BARRIO</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                       id="neighborhood" name="neighborhood" type="text" value="{{ old('neighborhood') }}" />
                                @error('neighborhood')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Calle y Número -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="street_and_number">CALLE Y NÚMERO</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                       id="street_and_number" name="street_and_number" type="text" value="{{ old('street_and_number') }}" />
                                @error('street_and_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Referencia de Llegada -->
                            <div class="lg:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="arrival_reference">REFERENCIA DE LLEGADA</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                       id="arrival_reference" name="arrival_reference" type="text" value="{{ old('arrival_reference') }}" />
                                @error('arrival_reference')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Registro -->
                    <div class="mt-8 flex justify-end">
                        <button class="w-full md:w-auto inline-flex justify-center py-3 px-8 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors" 
                                type="submit">
                            REGISTRAR PERSONA
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

        // Función para calcular la edad automáticamente
        function calcularEdad() {
            const fechaNacimiento = document.getElementById('birth_date').value;
            const campoEdad = document.getElementById('age');
            
            if (fechaNacimiento) {
                const hoy = new Date();
                const nacimiento = new Date(fechaNacimiento);
                
                // Calcular la diferencia en años
                let edad = hoy.getFullYear() - nacimiento.getFullYear();
                const mesActual = hoy.getMonth();
                const mesNacimiento = nacimiento.getMonth();
                
                // Ajustar si aún no ha cumplido años este año
                if (mesActual < mesNacimiento || (mesActual === mesNacimiento && hoy.getDate() < nacimiento.getDate())) {
                    edad--;
                }
                
                // Validar que la edad sea razonable
                if (edad >= 0 && edad <= 120) {
                    campoEdad.value = edad;
                } else {
                    campoEdad.value = '';
                }
            } else {
                campoEdad.value = '';
            }
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

        // Event listeners para campo de teléfono celular
        document.getElementById('cell_phone').addEventListener('input', function() {
            aplicarMascaraTelefono(this);
        });

        document.getElementById('cell_phone').addEventListener('keydown', manejarTeclasTelefono);

        // Event listeners para campo de teléfono fijo
        document.getElementById('home_phone').addEventListener('input', function() {
            aplicarMascaraTelefono(this);
        });

        document.getElementById('home_phone').addEventListener('keydown', manejarTeclasTelefono);

        // Event listeners para teléfono de contacto de emergencia
        document.getElementById('emergency_contact_phone').addEventListener('input', function() {
            aplicarMascaraTelefono(this);
        });
        document.getElementById('emergency_contact_phone').addEventListener('keydown', manejarTeclasTelefono);

        // Event listener para el campo de fecha de nacimiento
        document.getElementById('birth_date').addEventListener('change', calcularEdad);
        document.getElementById('birth_date').addEventListener('input', calcularEdad);

        // Función para cargar distritos según el municipio seleccionado
        async function cargarDistritos(municipalityId, selectedDistrictId = null) {
            const districtSelect = document.getElementById('district_id');
            
            if (!municipalityId) {
                districtSelect.innerHTML = '<option value="">Seleccione primero un municipio...</option><option value="no_aplica">No aplica</option>';
                return;
            }
            
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

        // Verificar estado inicial si hay valores old()
        document.addEventListener('DOMContentLoaded', function() {
            // Si hay un municipio seleccionado (old value), cargar sus distritos
            const municipalitySelect = document.getElementById('municipality_id');
            const oldDistrictId = '{{ old("district_id") }}';
            
            if (municipalitySelect.value) {
                // Trigger change para cargar regional/provincia
                const selectedOption = municipalitySelect.options[municipalitySelect.selectedIndex];
                document.getElementById('regional').value = selectedOption.getAttribute('data-regional') || '';
                document.getElementById('provincia').value = selectedOption.getAttribute('data-provincia') || '';
                
                // Cargar distritos
                cargarDistritos(municipalitySelect.value, oldDistrictId);
            }
            
            // Calcular edad inicial si ya hay una fecha de nacimiento
            calcularEdad();
            
            // Aplicar máscara inicial a campos de cédula si tienen valores
            const dniField = document.getElementById('dni');
            const previousDniField = document.getElementById('previous_dni');
            
            if (dniField.value) {
                aplicarMascaraCedula(dniField);
            }
            
            if (previousDniField.value) {
                aplicarMascaraCedula(previousDniField);
            }
            
            // Aplicar máscara inicial a campo de teléfono móvil si tiene valor
            const cellPhoneField = document.getElementById('cell_phone');
            
            if (cellPhoneField.value) {
                aplicarMascaraTelefono(cellPhoneField);
            }
            
            // Aplicar máscara inicial a campo de teléfono fijo si tiene valor
            const homePhoneField = document.getElementById('home_phone');
            
            if (homePhoneField.value) {
                aplicarMascaraTelefono(homePhoneField);
            }
            
            // Aplicar máscara inicial a campo de teléfono de contacto de emergencia si tiene valor
            const emergencyContactPhoneField = document.getElementById('emergency_contact_phone');
            
            if (emergencyContactPhoneField.value) {
                aplicarMascaraTelefono(emergencyContactPhoneField);
            }
        });
    </script>
</x-company-layout>