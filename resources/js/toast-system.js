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
    const container = initToastContainer();
    if (!container) {
        console.warn('Toast container no encontrado');
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

    // Crear elemento del toast
    const toastElement = document.createElement('div');
    toastElement.className = 'fixed top-4 right-4 z-50 max-w-sm w-full';
    toastElement.innerHTML = `
        <div class="rounded-lg shadow-lg border p-4 ${getToastClasses(toast.type)}">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 ${getIconColor(toast.type)}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${getIconPath(toast.type)}"></path>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    ${toast.title ? `<h3 class="text-sm font-medium ${getTextColor(toast.type)}">${toast.title}</h3>` : ''}
                    ${toast.message ? `<div class="mt-1 text-sm ${getTextColor(toast.type)}">${toast.message}</div>` : ''}
                </div>
                ${toast.dismissible ? `
                    <div class="ml-4 flex-shrink-0">
                        <button onclick="dismissToast('${toast.id}')" class="inline-flex ${getTextColor(toast.type)} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent focus:ring-current rounded-md">
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

    // Agregar animación de entrada
    toastElement.style.opacity = '0';
    toastElement.style.transform = 'translateX(100%)';
    document.body.appendChild(toastElement);

    // Animar entrada
    setTimeout(() => {
        toastElement.style.transition = 'all 0.3s ease-out';
        toastElement.style.opacity = '1';
        toastElement.style.transform = 'translateX(0)';
    }, 10);

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
        toastElement.style.transition = 'all 0.3s ease-in';
        toastElement.style.opacity = '0';
        toastElement.style.transform = 'translateX(100%)';
        setTimeout(() => {
            toastElement.remove();
        }, 300);
    }
}

// Funciones auxiliares para estilos
function getToastClasses(type) {
    const classes = {
        success: 'bg-green-50 dark:bg-green-900 border-green-200 dark:border-green-700',
        error: 'bg-red-50 dark:bg-red-900 border-red-200 dark:border-red-700',
        warning: 'bg-yellow-50 dark:bg-yellow-900 border-yellow-200 dark:border-yellow-700',
        info: 'bg-blue-50 dark:bg-blue-900 border-blue-200 dark:border-blue-700'
    };
    return classes[type] || classes.info;
}

function getTextColor(type) {
    const colors = {
        success: 'text-green-800 dark:text-green-200',
        error: 'text-red-800 dark:text-red-200',
        warning: 'text-yellow-800 dark:text-yellow-200',
        info: 'text-blue-800 dark:text-blue-200'
    };
    return colors[type] || colors.info;
}

function getIconColor(type) {
    const colors = {
        success: 'text-green-400',
        error: 'text-red-400',
        warning: 'text-yellow-400',
        info: 'text-blue-400'
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
    return showToast({
        type: 'success',
        title,
        message,
        ...options
    });
};

window.showError = function(message, title = 'Error', options = {}) {
    return showToast({
        type: 'error',
        title,
        message,
        duration: 0,
        ...options
    });
};

window.showWarning = function(message, title = 'Advertencia', options = {}) {
    return showToast({
        type: 'warning',
        title,
        message,
        ...options
    });
};

window.showInfo = function(message, title = 'Información', options = {}) {
    return showToast({
        type: 'info',
        title,
        message,
        ...options
    });
};

window.dismissToast = dismissToast;

// Sistema de tabs con Alpine.js
document.addEventListener('alpine:init', () => {
    Alpine.data('tabManager', () => ({
        activeTab: 'personal',
        previewImage: null,
        
        init() {
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
});