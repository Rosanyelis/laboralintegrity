<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                REGISTRO DE PERSONAS
            </h2>
            <a href="{{ route('people.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 md:p-12">
                <form method="POST" action="{{ route('people.store') }}">
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
                                   id="cell_phone" name="cell_phone" type="tel" value="{{ old('cell_phone') }}" placeholder="0000-000-0000" maxlength="12" />
                            @error('cell_phone')
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
                            <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                   id="blood_type" name="blood_type" type="text" value="{{ old('blood_type') }}" />
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

                        
                    </div>

                    <!-- Datos de Residencia -->
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">DATOS DE RESIDENCIA</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Regional -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="regional">REGIONAL</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                       id="regional" name="regional" type="text" value="{{ old('regional') }}" readonly />
                                @error('regional')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Provincia -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="provincia">PROVINCIA</label>
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                       id="provincia" name="provincia" type="text" value="{{ old('provincia') }}" readonly />
                                @error('provincia')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Municipio -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="municipio">MUNICIPIO</label>
                                <!-- Input readonly (por defecto) -->
                                <input class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:text-gray-400 sm:text-sm bg-gray-100 dark:bg-gray-600" 
                                       id="municipio" name="municipio" type="text" value="{{ old('municipio') }}" readonly />
                                
                                <!-- Select (solo visible cuando "No aplica" está seleccionado) -->
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                        id="municipio_select" name="municipality_id" style="display: none;">
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
                                                data-municipio="{{ $municipality->name }}"
                                                {{ old('municipality_id') == $municipality->id ? 'selected' : '' }}>
                                            {{ $municipality->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                @error('municipio')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('municipality_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Distrito -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase" for="district_id">DISTRITO</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary dark:bg-gray-700 dark:text-white sm:text-sm" 
                                        id="district_id" name="district_id">
                                    <option value="">Seleccione...</option>
                                    <option value="no_aplica" {{ old('district_id') == 'no_aplica' ? 'selected' : '' }}>No aplica</option>
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
                                                {{ old('district_id') == $district->id ? 'selected' : '' }}>
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
            } else if (value.length <= 10) {
                input.value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7);
            } else {
                // Limitar a 10 dígitos máximo
                input.value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7, 10);
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
            
            // Si ya tiene 10 dígitos, no permitir más
            const currentValue = input.value.replace(/\D/g, '');
            if (currentValue.length >= 10) {
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

        // Event listener para el campo de fecha de nacimiento
        document.getElementById('birth_date').addEventListener('change', calcularEdad);
        document.getElementById('birth_date').addEventListener('input', calcularEdad);

        // Función para auto-completar campos cuando se selecciona un distrito
        document.getElementById('district_id').addEventListener('change', function() {
            const distritoSeleccionado = this.options[this.selectedIndex];
            const regionalInput = document.getElementById('regional');
            const provinciaInput = document.getElementById('provincia');
            const municipioInput = document.getElementById('municipio');
            const municipioSelect = document.getElementById('municipio_select');

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

        // Función para auto-completar campos cuando se selecciona un municipio
        document.getElementById('municipio_select').addEventListener('change', function() {
            const municipioSeleccionado = this.options[this.selectedIndex];
            const regionalInput = document.getElementById('regional');
            const provinciaInput = document.getElementById('provincia');
            const municipioInput = document.getElementById('municipio');

            if (municipioSeleccionado.value) {
                regionalInput.value = municipioSeleccionado.getAttribute('data-regional') || '';
                provinciaInput.value = municipioSeleccionado.getAttribute('data-provincia') || '';
                municipioInput.value = municipioSeleccionado.getAttribute('data-municipio') || '';
            } else {
                regionalInput.value = '';
                provinciaInput.value = '';
                municipioInput.value = '';
            }
        });

        // Verificar estado inicial si hay valores old()
        document.addEventListener('DOMContentLoaded', function() {
            const districtSelect = document.getElementById('district_id');
            if (districtSelect.value === 'no_aplica') {
                document.getElementById('municipio_select').style.display = 'block';
                document.getElementById('municipio').style.display = 'none';
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
            
            // Aplicar máscara inicial a campo de teléfono si tiene valor
            const cellPhoneField = document.getElementById('cell_phone');
            
            if (cellPhoneField.value) {
                aplicarMascaraTelefono(cellPhoneField);
            }
        });
    </script>
</x-app-layout>