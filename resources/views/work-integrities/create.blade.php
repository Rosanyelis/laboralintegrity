<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nueva Integridad Laboral') }}
            </h2>
            <a href="{{ route('work-integrities.index') }}" 
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="workIntegrityForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <form @submit.prevent="submitForm" method="POST" action="{{ route('work-integrities.store') }}">
                @csrf

                <!-- Datos de la Empresa -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos de la Empresa</h3>
                        
                        <!-- Búsqueda y campos de empresa -->
                        <div class="mb-4">
                            <div class="flex gap-2 mb-4">
                                <input 
                                    type="text" 
                                    x-model="companyRnc"
                                    placeholder="Buscar empresas o integraciones..."
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                                <button 
                                    type="button"
                                    @click="searchCompany"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors flex items-center"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Código Empresa -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código Empresa
                                </label>
                                <input 
                                    type="text" 
                                    name="company_code"
                                    x-model="formData.company_code"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                                <input type="hidden" name="company_id" x-model="formData.company_id">
                            </div>
                            
                            <!-- Nombre Empresa -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre Empresa
                                </label>
                                <input 
                                    type="text" 
                                    name="company_name"
                                    x-model="formData.company_name"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Sucursal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Sucursal
                                </label>
                                <input 
                                    type="text" 
                                    name="company_branch"
                                    x-model="formData.company_branch"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Teléfono Empresa -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Teléfono Empresa
                                </label>
                                <input 
                                    type="text" 
                                    name="company_phone"
                                    x-model="formData.company_phone"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Correo Empresa -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Correo Empresa
                                </label>
                                <input 
                                    type="email" 
                                    name="company_email"
                                    x-model="formData.company_email"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                        </div>
                        
                        <!-- Datos del Representante -->
                        <hr class="border-gray-200 dark:border-gray-700 my-6">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos del Representante</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre
                                </label>
                                <input 
                                    type="text" 
                                    name="representative_name"
                                    x-model="formData.representative_name"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Teléfono -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Teléfono
                                </label>
                                <input 
                                    type="text" 
                                    name="representative_phone"
                                    x-model="formData.representative_phone"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Correo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Correo
                                </label>
                                <input 
                                    type="email" 
                                    name="representative_email"
                                    x-model="formData.representative_email"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persona a Integrar -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Persona a Integrar</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Fecha -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    FECHA <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="fecha"
                                    x-model="formData.fecha"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Cédula con búsqueda -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CÉDULA <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <input 
                                        type="text" 
                                        x-model="personDni"
                                        placeholder="000-0000000-0"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    >
                                    <button 
                                        type="button"
                                        @click="searchPerson"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <input type="hidden" name="person_id" x-model="formData.person_id" required>
                                <input type="hidden" name="person_dni" x-model="formData.person_dni">
                            </div>
                            
                            <!-- Nombre y Apellidos -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    NOMBRE Y APELLIDOS <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="person_name"
                                    x-model="formData.person_name"
                                    readonly
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Cédula -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CÉDULA 
                                </label>
                                <input 
                                    type="text" 
                                    name="dni"
                                    x-model="formData.dni"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>

                            <!-- Cédula Anterior -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CÉDULA ANTERIOR
                                </label>
                                <input 
                                    type="text" 
                                    name="previous_dni"
                                    x-model="formData.previous_dni"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Fecha de Nacimiento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    FECHA DE NACIMIENTO
                                </label>
                                <input 
                                    type="date" 
                                    name="birth_date"
                                    x-model="formData.birth_date"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <!-- Lugar de Nacimiento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    LUGAR DE NACIMIENTO
                                </label>
                                <input 
                                    type="text" 
                                    name="birth_place"
                                    x-model="formData.birth_place"
                                    readonly
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            
                        </div>
                    </div>
                </div>

                <!-- Hoja Integral de Vida -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hoja Integral de Vida</h3>
                        
                        <!-- Selector de Código de Referencia -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CÓDIGO DE REFERENCIA
                                </label>
                                <select 
                                    x-model="currentItem.reference_code_id"
                                    @change="updateReferenceCode"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                                    <option value="">Seleccione...</option>
                                    @foreach($referenceCodes as $code)
                                        <option value="{{ $code->id }}" data-code="{{ $code->code }}" data-name="{{ $code->result }}">
                                            {{ $code->code }} - {{ $code->result }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    DETALLE
                                </label>
                                <input 
                                    type="text" 
                                    x-model="currentItem.evaluation_detail"
                                    placeholder="Detalle de evaluación..."
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                            </div>

                            <div class="col-span-2 text-right">
                                <button 
                                    type="button"
                                    @click="addItem"
                                    class="mb-4 px-4 py-2  bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors"
                                >
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Agregar
                                </button>
                            </div>
                        </div>
                        
                        <!-- Tabla de Items -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Código</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Resultado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Detalle</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <template x-if="items.length === 0">
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                                No hay items agregados
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100" x-text="item.reference_code"></td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100" x-text="item.reference_name"></td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100" x-text="item.evaluation_detail || 'N/A'"></td>
                                            <td class="px-6 py-4 text-right">
                                                <button 
                                                    type="button"
                                                    @click="removeItem(index)"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </td>
                                            <!-- Hidden inputs para enviar al servidor -->
                                            <input type="hidden" :name="'items['+index+'][reference_code_id]'" :value="item.reference_code_id">
                                            <input type="hidden" :name="'items['+index+'][reference_code]'" :value="item.reference_code">
                                            <input type="hidden" :name="'items['+index+'][reference_name]'" :value="item.reference_name">
                                            <input type="hidden" :name="'items['+index+'][evaluation_detail]'" :value="item.evaluation_detail">
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('work-integrities.index') }}" 
                            class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                Cancelar
                            </a>
                            <button 
                                type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200"
                            >
                                Guardar Registro
                            </button>
                        </div>
                    </div>
                    
                </div>

                
            </form>
        </div>
    </div>

    <script>
        function workIntegrityForm() {
            return {
                companyRnc: '',
                personDni: '',
                formData: {
                    fecha: '',
                    company_id: '',
                    company_code: '',
                    company_name: '',
                    company_branch: '',
                    company_phone: '',
                    company_email: '',
                    representative_name: '',
                    representative_phone: '',
                    representative_email: '',
                    person_id: '',
                    person_dni: '',
                    person_name: '',
                    dni: '',
                    previous_dni: '',
                    birth_date: '',
                    birth_place: '',
                    province: '',
                    municipality: '',
                },
                currentItem: {
                    reference_code_id: '',
                    reference_code: '',
                    reference_name: '',
                    evaluation_detail: '',
                },
                items: [],
                
                async searchCompany() {
                    if (!this.companyRnc) {
                        alert('Por favor ingrese un RNC');
                        return;
                    }
                    
                    try {
                        const response = await fetch(`{{ route('work-integrities.search-company') }}?rnc=${this.companyRnc}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            this.formData.company_id = data.data.id;
                            this.formData.company_code = data.data.code;
                            this.formData.company_name = data.data.name;
                            this.formData.company_branch = data.data.branch;
                            this.formData.company_phone = data.data.phone;
                            this.formData.company_email = data.data.email;
                            this.formData.representative_name = data.data.representative_name;
                            this.formData.representative_phone = data.data.representative_phone;
                            this.formData.representative_email = data.data.representative_email;
                        } else {
                            alert('No se encontró la empresa');
                        }
                    } catch (error) {
                        alert('Error al buscar la empresa');
                    }
                },
                
                async searchPerson() {
                    if (!this.personDni) {
                        alert('Por favor ingrese una cédula');
                        return;
                    }
                    
                    try {
                        const response = await fetch(`{{ route('work-integrities.search-person') }}?dni=${this.personDni}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            this.formData.person_id = data.data.id;
                            this.formData.person_dni = data.data.dni;
                            this.formData.person_name = data.data.name;
                            this.formData.dni = data.data.dni;
                            this.formData.previous_dni = data.data.previous_dni || '';
                            this.formData.birth_date = data.data.birth_date || '';
                            this.formData.birth_place = data.data.birth_place || '';
                            this.formData.province = data.data.province || '';
                            this.formData.municipality = data.data.municipality || '';
                        } else {
                            alert('No se encontró la persona');
                        }
                    } catch (error) {
                        alert('Error al buscar la persona');
                    }
                },
                
                updateReferenceCode() {
                    if (!this.currentItem.reference_code_id) {
                        return;
                    }
                    
                    // Obtener datos del código de referencia seleccionado
                    const select = event.target;
                    const selectedOption = select.options[select.selectedIndex];
                    this.currentItem.reference_code = selectedOption.getAttribute('data-code');
                    this.currentItem.reference_name = selectedOption.getAttribute('data-name');
                },
                
                addItem() {
                    if (!this.currentItem.reference_code_id) {
                        alert('Debe seleccionar un código de referencia');
                        return;
                    }
                    
                    this.items.push({...this.currentItem});
                    
                    // Limpiar formulario
                    this.currentItem = {
                        reference_code_id: '',
                        reference_code: '',
                        reference_name: '',
                        evaluation_detail: '',
                    };
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                
                submitForm(event) {
                    if (this.items.length === 0) {
                        alert('Debe agregar al menos un item de certificación');
                        event.preventDefault();
                        return;
                    }
                    
                    if (!this.formData.person_id) {
                        alert('Debe buscar y seleccionar una persona');
                        event.preventDefault();
                        return;
                    }
                    
                    // Enviar el formulario
                    event.target.submit();
                }
            }
        }
    </script>
</x-app-layout>

