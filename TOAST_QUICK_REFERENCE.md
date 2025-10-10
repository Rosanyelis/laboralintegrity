# Guía Rápida: Sistema de Notificaciones Toast

## Para crear, editar o eliminar registros

### En tus controladores, simplemente usa:

```php
// ✅ AL CREAR
return redirect()->route('items.index')
    ->with('success', 'Registro creado exitosamente.');

// ✅ AL ACTUALIZAR
return redirect()->route('items.show', $item)
    ->with('success', 'Información actualizada correctamente.');

// ✅ AL ELIMINAR
return redirect()->route('items.index')
    ->with('success', 'Registro eliminado exitosamente.');
```

## ¡Eso es todo!

No necesitas agregar código adicional en las vistas. Los toasts aparecerán automáticamente.

## Tipos de mensajes disponibles

| Tipo | Clave de sesión | Color | Uso |
|------|----------------|-------|-----|
| Éxito | `success` | Verde | Operaciones exitosas |
| Información | `status` | Azul | Mensajes informativos |
| Error | (automático) | Rojo | Errores de validación |

## Desde JavaScript (opcional)

```javascript
// Éxito
showSuccess('Operación completada', 'Éxito');

// Error
showError('Algo salió mal', 'Error');

// Advertencia
showWarning('Ten cuidado', 'Advertencia');

// Información
showInfo('Dato importante', 'Información');
```

## Solución rápida si no funcionan los toasts

```bash
# 1. Asegúrate de que Vite esté corriendo
npm run dev

# 2. Limpia la caché de Laravel
php artisan view:clear
php artisan cache:clear

# 3. Recarga la página con Ctrl+F5 (recarga forzada)
```

### Página de prueba

Visita `/test-toast` en tu navegador para probar el sistema de toast y ver logs de debug en la consola.

### Qué verificar en la consola del navegador:

1. Abre la consola (F12)
2. Deberías ver estos mensajes:
   - `[Toast System] Sistema de toast cargado correctamente`
   - `ToastManager inicializado`
   - `Alpine.js está funcionando correctamente`
3. Al hacer clic en un botón o al crear/editar/eliminar registros:
   - `[Toast] showSuccess llamado: ...`
   - `[Toast] showToast iniciado con opciones: ...`
   - `[Toast] Container encontrado: ...`
   - `[Toast] Toast creado: ...`

Si ves "Toast container NO encontrado", verifica que el layout tenga `<x-toast-container>`.

## Plantilla para nuevos controladores

```php
<?php

namespace App\Http\Controllers;

use App\Models\TuModelo;
use App\Http\Requests\TuModelo\StoreTuModeloRequest;
use App\Http\Requests\TuModelo\UpdateTuModeloRequest;

class TuModeloController extends Controller
{
    public function store(StoreTuModeloRequest $request)
    {
        $modelo = TuModelo::create($request->validated());
        
        return redirect()->route('modelos.index')
            ->with('success', 'Registro creado exitosamente.');
    }

    public function update(UpdateTuModeloRequest $request, TuModelo $modelo)
    {
        $modelo->update($request->validated());
        
        return redirect()->route('modelos.show', $modelo)
            ->with('success', 'Información actualizada correctamente.');
    }

    public function destroy(TuModelo $modelo)
    {
        $modelo->delete();
        
        return redirect()->route('modelos.index')
            ->with('success', 'Registro eliminado exitosamente.');
    }
}
```

---

📖 **Documentación completa:** Ver `TOAST_SYSTEM_README.md`

