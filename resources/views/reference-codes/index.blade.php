<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Configuraciones - Códigos de Referencias
            </h2>
            <a href="{{ route('config.reference-codes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Agregar Código
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-data-table 
                        :columns="[
                            ['key' => 'code', 'label' => 'CÓDIGO', 'filterable' => true],
                            ['key' => 'result', 'label' => 'RESULTADO', 'filterable' => true],
                            ['key' => 'actual_result', 'label' => 'RESULTADO REAL', 'filterable' => true]
                        ]"
                        :data="$referenceCodes->map(function($referenceCode) {
                            return [
                                'id' => $referenceCode->id,
                                'code' => $referenceCode->code,
                                'result' => $referenceCode->result,
                                'actual_result' => $referenceCode->actual_result ?? 'N/A',
                                'created_at' => $referenceCode->created_at->format('d/m/Y')
                            ];
                        })->toArray()"
                        :row-actions="[
                            ['name' => 'edit', 'label' => 'Editar', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'callback' => 'editCode'],
                            ['name' => 'delete', 'label' => 'Eliminar', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'callback' => 'deleteCode']
                        ]"
                        empty-message="No hay códigos de referencia registrados."
                    />
                </div>
            </div>
        </div>
    </div>

    <script>
        function editCode(item) {
            const id = item.id || item;
            window.location.href = `{{ url('configuraciones/reference-codes') }}/${id}/edit`;
        }

        async function deleteCode(item) {
            const id = item.id || item;
            const code = item.code || 'este código';
            
            try {
                const confirmed = await showConfirmation({
                    title: 'Eliminar Código de Referencia',
                    message: `¿Está seguro de eliminar el código "${code}"? Esta acción no se puede deshacer.`,
                    confirmText: 'Eliminar',
                    cancelText: 'Cancelar',
                    icon: 'danger',
                    confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
                    cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
                });
                
                if (confirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('configuraciones/reference-codes') }}/${id}`;
                    
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

