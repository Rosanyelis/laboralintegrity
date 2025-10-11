# Componente Company Search

## Descripción

`company-search` es un componente reutilizable de búsqueda de empresas con autocompletado en tiempo real. Permite buscar empresas por RNC o nombre y muestra sugerencias dinámicas mientras el usuario escribe.

## Características

- ✅ Búsqueda en tiempo real con debounce (300ms)
- ✅ Autocompletado con dropdown de resultados
- ✅ Búsqueda por RNC o nombre de empresa
- ✅ Indicador de carga visual
- ✅ Limpieza rápida de búsqueda
- ✅ Relleno automático de campos relacionados
- ✅ Responsive y compatible con modo oscuro
- ✅ Totalmente reutilizable en cualquier formulario

## Uso Básico

```blade
<x-company-search 
    label="Buscar Empresa"
    placeholder="Buscar por RNC o nombre de empresa..."
    x-model="formData"
/>
```

## Parámetros

| Parámetro | Tipo | Por Defecto | Descripción |
|-----------|------|-------------|-------------|
| `searchRoute` | string | `route('work-integrities.search-companies')` | Ruta del endpoint de búsqueda |
| `label` | string | `'Buscar Empresa'` | Etiqueta del campo |
| `placeholder` | string | `'Buscar por RNC o nombre de empresa...'` | Placeholder del input |
| `emptyMessage` | string | `'No se encontraron empresas'` | Mensaje cuando no hay resultados |
| `required` | boolean | `false` | Indica si el campo es obligatorio |
| `x-model` | string | `'formData'` | Nombre del objeto Alpine.js donde se guardarán los datos |

## Campos que se llenan automáticamente

Cuando se selecciona una empresa, el componente llena automáticamente los siguientes campos en el objeto especificado en `x-model`:

- `company_id` - ID de la empresa
- `company_code` - Código único de la empresa
- `company_name` - Nombre comercial
- `company_branch` - Sucursal
- `company_phone` - Teléfono
- `company_email` - Email
- `representative_name` - Nombre del representante
- `representative_phone` - Teléfono del representante
- `representative_email` - Email del representante

## Ejemplo Completo

```blade
<div x-data="myForm()">
    <form @submit.prevent="submitForm">
        <!-- Componente de búsqueda de empresa -->
        <x-company-search 
            label="Seleccionar Empresa"
            placeholder="Buscar empresa por RNC o nombre..."
            x-model="formData"
            required
        />

        <!-- Los campos se llenan automáticamente -->
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label>Código Empresa</label>
                <input type="text" x-model="formData.company_code" readonly>
            </div>
            <div>
                <label>Nombre Empresa</label>
                <input type="text" x-model="formData.company_name" readonly>
            </div>
        </div>

        <!-- Hidden inputs para envío -->
        <input type="hidden" name="company_id" x-model="formData.company_id">
        <input type="hidden" name="company_code" x-model="formData.company_code">
        <!-- ... resto de campos ... -->
    </form>
</div>

<script>
    function myForm() {
        return {
            formData: {
                company_id: '',
                company_code: '',
                company_name: '',
                company_branch: '',
                company_phone: '',
                company_email: '',
                representative_name: '',
                representative_phone: '',
                representative_email: '',
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
<x-company-search 
    searchRoute="{{ route('mi-modulo.search-companies') }}"
    x-model="misDatos"
/>
```

### Cambiando el objeto de destino

```blade
<x-company-search 
    x-model="empresa"
/>
```

Esto guardará los datos en `empresa.company_id`, `empresa.company_name`, etc.

## Requisitos

### Endpoint de Backend

El componente requiere un endpoint que devuelva resultados en el siguiente formato:

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "rnc": "131-12345-6",
            "code": "EMP001",
            "name": "Empresa Ejemplo S.A.",
            "display": "131-12345-6 - Empresa Ejemplo S.A.",
            "branch": "Sede Central",
            "phone": "809-555-1234",
            "email": "info@ejemplo.com",
            "representative_name": "Juan Pérez",
            "representative_phone": "809-555-5678",
            "representative_email": "juan@ejemplo.com"
        }
    ]
}
```

### Ejemplo de Controlador

```php
public function searchCompanies(Request $request)
{
    $search = $request->get('search', '');
    
    if (strlen($search) < 2) {
        return response()->json(['success' => true, 'data' => []]);
    }
    
    $companies = Company::where('rnc', 'like', '%' . $search . '%')
        ->orWhere('business_name', 'like', '%' . $search . '%')
        ->limit(10)
        ->get()
        ->map(function($company) {
            return [
                'id' => $company->id,
                'rnc' => $company->rnc,
                'code' => $company->code_unique ?? $company->rnc,
                'name' => $company->business_name,
                'display' => $company->rnc . ' - ' . $company->business_name,
                'branch' => $company->branch ?? 'Sede Central',
                'phone' => $company->landline_phone ?? '',
                'email' => $company->email ?? '',
                'representative_name' => $company->representative_name ?? '',
                'representative_phone' => $company->representative_mobile ?? '',
                'representative_email' => $company->representative_email ?? '',
            ];
        });
    
    return response()->json(['success' => true, 'data' => $companies]);
}
```

### Ruta

```php
Route::get('/companies/search', [CompanyController::class, 'searchCompanies'])
    ->name('companies.search');
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

- La búsqueda se activa después de escribir al menos 2 caracteres
- Hay un debounce de 300ms para evitar múltiples peticiones
- El dropdown se cierra al hacer clic fuera
- Se puede limpiar la selección con el botón X

## Soporte

Para más información o soporte, consultar la documentación del proyecto principal.

