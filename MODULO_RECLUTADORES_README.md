# Módulo de Reclutadores

## Descripción
El módulo de Reclutadores gestiona la relación entre empresas y personas (representantes autorizados). Un reclutador puede estar asociado opcionalmente a una empresa, pero siempre debe tener un representante autorizado (persona).

## Características Principales

### 1. Código Único Automático
- **Formato**: `XX-DDMMYYYY` (Ej: `01-10102025`, `02-10102025`)
- Generado automáticamente por el `RecruiterObserver`
- La secuencia numérica continúa sin reiniciarse cada día

### 2. Búsquedas Inteligentes
- **Por RNC**: Busca y precarga información completa de la empresa
- **Por Cédula**: Busca y precarga información del representante autorizado
- Respuestas AJAX en tiempo real

### 3. Relaciones Opcionales
- Checkbox para indicar si aplica empresa
- Si no aplica empresa, solo se registra el representante autorizado
- Validaciones dinámicas según la selección

## Estructura de Base de Datos

### Tabla: `recruiters`
```sql
- id (PK)
- code_unique (único)
- registration_date
- company_id (nullable, FK a companies)
- person_id (not null, FK a people)
- branch (sucursal, nullable)
- timestamps
- softDeletes
```

## Archivos Creados

### Backend
1. **Migration**: `database/migrations/2025_10_10_145249_create_recruiters_table.php`
2. **Modelo**: `app/Models/Recruiter.php`
3. **Observer**: `app/Observers/RecruiterObserver.php`
4. **Controller**: `app/Http/Controllers/RecruiterController.php`
5. **Rutas**: Agregadas en `routes/web.php`

### Frontend
1. **Index**: `resources/views/recruiters/index.blade.php`
2. **Create**: `resources/views/recruiters/create.blade.php`
3. **Edit**: `resources/views/recruiters/edit.blade.php`
4. **Show**: `resources/views/recruiters/show.blade.php`

## Rutas Disponibles

### Rutas CRUD
- `GET /recruiters` - Listar todos los reclutadores
- `GET /recruiters/create` - Formulario de creación
- `POST /recruiters` - Guardar nuevo reclutador
- `GET /recruiters/{id}` - Ver detalle
- `GET /recruiters/{id}/edit` - Formulario de edición
- `PUT /recruiters/{id}` - Actualizar reclutador
- `DELETE /recruiters/{id}` - Eliminar reclutador

### Rutas AJAX
- `GET /recruiters/search-by-rnc` - Buscar empresa por RNC
- `GET /recruiters/search-by-dni` - Buscar persona por cédula

## Funcionalidades del Formulario

### Formulario de Creación
1. **Fecha de Registro**: Campo de fecha (por defecto hoy)
2. **Código**: Generado automáticamente (readonly)
3. **Checkbox "¿Aplica empresa?"**:
   - Si está marcado: Muestra sección de empresa
   - Si no está marcado: Solo pide datos del representante

4. **Sección de Empresa** (si aplica):
   - Búsqueda por RNC
   - Campos precargados automáticamente
   - Selector de sucursal

5. **Sección de Representante Autorizado** (obligatorio):
   - Búsqueda por cédula
   - Campos precargados automáticamente

### Validaciones
- Fecha de registro: requerida
- Representante autorizado: siempre requerido
- Empresa: solo requerida si el checkbox está marcado
- Validación JavaScript antes de enviar el formulario

## Listado (Data Table)

### Columnas Mostradas
1. Código único
2. Nombre de empresa (o "N/A" si no aplica)
3. Nombre del representante
4. Cédula
5. Teléfono
6. Provincia
7. Municipio

### Acciones Disponibles
- Ver detalle (👁️)
- Editar (✏️)
- Eliminar (🗑️ con confirmación)

## Vista de Detalle

Muestra tres secciones:
1. **Información del Reclutador**: Código, fecha de registro, sucursal
2. **Información de la Empresa**: Todos los datos de la empresa (si aplica)
3. **Representante Autorizado**: Información completa con enlace al perfil

## Integración con el Sistema

### Menú de Navegación
- Agregado en el menú principal: "Reclutadores"
- Disponible entre "Empresas" y "Configuraciones"
- Incluido en versión desktop y móvil

### Notificaciones Toast
- Registro exitoso
- Actualización exitosa
- Eliminación exitosa
- Mensajes de error con detalles

## Observaciones Técnicas

### Observer Pattern
El `RecruiterObserver` está registrado en `AppServiceProvider` y genera automáticamente el código único al crear un nuevo reclutador.

### Eager Loading
Se utiliza eager loading para optimizar las consultas:
```php
$recruiters = Recruiter::with([
    'company',
    'person.residenceInformation.municipality.province'
])->get();
```

### Soft Deletes
Los reclutadores eliminados no se borran físicamente, se usa soft delete para mantener el histórico.

## Próximas Mejoras Sugeridas
1. Exportar listado a Excel/PDF
2. Filtros avanzados en el listado
3. Historial de cambios
4. Reportes estadísticos
5. Asignación de permisos específicos para el módulo

---

**Fecha de Creación**: 10 de Octubre de 2025
**Versión**: 1.0.0

