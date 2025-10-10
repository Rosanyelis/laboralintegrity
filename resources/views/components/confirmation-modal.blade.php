@props([
    'id' => 'confirmationModal',
    'title' => 'Confirmación',
    'message' => '¿Está seguro de realizar esta acción?',
    'confirmText' => 'Aceptar',
    'cancelText' => 'Cancelar',
    'confirmClass' => 'bg-primary-600 hover:bg-primary-700 text-white',
    'cancelClass' => 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300',
    'icon' => 'warning' // warning, danger, info, question
])

<!-- Backdrop -->
<div 
    x-data="confirmationModal()"
    x-show="show"
    x-cloak
    @keydown.escape.window="cancel()"
    class="fixed inset-0 z-[99999] overflow-y-auto"
    style="display: none;"
>
    <!-- Overlay -->
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500/75 dark:bg-gray-950/75 transition-opacity"
        @click="cancel()"
    ></div>

    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div 
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg ring-1 ring-gray-950/5 dark:ring-white/10"
        >
            <!-- Header con ícono y título -->
            <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-5">
                <div class="flex items-start gap-4">
                    <!-- Icono -->
                    <div class="flex-shrink-0">
                        <template x-if="currentIcon === 'warning'">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100 dark:bg-orange-500/10">
                                <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                        </template>
                        <template x-if="currentIcon === 'danger'">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                        </template>
                        <template x-if="currentIcon === 'info'">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-500/10">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </div>
                        </template>
                        <template x-if="currentIcon === 'question'">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-500/10">
                                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Título y mensaje -->
                    <div class="flex-1 text-left">
                        <h3 class="text-lg font-semibold leading-6 text-gray-950 dark:text-white" x-text="currentTitle"></h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400" x-text="currentMessage"></p>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button 
                    type="button" 
                    @click="cancel()"
                    :class="currentCancelClass"
                    class="inline-flex w-full justify-center items-center rounded-lg px-4 py-2.5 text-sm font-semibold shadow-sm transition-all duration-150 sm:w-auto focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-400"
                >
                    <span x-text="currentCancelText"></span>
                </button>
                <button 
                    type="button" 
                    @click="confirm()"
                    :class="currentConfirmClass"
                    class="inline-flex w-full justify-center items-center rounded-lg px-4 py-2.5 text-sm font-semibold shadow-sm transition-all duration-150 sm:w-auto focus:outline-none focus:ring-2 focus:ring-offset-2"
                >
                    <span x-text="currentConfirmText"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmationModal() {
    return {
        show: false,
        currentTitle: '{{ $title }}',
        currentMessage: '{{ $message }}',
        currentConfirmText: '{{ $confirmText }}',
        currentCancelText: '{{ $cancelText }}',
        currentConfirmClass: '{{ $confirmClass }}',
        currentCancelClass: '{{ $cancelClass }}',
        currentIcon: '{{ $icon }}',
        resolvePromise: null,
        rejectPromise: null,

        init() {
            // Registrar el modal globalmente para acceso desde cualquier lugar
            window.showConfirmation = (options = {}) => {
                return new Promise((resolve, reject) => {
                    this.currentTitle = options.title || '{{ $title }}';
                    this.currentMessage = options.message || '{{ $message }}';
                    this.currentConfirmText = options.confirmText || '{{ $confirmText }}';
                    this.currentCancelText = options.cancelText || '{{ $cancelText }}';
                    this.currentConfirmClass = options.confirmClass || '{{ $confirmClass }}';
                    this.currentCancelClass = options.cancelClass || '{{ $cancelClass }}';
                    this.currentIcon = options.icon || '{{ $icon }}';
                    this.resolvePromise = resolve;
                    this.rejectPromise = reject;
                    this.show = true;
                    
                    // Prevenir scroll del body
                    document.body.style.overflow = 'hidden';
                });
            };
        },

        confirm() {
            if (this.resolvePromise) {
                this.resolvePromise(true);
            }
            this.close();
        },

        cancel() {
            if (this.rejectPromise) {
                this.rejectPromise(false);
            }
            this.close();
        },

        close() {
            this.show = false;
            document.body.style.overflow = '';
            
            // Limpiar referencias
            setTimeout(() => {
                this.resolvePromise = null;
                this.rejectPromise = null;
            }, 300);
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>

