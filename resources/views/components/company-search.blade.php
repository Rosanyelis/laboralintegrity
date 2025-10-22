@props([
    'searchRoute' => route('work-integrities.search-companies'),
    'label' => 'Buscar Empresa',
    'placeholder' => 'Buscar por código único, RNC o nombre de empresa...',
    'emptyMessage' => 'No se encontraron empresas',
    'required' => false,
    'xModel' => 'formData'
])

<div 
    x-data="{
        search: '',
        companies: [],
        loading: false,
        showDropdown: false,
        selectedCompany: null,
        searchTimeout: null,
        
        async searchCompanies() {
            if (this.search.length < 2) {
                this.companies = [];
                this.showDropdown = false;
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch(`{{ $searchRoute }}?search=${encodeURIComponent(this.search)}`);
                const data = await response.json();
                
                if (data.success) {
                    this.companies = data.data;
                    this.showDropdown = this.companies.length > 0;
                } else {
                    this.companies = [];
                    this.showDropdown = false;
                }
            } catch (error) {
                console.error('Error al buscar empresas:', error);
                this.companies = [];
                this.showDropdown = false;
            } finally {
                this.loading = false;
            }
        },
        
        onSearchInput() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.searchCompanies();
            }, 300);
        },
        
        selectCompany(company) {
            this.selectedCompany = company;
            this.search = company.display;
            this.showDropdown = false;
            
            // Llenar los campos del formulario
            {{ $xModel }}.company_id = company.id;
            {{ $xModel }}.company_code = company.code;
            {{ $xModel }}.company_name = company.name;
            {{ $xModel }}.company_branch = company.branch;
            {{ $xModel }}.company_phone = company.phone;
            {{ $xModel }}.company_email = company.email;
            {{ $xModel }}.representative_name = company.representative_name;
            {{ $xModel }}.representative_phone = company.representative_phone;
            {{ $xModel }}.representative_email = company.representative_email;
        },
        
        clearSearch() {
            this.search = '';
            this.companies = [];
            this.showDropdown = false;
            this.selectedCompany = null;
            
            // Limpiar los campos del formulario
            {{ $xModel }}.company_id = '';
            {{ $xModel }}.company_code = '';
            {{ $xModel }}.company_name = '';
            {{ $xModel }}.company_branch = '';
            {{ $xModel }}.company_phone = '';
            {{ $xModel }}.company_email = '';
            {{ $xModel }}.representative_name = '';
            {{ $xModel }}.representative_phone = '';
            {{ $xModel }}.representative_email = '';
        }
    }"
    @click.away="showDropdown = false"
    class="relative w-full"
>
    @if($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="flex gap-2">
        <!-- Input de búsqueda -->
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input 
                type="text" 
                x-model="search"
                @input="onSearchInput()"
                @focus="if(search.length >= 2) { searchCompanies(); }"
                :placeholder="placeholder"
                class="w-full pl-10 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                autocomplete="off"
            >
            <!-- Botón limpiar -->
            <button
                x-show="search.length > 0"
                @click="clearSearch()"
                type="button"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
            >
                <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- Indicador de carga -->
            <div
                x-show="loading"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
            >
                <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Dropdown de resultados -->
    <div
        x-show="showDropdown"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg max-h-80 overflow-y-auto"
        style="display: none;"
    >
        <template x-if="companies.length === 0 && !loading">
            <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                {{ $emptyMessage }}
            </div>
        </template>

        <template x-for="company in companies" :key="company.id">
            <div
                @click="selectCompany(company)"
                class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors border-b border-gray-200 dark:border-gray-700 last:border-b-0"
            >
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="company.name"></span>
                    <span class="text-xs text-gray-500 dark:text-gray-400" x-text="'RNC: ' + company.rnc"></span>
                </div>
            </div>
        </template>
    </div>
</div>

