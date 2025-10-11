# Componente Person Search

## Descripción

`person-search` es un componente reutilizable de búsqueda de personas con autocompletado en tiempo real. Permite buscar personas por cédula o nombre y muestra sugerencias dinámicas mientras el usuario escribe.

## Características

- ✅ Búsqueda en tiempo real con debounce (300ms)
- ✅ Autocompletado con dropdown de resultados
- ✅ Búsqueda por cédula o nombre completo
- ✅ Indicador de carga visual
- ✅ Limpieza rápida de búsqueda
- ✅ Relleno automático de campos relacionados
- ✅ Responsive y compatible con modo oscuro
- ✅ Totalmente reutilizable en cualquier formulario

## Uso Básico

```blade
<x-person-search 
    label="Buscar Persona por Cédula"
    placeholder="Buscar por cédula o nombre..."
    x-model="formData"
    required
/>
```

## Parámetros

| Parámetro | Tipo | Por Defecto | Descripción |
|-----------|------|-------------|-------------|
| `searchRoute` | string | `route('work-integrities.search-people')` | Ruta del endpoint de búsqueda |
| `label` | string | `'Buscar Persona'` | Etiqueta del campo |
| `placeholder` | string | `'Buscar por cédula o nombre...'` | Placeholder del input |
| `emptyMessage` | string | `'No se encontraron personas'` | Mensaje cuando no hay resultados |
| `required` | boolean | `false` | Indica si el campo es obligatorio |
| `x-model` | string | `'formData'` | Nombre del objeto Alpine.js donde se guardarán los datos |

## Campos que se llenan automáticamente

Cuando se selecciona una persona, el componente llena automáticamente los siguientes campos en el objeto especificado en `x-model`:

- `person_id` - ID de la persona
- `person_dni` - Cédula de la persona
- `person_name` - Nombre completo
- `dni` - Cédula (duplicado)
- `previous_dni` - Cédula anterior
- `birth_date` - Fecha de nacimiento
- `birth_place` - Lugar de nacimiento
- `province` - Provincia de residencia
- `municipality` - Municipio de residencia

## Ejemplo Completo

```blade
<div x-data="myForm()">
    <form @submit.prevent="submitForm">
        <!-- Componente de búsqueda de persona -->
        <x-person-search 
            label="Seleccionar Persona"
            placeholder="Buscar persona por cédula o nombre..."
            x-model="formData"
            required
        />

        <!-- Los campos se llenan automáticamente -->
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label>Cédula</label>
                <input type="text" x-model="formData.person_dni" readonly>
            </div>
            <div>
                <label>Nombre Completo</label>
                <input type="text" x-model="formData.person_name" readonly>
            </div>
            <div>
                <label>Fecha de Nacimiento</label>
                <input type="date" x-model="formData.birth_date" readonly>
            </div>
            <div>
                <label>Lugar de Nacimiento</label>
                <input type="text" x-model="formData.birth_place" readonly>
            </div>
        </div>

        <!-- Hidden inputs para envío -->
        <input type="hidden" name="person_id" x-model="formData.person_id">
        <input type="hidden" name="person_dni" x-model="formData.person_dni">
        <!-- ... resto de campos ... -->
    </form>
</div>

<script>
    function myForm() {
        return {
            formData: {
                person_id: '',
                person_dni: '',
                person_name: '',
                dni: '',
                previous_dni: '',
                birth_date: '',
                birth_place: '',
                province: '',
                municipality: '',
            },
            
            submitForm() {
                // Lógica de envío
            }
        }
    }
</script>
```

## Personalización Avanzada

### Usando una ruta diferente

```blade
<x-person-search 
    searchRoute="{{ route('mi-modulo.search-people') }}"
    x-model="misDatos"
/>
```

### Cambiando el objeto de destino

```blade
<x-person-search 
    x-model="persona"
/>
```

Esto guardará los datos en `persona.person_id`, `persona.person_name`, etc.

## Requisitos

### Endpoint de Backend

El componente requiere un endpoint que devuelva resultados en el siguiente formato:

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "dni": "402-1234567-8",
            "name": "Juan Pérez Gómez",
            "display": "402-1234567-8 - Juan Pérez Gómez",
            "previous_dni": "001-0012345-6",
            "birth_date": "1990-05-15",
            "birth_place": "Santo Domingo",
            "province": "Distrito Nacional",
            "municipality": "Santo Domingo Este"
        }
    ]
}
```

### Ejemplo de Controlador

```php
public function searchPeople(Request $request)
{
    $search = $request->get('search', '');
    
    if (strlen($search) < 3) {
        return response()->json(['success' => true, 'data' => []]);
    }
    
    $people = Person::with(['residenceInformation.province', 'residenceInformation.municipality'])
        ->where('dni', 'like', '%' . $search . '%')
        ->orWhere('name', 'like', '%' . $search . '%')
        ->orWhere('last_name', 'like', '%' . $search . '%')
        ->limit(10)
        ->get()
        ->map(function($person) {
            return [
                'id' => $person->id,
                'dni' => $person->dni,
                'name' => $person->name . ' ' . $person->last_name,
                'display' => $person->dni . ' - ' . $person->name . ' ' . $person->last_name,
                'previous_dni' => $person->previous_dni,
                'birth_date' => $person->birth_date?->format('Y-m-d'),
                'birth_place' => $person->birth_place,
                'province' => $person->residenceInformation?->province?->name ?? '',
                'municipality' => $person->residenceInformation?->municipality?->name ?? '',
            ];
        });
    
    return response()->json(['success' => true, 'data' => $people]);
}
```

### Ruta

```php
Route::get('/people/search', [PersonController::class, 'searchPeople'])
    ->name('people.search');
```

## Dependencias

- Alpine.js 3.x
- Tailwind CSS 3.x
- Fetch API (nativo del navegador)

## Compatibilidad

- ✅ Modo claro y oscuro
- ✅ Responsive (móvil, tablet, desktop)
- ✅ Navegadores modernos (Chrome, Firefox, Safari, Edge)

## Notas

- La búsqueda se activa después de escribir al menos 3 caracteres
- Hay un debounce de 300ms para evitar múltiples peticiones
- El dropdown se cierra al hacer clic fuera
- Se puede limpiar la selección con el botón X
- Busca por cédula, nombre o apellido

## Diferencias con Company Search

- Requiere mínimo 3 caracteres (vs 2 para empresas)
- Busca en 3 campos: DNI, nombre y apellido
- Muestra cédula en lugar de RNC en los resultados
- Llena campos específicos de personas (fecha de nacimiento, lugar de nacimiento, etc.)

## Soporte

Para más información o soporte, consultar la documentación del proyecto principal.

