<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Nuevo Usuario') }}
            </h2>
            <a href="{{ route('config.users.index') }}" 
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="userCreateForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    @if($availablePeople->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No hay personas disponibles</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Todas las personas ya tienen usuarios asignados o no hay personas registradas.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('people.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Agregar Persona
                                </a>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('config.users.store') }}" method="POST">
                            @csrf
                            
                            <!-- Seleccionar Persona -->
                            <div class="mb-6 col-span-2">
                                <div class="flex gap-2 items-end">
                                    <div class="flex-1">
                                        <x-select-search
                                            name="person_id"
                                            id="person_id"
                                            label="Persona"
                                            placeholder="Seleccione una persona"
                                            searchPlaceholder="Buscar por nombre o cédula..."
                                            emptyMessage="No hay personas disponibles"
                                            :options="$availablePeople->map(function($person) {
                                                return [
                                                    'value' => $person->id,
                                                    'text' => $person->name . ' ' . $person->last_name . ' - ' . $person->dni
                                                ];
                                            })->toArray()"
                                            :selected="old('person_id')"
                                            :required="true"
                                            :error="$errors->first('person_id')"
                                        />
                                    </div>
                                    <button 
                                        type="button"
                                        @click="showNewPersonModal = true"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200 flex items-center gap-2 h-[42px]"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Nueva Persona
                                    </button>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Solo se muestran personas que no tienen usuario asignado.
                                </p>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="usuario@ejemplo.com"
                                >
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Rol -->
                            <div class="mb-6">
                                <x-select-search
                                    name="role_id"
                                    id="role_id"
                                    label="Rol"
                                    placeholder="Seleccione un rol"
                                    searchPlaceholder="Buscar rol..."
                                    emptyMessage="No hay roles disponibles"
                                    :options="$roles->map(function($role) {
                                        return [
                                            'value' => $role->id,
                                            'text' => $role->name
                                        ];
                                    })->toArray()"
                                    :selected="old('role_id')"
                                    :required="true"
                                    :error="$errors->first('role_id')"
                                />
                            </div>

                            <!-- Separador -->
                            <hr class="border-gray-200 dark:border-gray-700 my-6">

                            <!-- Contraseña -->
                            <div class="mb-6">
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="••••••••"
                                >
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
                                    Confirmar Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="••••••••"
                                >
                            </div>

                            <!-- Botones de Acción -->
                            <div class="flex justify-end space-x-4 mt-6">
                                <a href="{{ route('config.users.index') }}" 
                                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancelar
                                </a>
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Crear Usuario
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal para Nueva Persona -->
        <div 
            x-show="showNewPersonModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
            style="display: none;"
            @click.self="showNewPersonModal = false"
        >
            <div class="relative top-20 mx-auto p-5 border max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Registrar Nueva Persona
                        </h3>
                        <button 
                            type="button" 
                            @click="showNewPersonModal = false"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form @submit.prevent="createNewPerson">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nombres -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombres <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    x-model="newPerson.name"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Nombres de la persona"
                                >
                            </div>
                            
                            <!-- Apellidos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Apellidos <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    x-model="newPerson.last_name"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Apellidos de la persona"
                                >
                            </div>
                            
                            <!-- Cédula -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cédula <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    x-model="newPerson.dni"
                                    @input="formatDni($event)"
                                    maxlength="13"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="000-0000000-0"
                                >
                            </div>
                            
                            <!-- Cédula Anterior -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cédula Anterior
                                </label>
                                <input 
                                    type="text" 
                                    x-model="newPerson.previous_dni"
                                    @input="formatPreviousDni($event)"
                                    maxlength="13"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="000-0000000-0"
                                >
                            </div>
                            
                            <!-- Fecha de Nacimiento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fecha de Nacimiento <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    x-model="newPerson.birth_date"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Lugar de Nacimiento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Lugar de Nacimiento <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    x-model="newPerson.birth_place"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Lugar de nacimiento"
                                >
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button 
                                type="button" 
                                @click="showNewPersonModal = false"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md"
                            >
                                Crear Persona
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div 
            x-show="showToast"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-full"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-full"
            class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg text-white z-50 max-w-sm"
            :class="{
                'bg-green-500': toastType === 'success',
                'bg-red-500': toastType === 'error'
            }"
            style="display: none;"
        >
            <div class="flex items-center">
                <template x-if="toastType === 'success'">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </template>
                
                <template x-if="toastType === 'error'">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </template>
                
                <div class="flex-1">
                    <p class="text-sm font-medium" x-text="toastMessage"></p>
                </div>
                
                <button 
                    @click="showToast = false; toastMessage = ''; toastType = ''"
                    class="ml-3 flex-shrink-0 text-white hover:text-gray-200 focus:outline-none"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function userCreateForm() {
            return {
                showNewPersonModal: false,
                showToast: false,
                toastMessage: '',
                toastType: '',
                newPerson: {
                    name: '',
                    last_name: '',
                    dni: '',
                    previous_dni: '',
                    birth_date: '',
                    birth_place: ''
                },
                
                formatDni(event) {
                    let value = event.target.value.replace(/\D/g, '');
                    
                    if (value.length >= 3) {
                        value = value.substring(0, 3) + '-' + value.substring(3);
                    }
                    if (value.length >= 11) {
                        value = value.substring(0, 11) + '-' + value.substring(11, 12);
                    }
                    
                    this.newPerson.dni = value;
                    event.target.value = value;
                },
                
                formatPreviousDni(event) {
                    let value = event.target.value.replace(/\D/g, '');
                    
                    if (value.length >= 3) {
                        value = value.substring(0, 3) + '-' + value.substring(3);
                    }
                    if (value.length >= 11) {
                        value = value.substring(0, 11) + '-' + value.substring(11, 12);
                    }
                    
                    this.newPerson.previous_dni = value;
                    event.target.value = value;
                },
                
                async createNewPerson() {
                    if (!this.newPerson.name || !this.newPerson.last_name || !this.newPerson.dni) {
                        this.showToastNotification('Los campos Nombres, Apellidos y Cédula son obligatorios.', 'error');
                        return;
                    }
                    
                    if (!this.newPerson.birth_date || !this.newPerson.birth_place) {
                        this.showToastNotification('Los campos Fecha de Nacimiento y Lugar de Nacimiento son obligatorios.', 'error');
                        return;
                    }
                    
                    try {
                        const response = await fetch('/work-integrities/create-person', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.newPerson)
                        });
                        
                        const data = await response.json();
                        
                        // Si la cédula ya existe
                        if (!response.ok && response.status === 422 && data.existing_person) {
                            const dni = data.existing_person.dni;
                            this.showToastNotification(`La persona con cédula ${dni} ya existe. Por favor, búsquela en el selector.`, 'error');
                            this.resetNewPersonForm();
                            return;
                        }
                        
                        if (data.success && response.ok) {
                            // Persona creada exitosamente
                            this.showToastNotification('Persona creada correctamente. Seleccionándola...', 'success');
                            
                            // Cerrar modal y limpiar formulario
                            this.showNewPersonModal = false;
                            this.resetNewPersonForm();
                            
                            // Recargar página para actualizar el selector con la nueva persona
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            this.showToastNotification('Error: ' + (data.message || 'Error desconocido del servidor'), 'error');
                        }
                    } catch (error) {
                        console.error('Error al crear persona:', error);
                        this.showToastNotification('Error al crear la persona. Por favor, intente nuevamente.', 'error');
                    }
                },
                
                resetNewPersonForm() {
                    this.newPerson = {
                        name: '',
                        last_name: '',
                        dni: '',
                        previous_dni: '',
                        birth_date: '',
                        birth_place: ''
                    };
                },
                
                showToastNotification(message, type = 'success') {
                    this.toastMessage = message;
                    this.toastType = type;
                    this.showToast = true;
                    
                    setTimeout(() => {
                        this.showToast = false;
                        this.toastMessage = '';
                        this.toastType = '';
                    }, 4000);
                }
            }
        }
    </script>
</x-app-layout>

