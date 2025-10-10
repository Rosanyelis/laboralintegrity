// Sistema global de notificaciones Toast - Versión simplificada
let toastContainer = null;

// Función para inicializar el contenedor de toasts
function initToastContainer() {
    if (!toastContainer) {
        toastContainer = document.querySelector('[x-data*="toastManager"]');
    }
    return toastContainer;
}

// Función para mostrar un toast
function showToast(options) {
    console.log('[Toast] showToast iniciado con opciones:', options);
    const container = initToastContainer();
    console.log('[Toast] Container encontrado:', container);
    
    if (!container) {
        console.error('[Toast] Toast container NO encontrado. Verifica que <x-toast-container> esté en el layout.');
        console.log('[Toast] Buscando elemento con selector: [x-data*="toastManager"]');
        console.log('[Toast] Elementos x-data encontrados:', document.querySelectorAll('[x-data]'));
        return;
    }

    const toast = {
        id: Date.now() + Math.random(),
        type: options.type || 'info',
        title: options.title || '',
        message: options.message || '',
        duration: options.duration || 5000,
        dismissible: options.dismissible !== false,
        position: options.position || 'top-right'
    };
    
    console.log('[Toast] Toast creado:', toast);

    // Calcular la posición vertical basada en toasts existentes
    const existingToasts = document.querySelectorAll('[data-toast-id]');
    let topPosition = 16; // 1rem = 16px (top-4 en Tailwind)
    
    existingToasts.forEach(existingToast => {
        topPosition += existingToast.offsetHeight + 16; // altura del toast + gap
    });
    
    console.log('[Toast] Posición calculada:', topPosition, 'Toasts existentes:', existingToasts.length);

    // Crear elemento del toast
    const toastElement = document.createElement('div');
    toastElement.style.cssText = `
        position: fixed;
        right: 16px;
        top: ${topPosition}px;
        z-index: 9999;
        max-width: 400px;
        min-width: 300px;
        width: auto;
        opacity: 0;
        transform: translateX(100%);
        pointer-events: auto;
    `;
    toastElement.setAttribute('data-toast-id', toast.id);
    toastElement.innerHTML = `
        <div class="rounded-lg shadow-2xl border p-4 bg-white dark:bg-green-500 ${getBorderColor(toast.type)}">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 ${getIconColor(toast.type)}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${getIconPath(toast.type)}"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    ${toast.title ? `<h3 class="text-sm font-semibold ${getTextColor(toast.type)} mb-1">${toast.title}</h3>` : ''}
                    ${toast.message ? `<p class="text-sm ${getTextColor(toast.type)}">${toast.message}</p>` : ''}
                </div>
                ${toast.dismissible ? `
                    <div class="flex-shrink-0">
                        <button onclick="dismissToast('${toast.id}')" class="inline-flex ${getTextColor(toast.type)} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md p-1 transition-opacity">
                            <span class="sr-only">Cerrar</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                ` : ''}
            </div>
        </div>
    `;

    // Agregar al body
    document.body.appendChild(toastElement);
    console.log('[Toast] Elemento agregado al DOM:', toastElement);

    // Animar entrada con requestAnimationFrame para mejor rendimiento
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            toastElement.style.transition = 'all 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
            toastElement.style.opacity = '1';
            toastElement.style.transform = 'translateX(0)';
            console.log('[Toast] Animación de entrada iniciada');
        });
    });

    // Auto dismiss
    if (toast.duration > 0) {
        setTimeout(() => {
            dismissToast(toast.id);
        }, toast.duration);
    }

    return toast.id;
}

// Función para cerrar un toast
function dismissToast(toastId) {
    const toastElement = document.querySelector(`[data-toast-id="${toastId}"]`);
    if (toastElement) {
        toastElement.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 1, 1)';
        toastElement.style.opacity = '0';
        toastElement.style.transform = 'translateX(120%)';
        setTimeout(() => {
            toastElement.remove();
            console.log('[Toast] Toast eliminado:', toastId);
        }, 300);
    }
}

