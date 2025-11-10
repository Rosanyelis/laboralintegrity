<x-company-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Depuraciones de la Empresa - Resumen por Persona
            </h2>
            <a href="{{ route('company.work-integrities.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Nuevo Registro
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @php
                        $rowActions = [];
                        
                        $rowActions[] = ['name' => 'view_integrations', 'label' => 'Ver Int. Laboral', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'callback' => 'viewIntegrations'];
                        $rowActions[] = ['name' => 'create', 'label' => 'Nueva Integración', 'icon' => 'M12 4v16m8-8H4', 'callback' => 'createWorkIntegrity'];
                    @endphp
                    
                    <x-data-table 
                        :columns="[
                            ['key' => 'cedula', 'label' => 'CÉDULA'],
                            ['key' => 'persona', 'label' => 'NOMBRE COMPLETO'],
                            ['key' => 'total_integraciones', 'label' => 'TOTAL DE INTEGRACIONES'],
                        ]"
                        :data="$workIntegrities->map(function($item) {
                            return [
                                'id' => $item->person_id,
                                'cedula' => $item->person_dni,
                                'persona' => $item->person_name,
                                'total_integraciones' => $item->total_integraciones,
                            ];
                        })->toArray()"
                        :row-actions="$rowActions"
                        empty-message="No hay registros de integridad laboral."
                    />
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewIntegrations(item) {
            const personId = item.id || item;
            // Modificado para apuntar a la nueva vista independiente
            window.location.href = `{{ route('company.work-integrities.index') }}?person_id=${personId}`;
        }

        function createWorkIntegrity(item) {
            const personId = item.id || item;
            window.location.href = `{{ route('company.work-integrities.create') }}?person_id=${personId}`;
        }
    </script>
</x-company-layout>

