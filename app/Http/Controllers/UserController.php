<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['person', 'roles'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener personas que NO tienen usuario asignado
        $availablePeople = Person::whereDoesntHave('user')->orderBy('name')->get();
        
        // Obtener todos los roles disponibles
        $roles = Role::orderBy('name')->get();
        
        return view('users.create', compact('availablePeople', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar permisos usando Gate
        Gate::authorize('create', User::class);

        $validated = $request->validate([
            'person_id' => 'required|exists:people,id|unique:users,person_id',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|exists:roles,id',
        ], [
            'person_id.required' => 'Debe seleccionar una persona.',
            'person_id.exists' => 'La persona seleccionada no existe.',
            'person_id.unique' => 'Esta persona ya tiene un usuario asignado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Ya existe un usuario con este correo electrónico.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'role_id.required' => 'Debe seleccionar un rol.',
            'role_id.exists' => 'El rol seleccionado no es válido.',
        ]);

        // Obtener el nombre de la persona para el usuario
        $person = Person::findOrFail($validated['person_id']);
        $userName = $person->name . ' ' . $person->last_name;

        // Crear el usuario
        $user = User::create([
            'name' => $userName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'person_id' => $validated['person_id'],
        ]);

        // Asignar el rol
        $role = Role::findOrFail($validated['role_id']);
        $user->assignRole($role);

        return redirect()->route('config.users.index')
            ->with('success', "Usuario \"{$user->name}\" creado correctamente con el rol \"{$role->name}\".");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['person', 'roles']);
        
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Obtener personas disponibles (incluyendo la actual del usuario)
        $availablePeople = Person::whereDoesntHave('user')
            ->orWhere('id', $user->person_id)
            ->orderBy('name')
            ->get();
        
        // Obtener todos los roles
        $roles = Role::orderBy('name')->get();
        
        // Obtener el rol actual del usuario
        $userRole = $user->roles->first();
        
        return view('users.edit', compact('user', 'availablePeople', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Verificar permisos usando Gate
        Gate::authorize('update', $user);

        $validated = $request->validate([
            'person_id' => 'required|exists:people,id|unique:users,person_id,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|exists:roles,id',
        ], [
            'person_id.required' => 'Debe seleccionar una persona.',
            'person_id.exists' => 'La persona seleccionada no existe.',
            'person_id.unique' => 'Esta persona ya tiene un usuario asignado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Ya existe un usuario con este correo electrónico.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'role_id.required' => 'Debe seleccionar un rol.',
            'role_id.exists' => 'El rol seleccionado no es válido.',
        ]);

        // Actualizar nombre si cambió la persona
        if ($user->person_id != $validated['person_id']) {
            $person = Person::findOrFail($validated['person_id']);
            $validated['name'] = $person->name . ' ' . $person->last_name;
        }

        // Actualizar datos básicos
        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'],
            'person_id' => $validated['person_id'],
        ]);

        // Actualizar contraseña si se proporcionó
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        // Sincronizar rol (elimina el anterior y asigna el nuevo)
        $role = Role::findOrFail($validated['role_id']);
        $user->syncRoles([$role]);

        return redirect()->route('config.users.index')
            ->with('success', "Usuario \"{$user->name}\" actualizado correctamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Verificar permisos usando Gate
        Gate::authorize('delete', $user);

        $userName = $user->name;
        $user->delete();

        return redirect()->route('config.users.index')
            ->with('success', "Usuario \"{$userName}\" eliminado correctamente.");
    }
}

