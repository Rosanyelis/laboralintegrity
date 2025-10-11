<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Gestión de Empresas
            </h2>
            <a href="{{ route('companies.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Nueva Empresa
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-data-table 
                        :columns="[
                            ['key' => 'code_unique', 'label' => 'CÓDIGO', 'filterable' => true],
                            ['key' => 'business_name', 'label' => 'NOMBRE EMPRESA', 'filterable' => true],
                            ['key' => 'rnc', 'label' => 'RNC', 'filterable' => false],
                            ['key' => 'province', 'label' => 'PROVINCIA', 'filterable' => false],
                            ['key' => 'municipality', 'label' => 'MUNICIPIO', 'filterable' => false],
                            ['key' => 'representative_name', 'label' => 'REPRESENTANTE', 'filterable' => false]
                        ]"
                        :data="$companies->map(function($company) {
                            return [
                                'id' => $company->id,
                                'code_unique' => $company->code_unique ?? 'N/A',
                                'business_name' => $company->business_name ?? 'N/A',
                                'rnc' => $company->rnc ?? 'N/A',
                                'province' => $company->province?->name ?? 'N/A',
                                'municipality' => $company->municipality?->name ?? 'N/A',
                                'representative_name' => $company->representative_name ?? 'N/A',
                            ];
                        })->toArray()"
                        :actions="[
                            ['name' => 'export', 'label' => 'Exportar a PDF', 'callback' => 'exportSelected'],
                        ]"
                        :row-actions="[
                            ['name' => 'view', 'label' => 'Ver', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'callback' => 'viewCompany'],
                            ['name' => 'edit', 'label' => 'Editar', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'callback' => 'editCompany'],
                            ['name' => 'delete', 'label' => 'Eliminar', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'callback' => 'deleteCompany']
                        ]"
                        :pagination="$companies"
                        per-page="10"
                        search-placeholder="Buscar empresas..."
                    />
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para exportar seleccionados
        window.exportSelected = function(selectedIds) {
            if (selectedIds.length === 0) {
                alert('Por favor, seleccione al menos un registro para exportar');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('companies.export-pdf') }}';
            form.target = '_blank'; // Abrir en nueva pestaña
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        };

        function viewCompany(item) {
            const id = item.id || item;
            window.location.href = `{{ url('companies') }}/${id}`;
        }

        function editCompany(item) {
            const id = item.id || item;
            window.location.href = `{{ url('companies') }}/${id}/edit`;
        }

        async function deleteCompany(item) {
            const id = item.id || item;
            const name = item.business_name || 'esta empresa';
            
            try {
                const confirmed = await showConfirmation({
                    title: 'Eliminar Empresa',
                    message: `¿Está seguro de eliminar "${name}"? Esta acción no se puede deshacer.`,
                    confirmText: 'Eliminar',
                    cancelText: 'Cancelar',
                    icon: 'danger',
                    confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
                    cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
                });
                
                if (confirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('companies') }}/${id}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            } catch (error) {
                console.log('Eliminación cancelada');
            }
        }
    </script>
</x-app-layout>

