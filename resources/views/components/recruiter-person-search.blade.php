@props([
    'searchRoute' => route('recruiters.search-people'),
    'label' => 'Buscar Persona',
    'placeholder' => 'Buscar por cédula o nombre...',
    'emptyMessage' => 'No se encontraron personas',
    'required' => false,
    'xModel' => 'formData'
])

<div 
    x-data="{
        search: '',
        people: [],
        loading: false,
        showDropdown: false,
        selectedPerson: null,
        searchTimeout: null,
        
        async searchPeople() {
            if (this.search.length < 1) {
                this.people = [];
                this.showDropdown = false;
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch(`{{ $searchRoute }}?search=${encodeURIComponent(this.search)}`);
                const data = await response.json();
                
                if (data.success) {
                    this.people = data.data;
                    this.showDropdown = this.people.length > 0;
                } else {
                    this.people = [];
                    this.showDropdown = false;
                }
            } catch (error) {
                console.error('Error al buscar personas:', error);
                this.people = [];
                this.showDropdown = false;
            } finally {
                this.loading = false;
            }
        },
        
        onSearchInput() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.searchPeople();
            }, 200);
        },
        
        selectPerson(person) {
            this.selectedPerson = person;
            this.search = person.display;
            this.showDropdown = false;
            
            // Llenar los campos del formulario
            {{ $xModel }}.person_id = person.id;
            {{ $xModel }}.person_dni = person.dni;
            {{ $xModel }}.person_name = person.name;
            {{ $xModel }}.person_last_name = (person.last_name ?? person.name.split(' ').slice(1).join(' ')) || '';
            {{ $xModel }}.person_phone = person.phone || '';
            {{ $xModel }}.person_email = person.email || '';
        },
        
        clearSearch() {
            this.search = '';
            this.people = [];
            this.showDropdown = false;
            this.selectedPerson = null;
            
            // Limpiar los campos del formulario
            {{ $xModel }}.person_id = '';
            {{ $xModel }}.person_dni = '';
            {{ $xModel }}.person_name = '';
            {{ $xModel }}.person_last_name = '';
            {{ $xModel }}.person_phone = '';
            {{ $xModel }}.person_email = '';
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
                @focus="if(search.length >= 1) { searchPeople(); }"
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
        <template x-if="people.length === 0 && !loading">
            <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                {{ $emptyMessage }}
            </div>
        </template>

        <template x-for="person in people" :key="person.id">
            <div
                @click="selectPerson(person)"
                class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors border-b border-gray-200 dark:border-gray-700 last:border-b-0"
            >
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="person.name"></span>
                    <span class="text-xs text-gray-500 dark:text-gray-400" x-text="'Cédula: ' + person.dni"></span>
                </div>
            </div>
        </template>
    </div>
</div>
