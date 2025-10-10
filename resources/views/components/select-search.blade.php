@props([
    'name',
    'id' => $name,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Seleccione una opción',
    'searchPlaceholder' => 'Buscar...',
    'label' => null,
    'required' => false,
    'error' => null,
    'emptyMessage' => 'No se encontraron resultados'
])

<div 
    x-data="{
        open: false,
        search: '',
        selected: '{{ old($name, $selected) }}',
        selectedText: '',
        options: {{ json_encode($options) }},
        
        get filteredOptions() {
            if (this.search === '') {
                return this.options;
            }
            return this.options.filter(option => 
                option.text.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        
        selectOption(value, text) {
            this.selected = value;
            this.selectedText = text;
            this.open = false;
            this.search = '';
            this.$refs.hiddenInput.value = value;
        },
        
        init() {
            if (this.selected) {
                const option = this.options.find(opt => opt.value == this.selected);
                if (option) {
                    this.selectedText = option.text;
                }
            }
        }
    }"
    @click.away="open = false"
    class="relative w-full"
>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <!-- Hidden Input for Form Submission -->
    <input 
        type="hidden" 
        name="{{ $name }}" 
        x-ref="hiddenInput"
        :value="selected"
    >

    <!-- Display Button -->
    <button
        type="button"
        @click="open = !open"
        class="w-full px-3 py-2 text-left border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 flex items-center justify-between"
        :class="{ 'ring-1 ring-indigo-500 border-indigo-500': open }"
    >
        <span x-text="selectedText || '{{ $placeholder }}'" class="block truncate" :class="{ 'text-gray-500 dark:text-gray-400': !selectedText }"></span>
        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'transform rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg max-h-80 overflow-hidden"
        style="display: none;"
    >
        <!-- Search Input -->
        <div class="p-2 border-b border-gray-200 dark:border-gray-700">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    x-model="search"
                    x-ref="searchInput"
                    @click.stop
                    placeholder="{{ $searchPlaceholder }}"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
            </div>
        </div>

        <!-- Options List -->
        <div class="max-h-64 overflow-y-auto">
            <template x-if="filteredOptions.length === 0">
                <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                    {{ $emptyMessage }}
                </div>
            </template>

            <template x-for="option in filteredOptions" :key="option.value">
                <div
                    @click="selectOption(option.value, option.text)"
                    class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    :class="{
                        'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400': selected == option.value,
                        'text-gray-900 dark:text-gray-100': selected != option.value
                    }"
                >
                    <div class="flex items-center justify-between">
                        <span x-text="option.text"></span>
                        <svg x-show="selected == option.value" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </template>
        </div>
    </div>

    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>

