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

/*
// Rutas protegidas (Rquieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');
});
*/

Route::get('/index', function () {
    return view('index');
})->name('index');

// Ruta de logout
Route::post('/logout', [AuthController::class, 'cerrarSesion'])->name('logout');
