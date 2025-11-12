<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Mostrar formulario de inicio de sesión
    public function mostrarVistaRegistro()
    {
        return view('VistaRegistro');
    }

    // Procesar registro
    public function registrar(Request $request)
    {
        /*
        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|correo|unique:users,correo',
            'contraseña' => 'required|min:8',
            'fechaDeNacimiento' => 'required|date',
            'rol' => 'required|in:cliente,proveedor',
        ]);

        // INTERACCION CON LA BASE DE DATOS
        // 1. Crear el usuario en la tabla usuario
        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'contraseña' => bcrypt($request->contraseña),
            'fecha_de_nacimiento' => $request->fechaDeNacimiento,
        ]);

        // 2. asignar el rol en tabla user_has_roles

        // 3. crear registro en cliente o proveedor

        // iniciar sesión automáticamente
        Auth::login($user);
        */
        return redirect()->route('index');
    }

    // Motrar formulario inicio de sesión
    public function mostrarVistaInicioSesion()
    {
        return view('VistaInicioSesion');
    }

    public function iniciarSesion(Request $request)
    {
        /*
        $request->validate([
            'correo' => 'required|correo',
            'contraseña' => 'required',
        ]);

        // Verificar en BD
        // buscar usuari por correo y verificar contraseña
        if (Auth::attempt(['correo' => $request->correo, 'contraseña' => $request->contraseña])) {
            // Autenticación exitosa
            $request->session()->regenerate();
            return redirect()->route('index');
        }

        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no son correctas.',
        ])->onlyInput('correo');
        */
        return redirect()->route('index');
    }

    // Cerrar sesión
    public function cerrarSesion(Request $request)
    {
        /*
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('VistaInicioSesion');
        */
        return redirect()->route('iniciarSesion');
    }

}
