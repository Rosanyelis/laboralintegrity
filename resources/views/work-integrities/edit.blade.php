<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Integridad Laboral') }}
            </h2>
            @if(request('return_to_person'))
                <a href="{{ route('people.show', ['person' => request('return_to_person'), 'activeTab' => 'depuraciones']) }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                    Volver a Persona
                </a>
            @else
                <a href="{{ route('work-integrities.index') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                    Volver al Listado
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12" x-data="workIntegrityForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <form @submit.prevent="submitForm" method="POST" action="{{ route('work-integrities.update', $workIntegrity) }}">
                @csrf
                @method('PUT')
                
                @if(request('return_to_person'))
                    <input type="hidden" name="return_to_person" value="{{ request('return_to_person') }}">
                @endif

                <!-- Datos de la Empresa -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos de la Empresa <span class="text-sm text-gray-500 dark:text-gray-400 font-normal">(Opcional)</span></h3>
                        
                        <!-- Búsqueda de empresa con autocompletado -->
                        <div class="mb-4">
                            <x-company-search 
                                label="Buscar Empresa"
                                placeholder="Buscar por RNC o nombre de empresa..."
                                x-model="formData"
                            />
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
                            
                            <!-- Búsqueda de persona con autocompletado -->
                            <div class="md:col-span-2">
                                <x-person-search 
                                    label="Buscar Persona por Cédula"
                                    placeholder="Buscar por cédula o nombre..."
                                    x-model="formData"
                                    required
                                />
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
                            <div class="md:col-span-2">
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

                            <!-- Resultado -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    RESULTADO
                                </label>
                                <textarea 
                                    name="resultado"
                                    x-model="formData.resultado"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                    placeholder="Resultado de la evaluación..."
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hoja Integral de Vida -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Hoja Integral de Vida</h3>
                        
                        <!-- Selector de Código de Referencia -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    TIPO DE DEPURACIÓN
                                </label>
                                <select 
                                    x-model="currentItem.certification_id"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                                    <option value="">Seleccione...</option>
                                    @foreach($certifications as $certification)
                                        <option value="{{ $certification->id }}">{{ $certification->name }}</option>
                                    @endforeach
                                </select>
                            </div>

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
                                        <option value="{{ $code->id }}" data-code="{{ $code->code }}" data-result="{{ $code->result }}" data-actual-result="{{ $code->actual_result }}">
                                            {{ $code->code }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    RESULTADO REAL
                                </label>
                                <input 
                                    type="text" 
                                    x-model="currentItem.actual_result"
                                    placeholder="Resultado real..."
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    DESCRIPCIÓN
                                </label>
                                <input 
                                    type="text" 
                                    x-model="currentItem.evaluation_detail"
                                    placeholder="Descripción..."
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                            </div>

                            <div class="col-span-4 text-right">
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
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tipo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Código</th>
                                        @can('work-integrities.view-actual-results')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Resultado Real</th>
                                        @endcan
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Descripción</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <template x-if="items.length === 0">
                                        <tr>
                                            <td colspan="{{ auth()->user()->can('work-integrities.view-actual-results') ? '5' : '4' }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                                No hay items agregados
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100" x-text="item.certification_name || 'N/A'"></td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100" x-text="item.reference_code"></td>
                                            @can('work-integrities.view-actual-results')
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100" x-text="item.actual_result"></td>
                                            @endcan
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100" x-text="item.reference_name"></td>
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
                                            <input type="hidden" :name="'items['+index+'][certification_id]'" :value="item.certification_id">
                                            <input type="hidden" :name="'items['+index+'][reference_code_id]'" :value="item.reference_code_id">
                                            <input type="hidden" :name="'items['+index+'][reference_code]'" :value="item.reference_code">
                                            <input type="hidden" :name="'items['+index+'][reference_name]'" :value="item.reference_name">
                                            <input type="hidden" :name="'items['+index+'][actual_result]'" :value="item.actual_result">
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
                                Actualizar Registro
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
                formData: {
                    fecha: '{{ $workIntegrity->fecha->format('Y-m-d') }}',
                    resultado: '{{ $workIntegrity->resultado }}',
                    company_id: '{{ $workIntegrity->company_id }}',
                    company_code: '{{ $workIntegrity->company_code }}',
                    company_name: '{{ $workIntegrity->company_name }}',
                    company_branch: '{{ $workIntegrity->company_branch }}',
                    company_phone: '{{ $workIntegrity->company_phone }}',
                    company_email: '{{ $workIntegrity->company_email }}',
                    representative_name: '{{ $workIntegrity->representative_name }}',
                    representative_phone: '{{ $workIntegrity->representative_phone }}',
                    representative_email: '{{ $workIntegrity->representative_email }}',
                    person_id: '{{ $workIntegrity->person_id }}',
                    person_dni: '{{ $workIntegrity->person_dni }}',
                    person_name: '{{ $workIntegrity->person_name }}',
                    dni: '{{ $workIntegrity->person_dni }}',
                    previous_dni: '{{ $workIntegrity->previous_dni }}',
                    birth_date: '{{ $workIntegrity->birth_date ? $workIntegrity->birth_date->format('Y-m-d') : '' }}',
                    birth_place: '{{ $workIntegrity->birth_place }}',
                    province: '{{ $workIntegrity->province }}',
                    municipality: '{{ $workIntegrity->municipality }}',
                },
                currentItem: {
                    certification_id: '',
                    certification_name: '',
                    reference_code_id: '',
                    reference_code: '',
                    reference_name: '',
                    actual_result: '',
                    evaluation_detail: '',
                },
                items: @json($items),
                certifications: @json($certifications),
                
                updateReferenceCode() {
                    if (!this.currentItem.reference_code_id) {
                        return;
                    }
                    
                    // Obtener datos del código de referencia seleccionado
                    const select = event.target;
                    const selectedOption = select.options[select.selectedIndex];
                    this.currentItem.reference_code = selectedOption.getAttribute('data-code');
                    this.currentItem.reference_name = selectedOption.getAttribute('data-result');
                    this.currentItem.actual_result = selectedOption.getAttribute('data-actual-result');
                    // Llenar automáticamente ambos campos
                    this.currentItem.evaluation_detail = selectedOption.getAttribute('data-result');
                },
                
                addItem() {
                    if (!this.currentItem.reference_code_id) {
                        alert('Debe seleccionar un código de referencia');
                        return;
                    }
                    
                    // Obtener el nombre del tipo de depuración si está seleccionado
                    if (this.currentItem.certification_id) {
                        const certification = this.certifications.find(c => c.id == this.currentItem.certification_id);
                        this.currentItem.certification_name = certification ? certification.name : '';
                    }
                    
                    this.items.push({...this.currentItem});
                    
                    // Limpiar formulario
                    this.currentItem = {
                        certification_id: '',
                        certification_name: '',
                        reference_code_id: '',
                        reference_code: '',
                        reference_name: '',
                        actual_result: '',
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

