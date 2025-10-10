# Sistema de Modal de Confirmación

## Descripción

Un componente de modal de confirmación moderno y reutilizable para reemplazar los `confirm()` nativos del navegador. Diseñado con un estilo similar a FilamentPHP, ofrece una experiencia de usuario premium con fondo blanco limpio, animaciones suaves y personalización completa.

## Características

- ✅ Diseño limpio estilo FilamentPHP (fondo blanco)
- ✅ Soporte para modo oscuro
- ✅ Animaciones suaves de entrada/salida
- ✅ Totalmente personalizable (título, mensaje, botones, iconos, colores)
- ✅ Soporte para Promises (async/await)
- ✅ Cierre con tecla ESC
- ✅ Cierre al hacer clic fuera del modal
- ✅ 4 tipos de iconos predefinidos: `warning` (naranja), `danger` (rojo), `info` (azul), `question` (índigo)
- ✅ Responsive y accesible
- ✅ Integración con Alpine.js

## Instalación

El componente ya está instalado y disponible globalmente en toda la aplicación. Se incluye automáticamente en el layout principal (`app.blade.php`).

## Uso Básico

### Ejemplo Simple

```javascript
// Uso básico con async/await
async function eliminarRegistro() {
    try {
        const confirmed = await showConfirmation({
            title: 'Eliminar Registro',
            message: '¿Está seguro de eliminar este registro?'
        });
        
        if (confirmed) {
            // Usuario confirmó la acción
            console.log('Registro eliminado');
        }
    } catch (error) {
        // Usuario canceló la acción
        console.log('Acción cancelada');
    }
}
```

### Ejemplo con Promesa

```javascript
// Uso con promesas
showConfirmation({
    title: 'Guardar Cambios',
    message: '¿Desea guardar los cambios realizados?'
})
.then(() => {
    // Usuario confirmó
    guardarCambios();
})
.catch(() => {
    // Usuario canceló
    console.log('Cambios descartados');
});
```

## Opciones de Personalización

### Todas las opciones disponibles

```javascript
showConfirmation({
    // Título del modal
    title: 'Título del Modal',
    
    // Mensaje principal
    message: 'Mensaje descriptivo de la acción',
    
    // Texto del botón de confirmación
    confirmText: 'Aceptar',
    
    // Texto del botón de cancelación
    cancelText: 'Cancelar',
    
    // Tipo de icono: 'warning', 'danger', 'info', 'question'
    icon: 'warning',
    
    // Clases CSS para el botón de confirmación
    confirmClass: 'bg-yellow-400 hover:bg-yellow-500 text-gray-900',
    
    // Clases CSS para el botón de cancelación
    cancelClass: 'bg-gray-700 hover:bg-gray-600 text-white'
});
```

## Ejemplos por Tipo de Acción

### 1. Eliminar (Danger)

```javascript
await showConfirmation({
    title: 'Eliminar Usuario',
    message: '¿Está seguro de eliminar este usuario? Esta acción no se puede deshacer.',
    confirmText: 'Eliminar',
    cancelText: 'Cancelar',
    icon: 'danger',
    confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
    cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
});
```

### 2. Advertencia (Warning)

```javascript
await showConfirmation({
    title: 'Desactivar Cuenta',
    message: '¿Está seguro de desactivar esta cuenta? Los usuarios no podrán acceder temporalmente.',
    confirmText: 'Desactivar',
    cancelText: 'Cancelar',
    icon: 'warning',
    confirmClass: 'bg-orange-600 hover:bg-orange-700 text-white focus:ring-orange-500',
    cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
});
```

### 3. Información (Info)

```javascript
await showConfirmation({
    title: 'Actualizar Sistema',
    message: 'Una nueva versión está disponible. ¿Desea actualizar ahora?',
    confirmText: 'Actualizar',
    cancelText: 'Más tarde',
    icon: 'info',
    confirmClass: 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
    cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
});
```

### 4. Pregunta (Question)

