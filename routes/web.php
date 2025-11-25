<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Ruta raíz redirige al login
Route::get('/', function () {
    return redirect()->route('iniciarSesion');
});

// Rutas publicas de registro
Route::get('/register', [AuthController::class, 'mostrarVistaRegistro'])->name('registrar');
Route::post('/register', [AuthController::class, 'registrar'])->name('registrar.submit');

Route::get('/login', [AuthController::class, 'mostrarVistaInicioSesion'])->name('iniciarSesion');
Route::post('/login', [AuthController::class, 'iniciarSesion'])->name('iniciarSesion.submit');

Route::middleware('auth')->group(function () {
    Route::get('/index', function () {
        return view('index');
    })->name('index');

    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');
});

// Ruta de logout
Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');

// Incremento 2: Ruta para el manejo de horarios de disponibilidad del proveedor
use App\Http\Controllers\DisponibilidadController;
Route::middleware(['auth'])->group(function () {
    Route::get('/provider/disponibilidad', [DisponibilidadController::class, 'mostrarDisponibilidad'])->name('MiDisponibilidad');
    Route::post('/provider/disponibilidad', [DisponibilidadController::class, 'guardarDisponibilidad'])->name('MiDisponibilidad.guardar');
});