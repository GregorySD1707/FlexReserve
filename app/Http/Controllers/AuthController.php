<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Mostrar formulario de registro
    public function mostrarVistaRegistro()
    {
        return view('VistaRegistro');
    }

    // Procesar registro
    public function registrar(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:users,email',
            'contraseña' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'nombre_empresa' => 'prohibited',
            'descripcion_proveedor' => 'required_if:roles,proveedor|string|max:1000',
            'fecha_nacimiento' => 'required_if:roles,cliente|date',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'roles' => 'required|in:cliente,proveedor',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            // username removed; email is unique identifier
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser una dirección válida.',
            'correo.unique' => 'El correo ya está en uso.',
            'contraseña.required' => 'La contraseña es obligatoria.',
            // Mensajes unificados para reglas de seguridad: mostrar "contraseña no válida"
            'contraseña.min' => 'contraseña no válida',
            'contraseña.letters' => 'contraseña no válida',
            'contraseña.mixedCase' => 'contraseña no válida',
            'contraseña.numbers' => 'contraseña no válida',
            'contraseña.symbols' => 'contraseña no válida',
            'roles.required' => 'Debe seleccionar un rol.',
            'fecha_nacimiento.required_if' => 'La fecha de nacimiento es obligatoria para clientes.',
            'roles.in' => 'El rol seleccionado no es válido.',
        ]);

        // Crear el usuario (sin username)
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->correo,
            'password' => Hash::make($request->contraseña),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        // Asignar rol
        $user->assignRole($request->roles);

        // Crear registros adicionales según rol (usando modelos en inglés y atributos en inglés)
        if ($request->roles === 'proveedor') {
            \App\Models\Provider::create([
                'user_id' => $user->id,
                'description' => $request->descripcion_proveedor,
            ]);
        }

        if ($request->roles === 'cliente') {
            \App\Models\Client::create([
                'user_id' => $user->id,
                'birth_date' => $request->fecha_nacimiento ?? null,
            ]);
        }

        // Iniciar sesión automáticamente
        Auth::login($user);

        return redirect()->route('index')->with('success', 'Registro exitoso. Bienvenido a FlexReserve.');
    }

    // Mostrar formulario inicio de sesión
    public function mostrarVistaInicioSesion()
    {
        return view('VistaInicioSesion');
    }

    public function iniciarSesion(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required',
            'roles' => 'required|in:cliente,proveedor',
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser una dirección válida.',
            'contraseña.required' => 'La contraseña es obligatoria.',
            'roles.required' => 'Debe seleccionar un rol al iniciar sesión.',
            'roles.in' => 'El rol seleccionado no es válido.',
        ]);

        // Intentar autenticación
        if (Auth::attempt(['email' => $request->correo, 'password' => $request->contraseña])) {
            // Verificar que el usuario autenticado tenga el rol solicitado
            $user = Auth::user();
            if ($user->hasRole($request->roles)) {
                // Autenticación y rol correctos
                $request->session()->regenerate();
                return redirect()->route('index');
            }

            // Rol no coincide: cerrar sesión y devolver error
            Auth::logout();
            return back()->withErrors([
                'roles' => 'El rol proporcionado no coincide con la cuenta.',
            ])->onlyInput('correo');
        }

        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no son correctas.',
        ])->onlyInput('correo');
    }

    // Cerrar sesión
    public function cerrarSesion(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('iniciarSesion');
    }

}
