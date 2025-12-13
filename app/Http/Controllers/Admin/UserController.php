<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Listar todos los usuarios
     */
    public function index(Request $request)
    {
        $query = User::with('role');

        // Filtros
        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%')
                  ->orWhere('email', 'ilike', '%' . $request->search . '%');
        }

        if ($request->role) {
            $query->where('role_id', $request->role);
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'roles' => $roles,
            'filters' => $request->only(['search', 'role']),
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return Inertia::render('Admin/Users/Create', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(User $user)
    {
        $user->load('role');

        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Solo actualizar password si se proporciona
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $user)
    {
        // Prevenir que el admin se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}

