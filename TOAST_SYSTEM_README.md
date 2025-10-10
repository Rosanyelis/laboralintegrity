# Sistema de Notificaciones Toast

Este sistema proporciona notificaciones tipo "Toast" que aparecen en la esquina superior derecha de la pantalla y desaparecen automáticamente.

## Características

- **4 tipos de notificaciones**: éxito, error, advertencia e información
- **Auto-dismiss**: Las notificaciones desaparecen automáticamente después de un tiempo configurable
- **Posicionamiento flexible**: Se pueden mostrar en diferentes posiciones de la pantalla
- **Botón de cierre**: Opción para cerrar manualmente las notificaciones
- **Integración con Alpine.js**: Funciona perfectamente con Alpine.js
- **Responsive**: Se adapta a diferentes tamaños de pantalla
- **Tema oscuro**: Soporte completo para modo oscuro
- **Integrado con Vite**: Cargado automáticamente en todos los layouts

## Requisitos previos

El sistema de toast está integrado automáticamente en los layouts `app.blade.php` y `guest.blade.php`. No se requiere configuración adicional para usarlo.

## Uso desde JavaScript

### Funciones globales disponibles:

```javascript
// Mostrar toast de éxito
showSuccess('Mensaje de éxito', 'Título opcional');

// Mostrar toast de error
showError('Mensaje de error', 'Título opcional');

// Mostrar toast de advertencia
showWarning('Mensaje de advertencia', 'Título opcional');

// Mostrar toast de información
showInfo('Mensaje informativo', 'Título opcional');

// Mostrar toast personalizado
showToast({
    type: 'success', // success, error, warning, info
    title: 'Título',
    message: 'Mensaje',
    duration: 5000, // milisegundos (0 = no auto-dismiss)
    dismissible: true,
    position: 'top-right' // top-right, top-left, bottom-right, bottom-left, top-center, bottom-center
});
```

### Uso desde Alpine.js:

```html
<div x-data>
    <button @click="showSuccess('Operación exitosa')">
        Mostrar Éxito
    </button>
    
    <button @click="showError('Error en la operación')">
        Mostrar Error
    </button>
</div>
```

### Uso desde formularios:

```html
<form @submit="showInfo('Procesando formulario...', 'Cargando')">
    <!-- campos del formulario -->
    <button type="submit">Enviar</button>
</form>
```

## Integración con Laravel

### Desde controladores PHP:

El sistema de toast está configurado para detectar automáticamente los siguientes mensajes de sesión en todos los layouts:

#### Mensaje de éxito (verde):
```php
// Usar con operaciones exitosas (crear, actualizar, eliminar)
return redirect()->route('people.index')
    ->with('success', 'Persona creada exitosamente.');
```

#### Mensaje de información (azul):
```php
// Usar con mensajes de estado o informativos
return redirect()->route('dashboard')
    ->with('status', 'Operación en proceso.');
```

#### Mensajes de error (rojo):
```php
// Los errores de validación se muestran automáticamente
// No se requiere código adicional en el controlador
```

### Patrón recomendado para nuevos controladores CRUD:

```php
public function store(StoreRequest $request)
{
    // Lógica de creación
    $model = Model::create($validated);
    
    return redirect()->route('models.index')
        ->with('success', 'Registro creado exitosamente.');
}

public function update(UpdateRequest $request, Model $model)
{
    // Lógica de actualización
    $model->update($validated);
    
    return redirect()->route('models.show', $model)
        ->with('success', 'Información actualizada correctamente.');
}

public function destroy(Model $model)
{
    // Lógica de eliminación
    $model->delete();
    
    return redirect()->route('models.index')
        ->with('success', 'Registro eliminado exitosamente.');
}
```

### Para layouts personalizados:

Si creas un layout personalizado que no hereda de `app.blade.php` o `guest.blade.php`, necesitas agregar:

```blade
<!DOCTYPE html>
<html>
    <head>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <x-toast-container>
            <!-- Tu contenido -->
            {{ $slot }}
        </x-toast-container>

        @if(session('success'))
            <script>
                window.addEventListener('load', function() {
                    if (typeof showSuccess === 'function') {
                        showSuccess('{{ session('success') }}', 'Éxito');
                    }
                });
            </script>
        @endif

        @if(session('status'))
            <script>
                window.addEventListener('load', function() {
                    if (typeof showInfo === 'function') {
                        showInfo('{{ session('status') }}', 'Información');
                    }
                });
            </script>
        @endif

        @if($errors->any())
            <script>
                window.addEventListener('load', function() {
                    if (typeof showError === 'function') {
                        showError('{{ $errors->first() }}', 'Error de validación');
                    }
                });
            </script>
        @endif
    </body>
</html>
```

## Personalización

### Cambiar posición:

```javascript
showSuccess('Mensaje', 'Título', { position: 'bottom-left' });
```

### Cambiar duración:

```javascript
showInfo('Mensaje', 'Título', { duration: 10000 }); // 10 segundos
showError('Error', 'Título', { duration: 0 }); // No auto-dismiss
```

### Deshabilitar botón de cierre:

```javascript
showWarning('Mensaje', 'Título', { dismissible: false });
```

## Estilos

Los toasts utilizan Tailwind CSS y se adaptan automáticamente al tema oscuro/claro de la aplicación.

### Colores por tipo:
- **Éxito**: Verde
- **Error**: Rojo  
- **Advertencia**: Amarillo
- **Información**: Azul

## Archivos del sistema

- `resources/views/components/toast-container.blade.php` - Contenedor de toasts
- `resources/js/toast-system.js` - Lógica JavaScript del sistema
- `resources/views/layouts/app.blade.php` - Layout principal con soporte de toast
- `resources/views/layouts/guest.blade.php` - Layout de invitado con soporte de toast
- `resources/js/app.js` - Punto de entrada que importa el sistema de toast

## Solución de problemas

### Los toasts no aparecen

1. **Verifica que el servidor de desarrollo esté corriendo:**
   ```bash
   npm run dev
   ```

2. **Verifica que el bundle de Vite se esté cargando:**
   - Abre la consola del navegador
   - Busca errores de JavaScript
   - Verifica que el archivo `app.js` se cargue correctamente

3. **Verifica que el controlador use el formato correcto:**
   ```php
   return redirect()->route('route.name')
       ->with('success', 'Mensaje aquí');
   ```

4. **Limpia la caché de Laravel:**
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

5. **Reconstruye los assets:**
   ```bash
   npm run build
   ```

### Los toasts aparecen pero sin estilos

1. Verifica que Tailwind CSS esté compilándose correctamente
2. Reconstruye los assets: `npm run dev`

### Los mensajes se duplican

Asegúrate de no tener múltiples llamadas al sistema de toast para el mismo mensaje. Revisa que no tengas código personalizado duplicando la funcionalidad.

## Mejores prácticas

1. **Usa mensajes claros y concisos**: Los usuarios deben entender rápidamente qué sucedió.
2. **Usa el tipo correcto de notificación**:
   - `success` para operaciones exitosas
   - `error` para errores y fallos
   - `warning` para advertencias
   - `info` para información general
3. **No sobrecargues con notificaciones**: Evita mostrar múltiples toasts simultáneamente.
4. **Sé consistente**: Usa el mismo patrón en todos tus controladores.

## Ejemplo completo de un nuevo controlador

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        
        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        
        return redirect()->route('products.show', $product)
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
```

**¡Los toasts aparecerán automáticamente sin código adicional en las vistas!**
