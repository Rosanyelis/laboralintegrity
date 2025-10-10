# Componente Select Search

Componente de selector con búsqueda integrada, similar a Select2, construido con Alpine.js y Tailwind CSS.

## Características

- 🔍 Búsqueda en tiempo real
- 🎨 Diseño moderno con soporte para modo oscuro
- ♿ Accesible
- 🎯 Integración con validación de Laravel
- 📱 Responsive
- ⚡ Ligero y rápido (sin dependencias externas)

## Uso Básico

```blade
<x-select-search
    name="person_id"
    :options="[
        ['value' => '1', 'text' => 'Juan Pérez'],
        ['value' => '2', 'text' => 'María García'],
    ]"
    placeholder="Seleccione una persona"
/>
```

## Propiedades

| Propiedad | Tipo | Requerido | Descripción |
|-----------|------|-----------|-------------|
| `name` | string | ✅ | Nombre del campo para el formulario |
| `options` | array | ✅ | Array de opciones con estructura `['value' => '', 'text' => '']` |
| `id` | string | ❌ | ID del elemento (por defecto usa `name`) |
| `selected` | string/int | ❌ | Valor seleccionado por defecto |
| `placeholder` | string | ❌ | Texto del placeholder (default: "Seleccione una opción") |
| `searchPlaceholder` | string | ❌ | Texto del placeholder de búsqueda (default: "Buscar...") |
| `label` | string | ❌ | Etiqueta del campo |
| `required` | boolean | ❌ | Si el campo es requerido |
| `error` | string | ❌ | Mensaje de error a mostrar |
| `emptyMessage` | string | ❌ | Mensaje cuando no hay resultados (default: "No se encontraron resultados") |

## Ejemplos de Uso

### Ejemplo 1: Con Laravel Collection

```blade
<x-select-search
    name="person_id"
    label="Persona"
    :options="$people->map(function($person) {
        return [
            'value' => $person->id,
            'text' => $person->name . ' ' . $person->last_name
        ];
    })->toArray()"
    :selected="old('person_id')"
    :required="true"
    :error="$errors->first('person_id')"
/>
```

### Ejemplo 2: Con Array Estático

```blade
<x-select-search
    name="country"
    label="País"
    :options="[
        ['value' => 'do', 'text' => 'República Dominicana'],
        ['value' => 'us', 'text' => 'Estados Unidos'],
        ['value' => 'es', 'text' => 'España'],
    ]"
    placeholder="Seleccione un país"
    searchPlaceholder="Buscar país..."
/>
```

### Ejemplo 3: Con Roles

```blade
<x-select-search
    name="role_id"
    label="Rol"
    :options="$roles->map(fn($role) => [
        'value' => $role->id,
        'text' => $role->name
    ])->toArray()"
    :selected="$user->role_id"
    :required="true"
/>
```

### Ejemplo 4: Con Validación de Laravel

```blade
<x-select-search
    name="category_id"
    label="Categoría"
    :options="$categories->map(fn($cat) => [
        'value' => $cat->id,
        'text' => $cat->name
    ])->toArray()"
    :selected="old('category_id', $product->category_id)"
    :error="$errors->first('category_id')"
    :required="true"
/>
```

## Integración con Formularios

El componente funciona perfectamente con formularios de Laravel:

```blade
<form action="{{ route('users.store') }}" method="POST">
    @csrf
    
    <x-select-search
        name="person_id"
        label="Persona"
        :options="$people"
        :selected="old('person_id')"
        :error="$errors->first('person_id')"
        :required="true"
    />
    
    <button type="submit">Guardar</button>
</form>
```

## Personalización

### Cambiar mensajes

```blade
<x-select-search
    name="option"
    :options="$options"
    placeholder="Elige una opción"
    searchPlaceholder="Escribe para buscar..."
    emptyMessage="No se encontraron coincidencias"
/>
```

### Sin etiqueta

```blade
<x-select-search
    name="option"
    :options="$options"
    placeholder="Seleccione"
/>
```

## Notas Técnicas

- El componente usa Alpine.js para la funcionalidad reactiva
- El campo real que se envía al backend es un input oculto
- La búsqueda filtra por el texto de las opciones
- Compatible con validación de Laravel
- Respeta los valores de `old()` para repoblar después de errores de validación

