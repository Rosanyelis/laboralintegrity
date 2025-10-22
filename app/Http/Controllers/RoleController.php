<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Helpers\PermissionHelper;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('permissions')->orderBy('name')->get();
        
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los permisos agrupados por módulo
        $permissions = Permission::orderBy('name')->get();
        
        // Agrupar permisos por módulo (basado en el prefijo antes del punto)
        $groupedPermissions = $permissions->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        // Ordenar módulos según prioridad
        $groupedPermissions = PermissionHelper::sortModules($groupedPermissions->toArray());
        
        return view('roles.create', compact('groupedPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar permisos usando Gate
        Gate::authorize('create', Role::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
            'permissions.array' => 'Los permisos deben ser un array.',
            'permissions.*.exists' => 'Uno o más permisos seleccionados no son válidos.',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        
        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('config.roles.index')
            ->with('success', "Rol \"{$role->name}\" creado correctamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        
        // Agrupar permisos por módulo
        $groupedPermissions = $role->permissions->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        // Ordenar módulos según prioridad
        $groupedPermissions = PermissionHelper::sortModules($groupedPermissions->toArray());
        
        return view('roles.show', compact('role', 'groupedPermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // Obtener todos los permisos agrupados por módulo
        $permissions = Permission::orderBy('name')->get();
        
        // Agrupar permisos por módulo
        $groupedPermissions = $permissions->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        // Ordenar módulos según prioridad
        $groupedPermissions = PermissionHelper::sortModules($groupedPermissions->toArray());
        
        // Obtener los permisos actuales del rol
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Verificar permisos usando Gate
        Gate::authorize('update', $role);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
            'permissions.array' => 'Los permisos deben ser un array.',
            'permissions.*.exists' => 'Uno o más permisos seleccionados no son válidos.',
        ]);

        $role->update(['name' => $validated['name']]);
        
        // Sincronizar permisos (elimina los antiguos y asigna los nuevos)
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('config.roles.index')
            ->with('success', "Rol \"{$role->name}\" actualizado correctamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Verificar permisos usando Gate
        Gate::authorize('delete', $role);

        // Verificar si hay usuarios asignados a este rol
        $usersCount = $role->users()->count();
        
        if ($usersCount > 0) {
            $mensaje = $usersCount === 1 
                ? "No se puede eliminar el rol \"{$role->name}\" porque tiene 1 usuario asignado."
                : "No se puede eliminar el rol \"{$role->name}\" porque tiene {$usersCount} usuarios asignados.";
            
            return redirect()->route('config.roles.index')
                ->with('error', $mensaje);
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('config.roles.index')
            ->with('success', "Rol \"{$roleName}\" eliminado correctamente.");
    }
}

