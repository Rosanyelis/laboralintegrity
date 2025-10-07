@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Tabla de Ejemplo</h1>
                
                <x-data-table 
                    :columns="[
                        ['key' => 'aseguradora', 'label' => 'Aseguradora', 'filterable' => true],
                        ['key' => 'tipo_endoso', 'label' => 'Tipo de Endoso', 'filterable' => true],
                        ['key' => 'costo', 'label' => 'Costo', 'filterable' => false]
                    ]"
                    :data="[
                        ['id' => 1, 'aseguradora' => 'BEST DOCTORS MEXICO', 'tipo_endoso' => 'Maternidad', 'costo' => '$ 6,900.00'],
                        ['id' => 2, 'aseguradora' => 'BEST DOCTORS USA', 'tipo_endoso' => 'Maternidad', 'costo' => '$ 300.00'],
                        ['id' => 3, 'aseguradora' => 'BEST DOCTORS USA', 'tipo_endoso' => 'Transplantes de Órganos', 'costo' => '$ 400.00'],
                        ['id' => 4, 'aseguradora' => 'VUMI', 'tipo_endoso' => 'Maternidad', 'costo' => '$ 420.00'],
                        ['id' => 5, 'aseguradora' => 'BEST DOCTORS MEXICO', 'tipo_endoso' => 'Cirugía', 'costo' => '$ 1,200.00'],
                        ['id' => 6, 'aseguradora' => 'VUMI', 'tipo_endoso' => 'Transplantes de Órganos', 'costo' => '$ 800.00'],
                        ['id' => 7, 'aseguradora' => 'BEST DOCTORS USA', 'tipo_endoso' => 'Cirugía', 'costo' => '$ 950.00'],
                        ['id' => 8, 'aseguradora' => 'BEST DOCTORS MEXICO', 'tipo_endoso' => 'Maternidad', 'costo' => '$ 5,500.00']
                    ]"
                    :actions="[
                        ['name' => 'export', 'label' => 'Exportar Seleccionados', 'callback' => 'exportSelected'],
                        ['name' => 'delete', 'label' => 'Eliminar Seleccionados', 'callback' => 'deleteSelected']
                    ]"
                    :per-page-options="[5, 10, 25, 50]"
                    :default-per-page="5"
                />
            </div>
        </div>
    </div>
</div>

<script>
function exportSelected(selectedIds) {
    console.log('Exportando registros:', selectedIds);
    alert(`Exportando ${selectedIds.length} registros seleccionados`);
}

function deleteSelected(selectedIds) {
    if (confirm(`¿Está seguro de eliminar ${selectedIds.length} registros?`)) {
        console.log('Eliminando registros:', selectedIds);
        alert(`${selectedIds.length} registros eliminados`);
    }
}
</script>
@endsection
