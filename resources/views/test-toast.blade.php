<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Prueba del Sistema de Toast') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Prueba de Notificaciones Toast</h3>
                    
                    <div class="space-y-4">
                        <button 
                            onclick="showSuccess('Esta es una notificación de éxito', 'Éxito')" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Mostrar Toast de Éxito
                        </button>

                        <button 
                            onclick="showError('Esta es una notificación de error', 'Error')" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Mostrar Toast de Error
                        </button>

                        <button 
                            onclick="showWarning('Esta es una notificación de advertencia', 'Advertencia')" 
                            class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                            Mostrar Toast de Advertencia
                        </button>

                        <button 
                            onclick="showInfo('Esta es una notificación informativa', 'Información')" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Mostrar Toast de Información
                        </button>
                    </div>

                    <div class="mt-8">
                        <h4 class="font-semibold mb-2">Instrucciones:</h4>
                        <ol class="list-decimal list-inside space-y-2 text-sm">
                            <li>Abre la consola del navegador (F12)</li>
                            <li>Haz clic en cualquiera de los botones</li>
                            <li>Verifica los mensajes de debug en la consola</li>
                            <li>Los toasts deben aparecer en la esquina superior derecha</li>
                        </ol>
                    </div>

                    <div class="mt-8 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                        <h4 class="font-semibold mb-2">Debug Info:</h4>
                        <p class="text-sm">Verifica en la consola:</p>
                        <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                            <li>[Toast System] Sistema de toast cargado correctamente</li>
                            <li>ToastManager inicializado</li>
                            <li>Alpine.js está funcionando correctamente</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