```javascript
await showConfirmation({
    title: 'Activar Notificaciones',
    message: '¿Desea activar las notificaciones por correo electrónico?',
    confirmText: 'Sí, activar',
    cancelText: 'No, gracias',
    icon: 'question',
    confirmClass: 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500',
    cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
});
```

## Integración con Formularios

### Interceptar envío de formulario

```javascript
document.querySelector('form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        await showConfirmation({
            title: 'Confirmar Envío',
            message: '¿Está seguro de enviar este formulario?',
            confirmText: 'Enviar',
            icon: 'question'
        });
        
        // Si confirma, enviar el formulario
        this.submit();
    } catch (error) {
        // Si cancela, no hacer nada
        console.log('Envío cancelado');
    }
});
```

### Ejemplo en Blade (múltiples formularios)

```html
<form class="delete-form" data-item-name="Item 1">
    @csrf
    @method('DELETE')
    <button type="submit">Eliminar</button>
</form>

<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const itemName = this.dataset.itemName;
        
        try {
            await showConfirmation({
                title: 'Eliminar Item',
                message: `¿Está seguro de eliminar "${itemName}"?`,
                confirmText: 'Eliminar',
                cancelText: 'Cancelar',
                icon: 'danger',
                confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
                cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
            });
            
            this.submit();
        } catch (error) {
            console.log('Eliminación cancelada');
        }
    });
});
</script>
```

## Integración con AJAX

```javascript
async function eliminarUsuario(userId) {
    try {
        await showConfirmation({
            title: 'Eliminar Usuario',
            message: '¿Está seguro de eliminar este usuario?',
            confirmText: 'Eliminar',
            cancelText: 'Cancelar',
            icon: 'danger',
            confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
            cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
        });
        
        // Usuario confirmó, hacer petición AJAX
        const response = await fetch(`/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            showSuccess('Usuario eliminado exitosamente', 'Éxito');
            // Recargar o actualizar UI
        } else {
            showError('Error al eliminar usuario', 'Error');
        }
    } catch (error) {
        // Usuario canceló o error en la petición
        console.log('Operación cancelada o error:', error);
    }
}
```

## Colores Predefinidos (Estilo Filament)

### Botones de Confirmación

```javascript
// Rojo (Eliminar/Peligro)
confirmClass: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500'

// Naranja (Advertencia)
confirmClass: 'bg-orange-600 hover:bg-orange-700 text-white focus:ring-orange-500'

// Verde (Activar/Éxito)
confirmClass: 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500'

// Azul (Información)
confirmClass: 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500'

// Índigo (Pregunta)
confirmClass: 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500'
```

### Botón de Cancelación (Recomendado - Estilo Filament)

```javascript
// Botón blanco con borde (tema claro y oscuro)
cancelClass: 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600'
```

## Notas Importantes

1. **Promise-based**: El modal retorna una promesa que se resuelve con `true` al confirmar y se rechaza al cancelar.

2. **Async/Await**: Se recomienda usar `async/await` con `try/catch` para un código más limpio.

3. **Cierre automático**: El modal se cierra automáticamente al presionar ESC o hacer clic fuera del modal.

4. **Prevent scroll**: El modal previene el scroll del body mientras está abierto.

5. **Global**: La función `showConfirmation()` está disponible globalmente en `window`.

## Migrando desde confirm() nativo

### Antes (confirm nativo)

```javascript
if (confirm('¿Está seguro?')) {
    eliminarRegistro();
}
```

### Después (modal personalizado)

```javascript
try {
    await showConfirmation({
        title: 'Confirmar Acción',
        message: '¿Está seguro?'
    });
    eliminarRegistro();
} catch (error) {
    // Cancelado
}
```

## Soporte y Personalización

Para personalizar el diseño del modal, edita el archivo:
`resources/views/components/confirmation-modal.blade.php`

Para modificar el comportamiento JavaScript, edita la función `confirmationModal()` en el mismo archivo.

## Compatibilidad

- ✅ Alpine.js 3.x
- ✅ Tailwind CSS 3.x
- ✅ Navegadores modernos (Chrome, Firefox, Safari, Edge)
- ✅ Responsive (móviles, tablets, desktop)