// Funciones auxiliares para estilos
function getBorderColor(type) {
    const colors = {
        success: 'border-green-500 border-l-4',
        error: 'border-red-400 border-l-4',
        warning: 'border-yellow-400 border-l-4',
        info: 'border-blue-400 border-l-4'
    };
    return colors[type] || colors.info;
}

function getTextColor(type) {
    const colors = {
        success: 'text-green-600 dark:text-green-400',
        error: 'text-red-700 dark:text-red-300',
        warning: 'text-yellow-700 dark:text-yellow-300',
        info: 'text-blue-700 dark:text-blue-300'
    };
    return colors[type] || colors.info;
}

function getIconColor(type) {
    const colors = {
        success: 'text-green-600',
        error: 'text-red-500',
        warning: 'text-yellow-500',
        info: 'text-blue-500'
    };
    return colors[type] || colors.info;
}

function getIconPath(type) {
    const paths = {
        success: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        error: 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
        info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    };
    return paths[type] || paths.info;
}

// Funciones globales para facilitar el uso
window.showToast = showToast;
window.showSuccess = function(message, title = 'Éxito', options = {}) {
    console.log('[Toast] showSuccess llamado:', message, title);
    return showToast({
        type: 'success',
        title,
        message,
        ...options
    });
};

window.showError = function(message, title = 'Error', options = {}) {
    console.log('[Toast] showError llamado:', message, title);
    return showToast({
        type: 'error',
        title,
        message,
        duration: 0,
        ...options
    });
};

window.showWarning = function(message, title = 'Advertencia', options = {}) {
    console.log('[Toast] showWarning llamado:', message, title);
    return showToast({
        type: 'warning',
        title,
        message,
        ...options
    });
};

window.showInfo = function(message, title = 'Información', options = {}) {
    console.log('[Toast] showInfo llamado:', message, title);
    return showToast({
        type: 'info',
        title,
        message,
        ...options
    });
};

window.dismissToast = dismissToast;

// Log de confirmación de carga
console.log('[Toast System] Sistema de toast cargado correctamente. Funciones disponibles:', {
    showToast: typeof window.showToast,
    showSuccess: typeof window.showSuccess,
    showError: typeof window.showError,
    showWarning: typeof window.showWarning,
    showInfo: typeof window.showInfo
});

// Sistema de tabs con Alpine.js
// Registrar componentes de Alpine cuando esté disponible
if (window.Alpine) {
    registerAlpineComponents();
} else {
    document.addEventListener('alpine:init', registerAlpineComponents);
}

function registerAlpineComponents() {
    if (!window.Alpine) return;
    
    window.Alpine.data('tabManager', () => ({
        activeTab: 'personal',
        previewImage: null,
        
        init() {
            // Leer el tab activo desde el data-attribute si existe
            const savedTab = this.$el.getAttribute('data-active-tab');
            if (savedTab) {
                this.activeTab = savedTab;
            }
            console.log('TabManager inicializado, tab activo:', this.activeTab);
            // Verificar que Alpine.js esté funcionando
            this.$nextTick(() => {
                console.log('Alpine.js está funcionando correctamente');
            });
        },
        
        setActiveTab(tab) {
            console.log('Cambiando tab de', this.activeTab, 'a', tab);
            this.activeTab = tab;
            // Forzar actualización
            this.$nextTick(() => {
                console.log('Tab actualizado a:', this.activeTab);
            });
        },
        
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        resetImage() {
            this.previewImage = null;
            const fileInput = document.getElementById('profile_photo');
            if (fileInput) {
                fileInput.value = '';
            }
        }
    }));

    // Toast Manager para Alpine.js
    window.Alpine.data('toastManager', () => ({
        init() {
            console.log('ToastManager inicializado');
        }
    }));
}