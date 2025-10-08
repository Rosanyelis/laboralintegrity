@props([
    'columns' => [],
    'data' => [],
    'searchable' => true,
    'filterable' => true,
    'selectable' => true,
    'actions' => [],
    'rowActions' => [],
    'badgeColumns' => [],
    'perPageOptions' => [10, 25, 50, 100],
    'defaultPerPage' => 10
])

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg" x-data="dataTable({
    data: @js($data),
    columns: @js($columns),
    searchable: @js($searchable),
    filterable: @js($filterable),
    selectable: @js($selectable),
    actions: @js($actions),
    rowActions: @js($rowActions),
    badgeColumns: @js($badgeColumns),
    perPageOptions: @js($perPageOptions),
    defaultPerPage: @js($defaultPerPage)
})">
    <!-- Header con búsqueda y filtros -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <!-- Acciones masivas -->
            <div class="flex items-center space-x-4" x-show="selectedItems.length > 0">
                <button @click="openActions = !openActions" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                    Abrir acciones
                </button>
                
                <!-- Dropdown de acciones -->
                <div x-show="openActions" @click.away="openActions = false" class="absolute z-10 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="py-1">
                        <template x-for="action in actions" :key="action.name">
                            <button @click="executeAction(action)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span x-text="action.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
                
                <span class="text-sm text-gray-600 dark:text-gray-400" x-text="`${selectedItems.length} registros seleccionados`"></span>
            </div>
            
            <!-- Búsqueda y filtros -->
            <div class="flex items-end space-x-4">
                <!-- Búsqueda -->
                <div x-show="searchable" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        x-model="searchQuery" 
                        @input="filterData()"
                        type="text" 
                        placeholder="Buscar" 
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    >
                </div>
                
                <!-- Filtros -->
                <div x-show="filterable" class="relative">
                    <button @click="filtersOpen = !filtersOpen" class="relative inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filtros
                        <span x-show="activeFiltersCount > 0" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-blue-600 rounded-full" x-text="activeFiltersCount"></span>
                    </button>
                    
                    <!-- Panel de filtros -->
                    <div x-show="filtersOpen" @click.away="filtersOpen = false" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Filtros</h3>
                                <button @click="resetFilters()" class="text-sm text-red-600 hover:text-red-800">Resetear los filtros</button>
                            </div>
                            
                            <template x-for="column in filterableColumns" :key="column.key">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" x-text="column.label"></label>
                                    <div class="flex items-center space-x-2">
                                        <select x-model="filters[column.key]" @change="filterData()" class="flex-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">Todos</option>
                                            <template x-for="option in getFilterOptions(column.key)" :key="option">
                                                <option :value="option" x-text="option"></option>
                                            </template>
                                        </select>
                                        <button @click="clearFilter(column.key)" class="text-sm text-red-600 hover:text-red-800">Borrar</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                
                <!-- Otros controles -->
                <!-- <button class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </button> -->
            </div>
        </div>
    </div>
    
    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <!-- Checkbox de selección múltiple -->
                    <th x-show="selectable" class="px-6 py-3 text-left">
                        <input 
                            type="checkbox" 
                            @change="toggleSelectAll()"
                            :checked="selectedItems.length === filteredData.length && filteredData.length > 0"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        >
                    </th>
                    
                    <!-- Encabezados de columnas -->
                    <template x-for="column in columns" :key="column.key">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span x-text="column.label"></span>
                                <button @click="sortBy(column.key)" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </button>
                            </div>
                        </th>
                    </template>
                    
                    <!-- Columna de acciones -->
                    <th x-show="rowActions.length > 0" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        &nbsp;
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <template x-for="(item, index) in paginatedData" :key="item.id || index">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <!-- Checkbox de fila -->
                        <td x-show="selectable" class="px-6 py-4 whitespace-nowrap">
                            <input 
                                type="checkbox" 
                                :value="item.id || index"
                                @change="toggleItemSelection(item.id || index)"
                                :checked="selectedItems.includes(item.id || index)"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            >
                        </td>
                        
                        <!-- Celdas de datos -->
                        <template x-for="column in columns" :key="column.key">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <template x-if="isBadgeColumn(column.key)">
                                    <span x-html="renderBadge(getColumnValue(item, column.key), column.key)"></span>
                                </template>
                                <template x-if="!isBadgeColumn(column.key)">
                                    <span x-text="getColumnValue(item, column.key)"></span>
                                </template>
                            </td>
                        </template>
                        
                        <!-- Celda de acciones -->
                        <td x-show="rowActions.length > 0" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="relative inline-block text-left" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-full">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown de acciones -->
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <template x-for="action in rowActions" :key="action.name">
                                            <button @click="executeRowAction(action, item)" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <svg x-show="action.icon" class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-bind:d="action.icon"></path>
                                                </svg>
                                                <span x-text="action.label"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <!-- Información de registros -->
            <div class="text-sm text-gray-700 dark:text-gray-300">
                <span x-text="`Se muestran de ${(currentPage - 1) * perPage + 1} a ${Math.min(currentPage * perPage, filteredData.length)} de ${filteredData.length} resultados`"></span>
            </div>
            
            <!-- Controles de paginación -->
            <div class="flex items-center space-x-4">
                <!-- Selector de registros por página -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300"></span>
                    <select x-model="perPage" @change="changePerPage()" class="block w-20 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <template x-for="option in perPageOptions" :key="option">
                            <option :value="option" x-text="option"></option>
                        </template>
                    </select>
                </div>
                
                <!-- Navegación de páginas -->
                <div class="flex items-center space-x-2">
                    <button @click="previousPage()" :disabled="currentPage === 1" class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
                        <
                    </button>
                    
                    <template x-for="page in getPageNumbers()" :key="page">
                        <button @click="goToPage(page)" :class="page === currentPage ? 'bg-indigo-600 text-white' : 'text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600'" class="px-3 py-2 text-sm font-medium border border-gray-300 dark:border-gray-600 rounded-md">
                            <span x-text="page"></span>
                        </button>
                    </template>
                    
                    <button @click="nextPage()" :disabled="currentPage === totalPages" class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
                        >
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function dataTable(config) {
    return {
        // Datos
        data: config.data,
        columns: config.columns,
        searchable: config.searchable,
        filterable: config.filterable,
        selectable: config.selectable,
        actions: config.actions,
        rowActions: config.rowActions,
        badgeColumns: config.badgeColumns,
        perPageOptions: config.perPageOptions,
        
        // Estado
        searchQuery: '',
        filters: {},
        selectedItems: [],
        currentPage: 1,
        perPage: config.defaultPerPage,
        sortColumn: null,
        sortDirection: 'asc',
        
        // UI
        openActions: false,
        filtersOpen: false,
        
        // Computed
        get filteredData() {
            let result = [...this.data];
            
            // Aplicar búsqueda
            if (this.searchQuery) {
                result = result.filter(item => {
                    return this.columns.some(column => {
                        const value = this.getColumnValue(item, column.key);
                        return value.toString().toLowerCase().includes(this.searchQuery.toLowerCase());
                    });
                });
            }
            
            // Aplicar filtros
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) {
                    result = result.filter(item => {
                        const value = this.getColumnValue(item, key);
                        return value.toString() === this.filters[key];
                    });
                }
            });
            
            // Aplicar ordenamiento
            if (this.sortColumn) {
                result.sort((a, b) => {
                    const aVal = this.getColumnValue(a, this.sortColumn);
                    const bVal = this.getColumnValue(b, this.sortColumn);
                    
                    if (aVal < bVal) return this.sortDirection === 'asc' ? -1 : 1;
                    if (aVal > bVal) return this.sortDirection === 'asc' ? 1 : -1;
                    return 0;
                });
            }
            
            return result;
        },
        
        get paginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredData.slice(start, end);
        },
        
        get totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },
        
        get activeFiltersCount() {
            return Object.values(this.filters).filter(value => value).length;
        },
        
        get filterableColumns() {
            return this.columns.filter(column => column.filterable !== false);
        },
        
        // Métodos
        getColumnValue(item, key) {
            return key.split('.').reduce((obj, prop) => obj?.[prop], item) || '';
        },
        
        getFilterOptions(key) {
            const values = this.data.map(item => this.getColumnValue(item, key));
            return [...new Set(values)].filter(value => value);
        },
        
        filterData() {
            this.currentPage = 1;
        },
        
        sortBy(column) {
            if (this.sortColumn === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortColumn = column;
                this.sortDirection = 'asc';
            }
        },
        
        toggleSelectAll() {
            if (this.selectedItems.length === this.filteredData.length) {
                this.selectedItems = [];
            } else {
                this.selectedItems = this.filteredData.map(item => item.id || this.data.indexOf(item));
            }
        },
        
        toggleItemSelection(id) {
            const index = this.selectedItems.indexOf(id);
            if (index > -1) {
                this.selectedItems.splice(index, 1);
            } else {
                this.selectedItems.push(id);
            }
        },
        
        clearFilter(key) {
            this.filters[key] = '';
            this.filterData();
        },
        
        resetFilters() {
            this.filters = {};
            this.searchQuery = '';
            this.filterData();
        },
        
        changePerPage() {
            this.currentPage = 1;
        },
        
        goToPage(page) {
            this.currentPage = page;
        },
        
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        
        getPageNumbers() {
            const pages = [];
            const start = Math.max(1, this.currentPage - 2);
            const end = Math.min(this.totalPages, this.currentPage + 2);
            
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            
            return pages;
        },
        
        executeAction(action) {
            if (action.callback && typeof window[action.callback] === 'function') {
                window[action.callback](this.selectedItems);
            }
            this.openActions = false;
        },
        
        executeRowAction(action, item) {
            if (action.callback && typeof window[action.callback] === 'function') {
                window[action.callback](item);
            }
        },
        
        isBadgeColumn(columnKey) {
            return this.badgeColumns.some(badge => badge.column === columnKey);
        },
        
        renderBadge(value, columnKey) {
            const badgeConfig = this.badgeColumns.find(badge => badge.column === columnKey);
            if (!badgeConfig) return value;
            
            const statusConfig = badgeConfig.statuses[value] || badgeConfig.statuses['default'];
            if (!statusConfig) return value;
            
            const colorClasses = this.getBadgeColorClasses(statusConfig.color);
            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${colorClasses}">${statusConfig.label || value}</span>`;
        },
        
        getBadgeColorClasses(color) {
            const colorMap = {
                'green': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                'blue': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                'yellow': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                'red': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                'purple': 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                'indigo': 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
                'pink': 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
                'gray': 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
            };
            return colorMap[color] || colorMap['gray'];
        }
    }
}
</script>
