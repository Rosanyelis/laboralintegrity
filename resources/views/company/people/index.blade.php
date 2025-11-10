<x-company-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center ">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                Personal de la Empresa - Consulta
            </h2>
            <a href="{{ route('company.people.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-md transition-colors duration-200 text-sm">
                Agregar Persona
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-data-table 
                        :columns="[
                            ['key' => 'nombre_completo', 'label' => 'NOMBRE', 'filterable' => false],
                            ['key' => 'dni', 'label' => 'CEDULA', 'filterable' => false],
                            ['key' => 'age', 'label' => 'EDAD', 'filterable' => false],
                            ['key' => 'verification_status', 'label' => 'VERIFICADO', 'filterable' => true],
                            ['key' => 'employment_status', 'label' => 'ESTATUS LABORAL', 'filterable' => true],
                            ['key' => 'contract_type_preference', 'label' => 'TIPO DE CONTRATO', 'filterable' => true],
                            ['key' => 'work_scope', 'label' => 'ALCANCE LABORAL', 'filterable' => true]
                        ]"
                        :data="$people->map(function($person) {
                            return [
                                'id' => $person->id,
                                'nombre_completo' => $person->name . ' ' . $person->last_name,
                                'dni' => $person->dni ?? 'N/A',
                                'age' => $person->age ?? 'N/A',
                                'verification_status' => $person->verification_status ?? 'pendiente',
                                'employment_status' => $person->aspiration?->employment_status ?? 'N/A',
                                'contract_type_preference' => $person->aspiration?->contract_type_preference ?? 'N/A',
                                'work_scope' => $person->aspiration?->work_scope ?? 'N/A',
                                'created_at' => $person->created_at->format('d/m/Y')
                            ];
                        })->toArray()"
                        :row-actions="[
                            ['name' => 'view', 'label' => 'Ver', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'callback' => 'viewPerson'],
                            ['name' => 'delete', 'label' => 'Eliminar', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'callback' => 'deletePerson'],
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
                            ],
                            [
                                'column' => 'contract_type_preference',
                                'statuses' => [
                                    'tiempo_completo' => ['label' => 'Tiempo Completo', 'color' => 'blue'],
                                    'medio_tiempo' => ['label' => 'Medio Tiempo', 'color' => 'purple'],
                                    'remoto' => ['label' => 'Remoto', 'color' => 'green'],
                                    'hibrido' => ['label' => 'Híbrido', 'color' => 'indigo']
                                ]
                            ],
                            [
                                'column' => 'work_scope',
                                'statuses' => [
                                    'provincial' => ['label' => 'Provincial', 'color' => 'blue'],
                                    'nacional' => ['label' => 'Nacional', 'color' => 'green']
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
    // Funciones globales para acciones por fila
    window.viewPerson = function(person) {
        window.location.href = `{{ route('company.people.index') }}/${person.id}`;
    };

    window.createIntegrity = function(person) {
        window.location.href = `{{ route('company.work-integrities.create') }}?person_id=${person.id}`;
    };

    window.editPerson = function(person) {
        window.location.href = `{{ route('company.people.index') }}/${person.id}/edit`;
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
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route('company.people.index') }}/${person.id}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        } catch (error) {
            console.log('Eliminación cancelada');
        }
    };
</script>
</x-company-layout>

