<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirigir según el rol
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Procesar registro
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'terms' => 'required|accepted', // Checkbox de términos obligatorio
        ]);

        // Obtener rol de Customer por defecto
        $customerRole = Role::where('name', 'Customer')->first();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role_id' => $customerRole->id,
        ]);

        Auth::login($user);

        return redirect('/')->with('success', '¡Cuenta creada exitosamente!');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Obtener usuario autenticado
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
