<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Reclutadores
            </h2>
            <a href="{{ route('recruiters.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Nuevo Reclutador
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-data-table 
                        :columns="[
                            ['key' => 'code_unique', 'label' => 'Código'],
                            ['key' => 'company_name', 'label' => 'Empresa'],
                            ['key' => 'person_name', 'label' => 'Representante'],
                            ['key' => 'dni', 'label' => 'Cédula'],
                            ['key' => 'phone', 'label' => 'Teléfono'],
                            ['key' => 'province', 'label' => 'Provincia'],
                            ['key' => 'municipality', 'label' => 'Municipio'],
                        ]"
                        :data="$recruiters->map(function($recruiter) {
                            return [
                                'id' => $recruiter->id,
                                'code_unique' => $recruiter->code_unique,
                                'company_name' => $recruiter->company ? $recruiter->company->business_name : 'No aplica',
                                'person_name' => $recruiter->person->name . ' ' . $recruiter->person->last_name,
                                'dni' => $recruiter->person->dni,
                                'phone' => $recruiter->person->cell_phone ?? 'N/A',
                                'province' => $recruiter->person->residenceInformation->municipality->province->name ?? 'N/A',
                                'municipality' => $recruiter->person->residenceInformation->municipality->name ?? 'N/A',
                            ];
                        })"
                        :actions="[
                            ['name' => 'export', 'label' => 'Exportar a PDF', 'callback' => 'exportSelected'],
                        ]"
                        :searchable="true"
                        :filterable="false"
                        search-placeholder="Buscar reclutador por nombre o correo electrónico"
                        :row-actions="[
                            ['name' => 'view', 'label' => 'Ver', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'callback' => 'viewRecruiter'],
                            ['name' => 'edit', 'label' => 'Editar', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'callback' => 'editRecruiter'],
                            ['name' => 'delete', 'label' => 'Eliminar', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'callback' => 'deleteRecruiter']
                        ]"
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
            form.action = '{{ route('recruiters.export-pdf') }}';
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

        // Funciones globales para acciones por fila
        window.viewRecruiter = function(recruiter) {
            window.location.href = `/recruiters/${recruiter.id}`;
        };

        window.editRecruiter = function(recruiter) {
            window.location.href = `/recruiters/${recruiter.id}/edit`;
        };

        window.deleteRecruiter = async function(recruiter) {
            const confirmed = await window.confirmAction({
                title: '¿Eliminar reclutador?',
                message: '¿Estás seguro de que deseas eliminar este reclutador? Esta acción no se puede deshacer.',
                confirmText: 'Sí, eliminar',
                cancelText: 'Cancelar',
                type: 'danger'
            });

            if (confirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/recruiters/${recruiter.id}`;
                
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
        };
    </script>
</x-app-layout>

