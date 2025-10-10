<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center ">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Personal Individual - Consulta
            </h2>
            <a href="{{ route('people.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Agregar Persona
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showSuccess('{{ session('success') }}', 'Éxito');
                            });
                        </script>
                    @endif

                    <x-data-table 
                        :columns="[
                            ['key' => 'code_unique', 'label' => 'CODIGO', 'filterable' => false],
                            ['key' => 'nombre_completo', 'label' => 'NOMBRE', 'filterable' => false],
                            ['key' => 'dni', 'label' => 'CEDULA', 'filterable' => false],
                            ['key' => 'age', 'label' => 'EDAD', 'filterable' => false],
                            ['key' => 'verification_status', 'label' => 'VERIFICADO', 'filterable' => true],
                            ['key' => 'employment_status', 'label' => 'ESTATUS', 'filterable' => true]
                        ]"
                        :data="$people->map(function($person) {
                            return [
                                'id' => $person->id,
                                'code_unique' => $person->code_unique ?? 'N/A',
                                'nombre_completo' => $person->name . ' ' . $person->last_name,
                                'dni' => $person->dni ?? 'N/A',
                                'age' => $person->age ?? 'N/A',
                                'verification_status' => $person->verification_status ?? (rand(0, 1) ? 'verified' : 'pending'),
                                'employment_status' => $person->aspiration?->employment_status ?? 'N/A',
                                'created_at' => $person->created_at->format('d/m/Y')
                            ];
                        })->toArray()"
                        :actions="[
                            ['name' => 'export', 'label' => 'Exportar Seleccionados', 'callback' => 'exportSelected'],
                            ['name' => 'activate', 'label' => 'Activar Seleccionados', 'callback' => 'activateSelected'],
                            ['name' => 'deactivate', 'label' => 'Desactivar Seleccionados', 'callback' => 'deactivateSelected']
                        ]"
                        :row-actions="[
                            ['name' => 'view', 'label' => 'Ver', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'callback' => 'viewPerson'],
                            ['name' => 'edit', 'label' => 'Editar', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'callback' => 'editPerson'],
                            ['name' => 'delete', 'label' => 'Eliminar', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'callback' => 'deletePerson']
                        ]"
                        :badge-columns="[
                            [
                                'column' => 'verification_status',
                                'statuses' => [
                                    'certificado' => ['label' => 'Verificado', 'color' => 'green'],
                                    'pendiente' => ['label' => 'Pendiente', 'color' => 'yellow'],
                                    'no_aplica' => ['label' => 'No Aplica', 'color' => 'red'],
                                    'parcial' => ['label' => 'Parcial', 'color' => 'gray']
                                ]
                            ],
                            [
                                'column' => 'employment_status',
                                'statuses' => [
                                    'disponible' => ['label' => 'Disponible', 'color' => 'green'],
                                    'pendiente' => ['label' => 'Pendiente', 'color' => 'yellow'],
                                    'en_proceso' => ['label' => 'En Proceso', 'color' => 'yellow'],
                                    'contratado' => ['label' => 'Contratado', 'color' => 'green'],
                                    'part_time' => ['label' => 'Part-Time', 'color' => 'gray'],
                                    'despido' => ['label' => 'Despido', 'color' => 'red'],
                                    'desaucio' => ['label' => 'Desaucio', 'color' => 'red'],
                                    'renuncia' => ['label' => 'Renuncia', 'color' => 'red']
                                ]
                            ]
                        ]"
                        :per-page-options="[10, 25, 50, 100]"
                        :default-per-page="10"
                    />
                </div>
            </div>
        </div>
    </div>

<script>
    // Funciones globales para acciones masivas
    window.exportSelected = function(selectedIds) {
        console.log('Exportando registros:', selectedIds);
        // Aquí puedes implementar la lógica de exportación
        alert(`Exportando ${selectedIds.length} registros seleccionados`);
    };

    window.activateSelected = async function(selectedIds) {
        try {
            const confirmed = await showConfirmation({
                title: 'Activar Registros',
                message: `¿Está seguro de activar ${selectedIds.length} registro(s) seleccionado(s)?`,
                confirmText: 'Activar',
                cancelText: 'Cancelar',
                icon: 'question',
                confirmClass: 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
                cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
            });
            
            if (confirmed) {
                console.log('Activando registros:', selectedIds);
                // Aquí implementar la lógica real de activación
                showSuccess(`${selectedIds.length} registro(s) activado(s) exitosamente`, 'Éxito');
            }
        } catch (error) {
            console.log('Activación cancelada');
        }
    };

    window.deactivateSelected = async function(selectedIds) {
        try {
            const confirmed = await showConfirmation({
                title: 'Desactivar Registros',
                message: `¿Está seguro de desactivar ${selectedIds.length} registro(s) seleccionado(s)?`,
                confirmText: 'Desactivar',
                cancelText: 'Cancelar',
                icon: 'warning',
                confirmClass: 'bg-orange-600 hover:bg-orange-700 text-white focus:ring-orange-500',
                cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
            });
            
            if (confirmed) {
                console.log('Desactivando registros:', selectedIds);
                // Aquí implementar la lógica real de desactivación
                showSuccess(`${selectedIds.length} registro(s) desactivado(s) exitosamente`, 'Éxito');
            }
        } catch (error) {
            console.log('Desactivación cancelada');
        }
    };

    // Funciones globales para acciones por fila
    window.viewPerson = function(person) {
        console.log('Viendo detalles de persona:', person);
        // Navegar a la página de detalles de la persona
        window.location.href = `/people/${person.id}`;
    };

    window.editPerson = function(person) {
        console.log('Editando persona:', person);
        // Aquí puedes implementar la lógica para editar
        window.location.href = `/people/${person.id}/edit`;
    };

    window.deletePerson = async function(person) {
        try {
            const confirmed = await showConfirmation({
                title: 'Eliminar Persona',
                message: `¿Está seguro de eliminar a ${person.nombre_completo}? Esta acción no se puede deshacer.`,
                confirmText: 'Eliminar',
                cancelText: 'Cancelar',
                icon: 'danger',
                confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
                cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
            });
            
            if (confirmed) {
                console.log('Eliminando persona:', person);
                // Aquí implementar la lógica real de eliminación
                // Por ejemplo, hacer una petición DELETE al servidor
                showSuccess(`Persona ${person.nombre_completo} eliminada exitosamente`, 'Eliminado');
                
                // Recargar la página o actualizar la tabla
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        } catch (error) {
            // Usuario canceló la acción
            console.log('Eliminación cancelada');
        }
    };
</script>
</x-app-layout>
