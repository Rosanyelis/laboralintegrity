<x-company-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nueva Integridad Laboral') }}
            </h2>
            <a href="{{ route('company.work-integrities.index') }}" 
               class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="workIntegrityForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <form @submit.prevent="submitForm" method="POST" action="{{ route('company.work-integrities.store') }}">
                @csrf
                
                @if(isset($selectedPerson) && $selectedPerson)
                    <input type="hidden" name="return_to_people" value="1">
                @endif

                <!-- Datos de la Empresa -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos de la Empresa <span class="text-sm text-gray-500 dark:text-gray-400 font-normal">(Opcional)</span></h3>
                        
                        <!-- Búsqueda de empresa con autocompletado -->
                        <div class="mb-4">
                            <div class="flex gap-2">
                                <div class="flex-1">
                                    <x-company-search 
                                        label="Buscar Empresa"
                                        placeholder="Buscar por código único, RNC o nombre de empresa..."
                                        x-model="formData"
                                    />
                                </div>
                                <div class="flex items-end">
                                    <button 
                                        type="button"
                                        @click="showNewCompanyModal = true"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200 flex items-center gap-2"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Nueva Empresa
                                    </button>
                                </div>
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
                            
                            <!-- Búsqueda de persona con autocompletado -->
                            <div>
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <x-person-search 
                                            label="Buscar Persona por Cédula"
                                            placeholder="Buscar por cédula o nombre..."
                                            x-model="formData"
                                            required
                                        />
                                    </div>
                                    <div class="flex items-end">
                                        @if(!$selectedPerson)
                                        <button 
                                            type="button"
                                            @click="showNewPersonModal = true"
                                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200 flex items-center gap-2"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Nueva Persona
                                        </button>
                                        @endif
                                    </div>
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100 uppercase"
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
                                        <option value="{{ $certification->id }}"> {{ $certification->id }} - {{ $certification->name }}</option>
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
                            @can('work-integrities.view-actual-results')
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
                            @else
                            <input 
                                type="hidden" 
                                x-model="currentItem.actual_result"
                            >
                            @endcan
                            
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    RESULTADO
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
                                    class="mb-4 px-4 py-1 text-sm bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors"
                                >
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Agregar
                                </button>
                            </div>
                        </div>
                        
                        <!-- Tabla de Items -->
                        <div class="overflow-x-auto mb-4">
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

                        <!-- Resultado -->
                        <div>
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

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-4 mt-4">
                            <a href="{{ route('company.work-integrities.index') }}" 
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

            <!-- Modal para crear nueva empresa -->
            <div 
                x-show="showNewCompanyModal" 
                class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;"
            >
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showNewCompanyModal = false"></div>
                    
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Registrar Nueva Empresa
                                </h3>
                                <button 
                                    type="button" 
                                    @click="showNewCompanyModal = false"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <form @submit.prevent="createNewCompany">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Nombre de la Empresa -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Nombre de la Empresa <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            x-model="newCompany.business_name"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="Nombre comercial de la empresa"
                                        >
                                    </div>
                                    
                                    <!-- RNC -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            RNC
                                        </label>
                                        <input 
                                            type="text" 
                                            x-model="newCompany.rnc"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="RNC de la empresa"
                                        >
                                    </div>
                                    
                                    <!-- Sucursal -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Sucursal
                                        </label>
                                        <input 
                                            type="text" 
                                            x-model="newCompany.branch"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="Sucursal o sede"
                                        >
                                    </div>
                                    
                                    <!-- Provincia -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Provincia <span class="text-red-500">*</span>
                                        </label>
                                        <select 
                                            x-model="newCompany.province_id"
                                            @change="loadMunicipalities"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                        >
                                            <option value="">Seleccione una provincia...</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <!-- Municipio -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Municipio <span class="text-red-500">*</span>
                                        </label>
                                        <select 
                                            x-model="newCompany.municipality_id"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                        >
                                            <option value="">Seleccione un municipio...</option>
                                            <template x-for="municipality in municipalities" :key="municipality.id">
                                                <option :value="municipality.id" x-text="municipality.name"></option>
                                            </template>
                                        </select>
                                    </div>
                                    
                                    <!-- Teléfono -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Teléfono
                                        </label>
                                        <input 
                                            type="text" 
                                            x-model="newCompany.landline_phone"
                                            @input="formatPhone($event, 'landline_phone')"
                                            maxlength="13"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="0000-000-0000"
                                        >
                                    </div>
                                    
                                    <!-- Email -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email
                                        </label>
                                        <input 
                                            type="email" 
                                            x-model="newCompany.email"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="Correo electrónico"
                                        >
                                    </div>
                                    
                                    <!-- Nombre del Representante -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Nombre del Representante
                                        </label>
                                        <input 
                                            type="text" 
                                            x-model="newCompany.representative_name"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="Nombre completo del representante"
                                        >
                                    </div>
                                    
                                    <!-- Teléfono del Representante -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Teléfono del Representante
                                        </label>
                                        <input 
                                            type="text" 
                                            x-model="newCompany.representative_mobile"
                                            @input="formatPhone($event, 'representative_mobile')"
                                            maxlength="13"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="0000-000-0000"
                                        >
                                    </div>
                                    
                                    <!-- Email del Representante -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email del Representante
                                        </label>
                                        <input 
                                            type="email" 
                                            x-model="newCompany.representative_email"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            placeholder="Correo del representante"
                                        >
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button 
                                        type="button" 
                                        @click="showNewCompanyModal = false"
                                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    >
                                        Cancelar
                                    </button>
                                    <button 
                                        type="submit"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md"
                                    >
                                        Crear Empresa
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para crear nueva persona -->
            <div 
                x-show="showNewPersonModal" 
                class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;"
            >
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showNewPersonModal = false"></div>
                    
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
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
                                            @input="formatDni($event, 'dni')"
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
                                            @input="formatDni($event, 'previous_dni')"
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
            </div>
        </div>

        <!-- Toast Notification Component -->
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
            <!-- Success Icon -->
            <template x-if="toastType === 'success'">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </template>
            
            <!-- Error Icon -->
            <template x-if="toastType === 'error'">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </template>
            
            <!-- Message -->
            <div class="flex-1">
                <p class="text-sm font-medium" x-text="toastMessage"></p>
            </div>
            
            <!-- Close Button -->
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
        function workIntegrityForm() {
            return {
                formData: {
                    fecha: '',
                    resultado: '',
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
                    certification_id: '',
                    certification_name: '',
                    reference_code_id: '',
                    reference_code: '',
                    reference_name: '',
                    actual_result: '',
                    evaluation_detail: '',
                },
                items: [],
                certifications: @json($certifications),
                showNewCompanyModal: false,
                showNewPersonModal: false,
                municipalities: [],
                // Toast notification properties
                showToast: false,
                toastMessage: '',
                toastType: '',
                newCompany: {
                    business_name: '',
                    rnc: '',
                    branch: '',
                    industry: '',
                    province_id: '',
                    municipality_id: '',
                    sector: '',
                    landline_phone: '',
                    extension: '',
                    email: '',
                    representative_name: '',
                    representative_dni: '',
                    representative_mobile: '',
                    representative_email: '',
                },
                newPerson: {
                    name: '',
                    last_name: '',
                    dni: '',
                    previous_dni: '',
                    birth_date: '',
                    birth_place: '',
                    country: '',
                    email: '',
                    cell_phone: '',
                    home_phone: '',
                },
                
                init() {
                    // Si hay una persona preseleccionada, cargar sus datos
                    @if(isset($selectedPerson) && $selectedPerson)
                        this.formData.person_id = '{{ $selectedPerson->id }}';
                        this.formData.person_dni = '{{ $selectedPerson->dni }}';
                        this.formData.person_name = '{{ $selectedPerson->name }} {{ $selectedPerson->last_name }}';
                        this.formData.dni = '{{ $selectedPerson->dni }}';
                        this.formData.previous_dni = '{{ $selectedPerson->previous_dni ?? '' }}';
                        this.formData.birth_date = '{{ $selectedPerson->birth_date ? $selectedPerson->birth_date->format('Y-m-d') : '' }}';
                        this.formData.birth_place = '{{ $selectedPerson->birth_place ?? '' }}';
                        this.formData.province = '{{ $selectedPerson->residenceInformation->province->name ?? '' }}';
                        this.formData.municipality = '{{ $selectedPerson->residenceInformation->municipality->name ?? '' }}';
                    @endif
                },
                
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
                
                async loadMunicipalities() {
                    if (!this.newCompany.province_id) {
                        this.municipalities = [];
                        this.newCompany.municipality_id = '';
                        return;
                    }
                    
                    try {
                        const response = await fetch(`/work-integrities/municipalities/${this.newCompany.province_id}`);
                        const data = await response.json();
                        this.municipalities = data;
                        this.newCompany.municipality_id = '';
                    } catch (error) {
                        console.error('Error al cargar municipios:', error);
                        this.municipalities = [];
                    }
                },
                
                async createNewCompany() {
                    if (!this.newCompany.business_name) {
                        alert('El nombre de la empresa es obligatorio.');
                        return;
                    }
                    
                    if (!this.newCompany.province_id || !this.newCompany.municipality_id) {
                        alert('La provincia y municipio son obligatorios.');
                        return;
                    }
                    
                    try {
                        const response = await fetch('/work-integrities/create-company', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.newCompany)
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Llenar automáticamente los campos del formulario principal
                            this.formData.company_id = data.company.id;
                            this.formData.company_code = data.company.code;
                            this.formData.company_name = data.company.name;
                            this.formData.company_branch = data.company.branch;
                            this.formData.company_phone = data.company.phone;
                            this.formData.company_email = data.company.email;
                            this.formData.representative_name = data.company.representative_name;
                            this.formData.representative_phone = data.company.representative_phone;
                            this.formData.representative_email = data.company.representative_email;
                            
                            // Cerrar el modal y limpiar el formulario
                            this.showNewCompanyModal = false;
                            this.resetNewCompanyForm();
                            
                            this.showToastNotification('Empresa creada correctamente y seleccionada automáticamente.', 'success');
                        } else {
                            this.showToastNotification('Error: ' + data.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error al crear empresa:', error);
                        this.showToastNotification('Error al crear la empresa. Por favor, intente nuevamente.', 'error');
                    }
                },
                
                resetNewCompanyForm() {
                    this.newCompany = {
                        business_name: '',
                        rnc: '',
                        branch: '',
                        industry: '',
                        province_id: '',
                        municipality_id: '',
                        sector: '',
                        landline_phone: '',
                        extension: '',
                        email: '',
                        representative_name: '',
                        representative_dni: '',
                        representative_mobile: '',
                        representative_email: '',
                    };
                    this.municipalities = [];
                },
                
                formatPhone(event, field) {
                    let value = event.target.value.replace(/\D/g, ''); // Remover todos los caracteres no numéricos
                    
                    // Aplicar formato 0000-000-0000
                    if (value.length >= 4) {
                        value = value.substring(0, 4) + '-' + value.substring(4);
                    }
                    if (value.length >= 8) {
                        value = value.substring(0, 8) + '-' + value.substring(8, 12);
                    }
                    
                    // Actualizar el valor en el modelo correspondiente
                    if (field.includes('landline_phone') || field.includes('representative_mobile')) {
                        this.newCompany[field] = value;
                    } else if (field.includes('cell_phone') || field.includes('home_phone')) {
                        this.newPerson[field] = value;
                    }
                    
                    // Actualizar el valor del input
                    event.target.value = value;
                },
                
                formatDni(event, field) {
                    let value = event.target.value.replace(/\D/g, ''); // Remover todos los caracteres no numéricos
                    
                    // Aplicar formato 000-0000000-0 (formato dominicano)
                    if (value.length >= 3) {
                        value = value.substring(0, 3) + '-' + value.substring(3);
                    }
                    if (value.length >= 11) {
                        value = value.substring(0, 11) + '-' + value.substring(11, 12);
                    }
                    
                    // Actualizar el valor en el modelo
                    this.newPerson[field] = value;
                    
                    // Actualizar el valor del input
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
                        
                        // Verificar primero si la cédula ya existe (status 422)
                        if (!response.ok && response.status === 422 && data.existing_person) {
                            // La persona ya existe - mostrar error y limpiar formulario
                            const dni = data.existing_person.dni;
                            this.showToastNotification(`La persona con cédula ${dni} ya se encuentra registrada en el sistema.`, 'error');
                            this.resetNewPersonForm();
                            return;
                        }
                        
                        if (data.success && response.ok) {
                            // Persona creada exitosamente
                            this.formData.person_id = data.person.id;
                            this.formData.person_dni = data.person.dni;
                            this.formData.person_name = data.person.name + ' ' + data.person.last_name;
                            this.formData.dni = data.person.dni;
                            this.formData.previous_dni = data.person.previous_dni || '';
                            this.formData.birth_date = data.person.birth_date;
                            this.formData.birth_place = data.person.birth_place;
                            
                            // Cerrar el modal y limpiar el formulario
                            this.showNewPersonModal = false;
                            this.resetNewPersonForm();
                            
                            this.showToastNotification('Persona creada correctamente y seleccionada automáticamente.', 'success');
                        } else {
                            // Otro tipo de error
                            console.error('Error del servidor:', data);
                            this.showToastNotification('Error: ' + (data.message || 'Error desconocido del servidor'), 'error');
                        }
                    } catch (error) {
                        console.error('Error al crear persona:', error);
                        console.error('Datos enviados:', this.newPerson);
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
                    
                    // Auto-hide after 4 seconds
                    setTimeout(() => {
                        this.showToast = false;
                        this.toastMessage = '';
                        this.toastType = '';
                    }, 4000);
                },
                
                submitForm(event) {
                    if (this.items.length === 0) {
                        this.showToastNotification('Debe agregar al menos un item de certificación', 'error');
                        event.preventDefault();
                        return;
                    }
                    
                    if (!this.formData.person_id) {
                        this.showToastNotification('Debe buscar y seleccionar una persona', 'error');
                        event.preventDefault();
                        return;
                    }
                    
                    // Enviar el formulario
                    event.target.submit();
                }
            }
        }
    </script>
</x-company-layout>

