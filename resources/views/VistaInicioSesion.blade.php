<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - FlexReserve</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="panel" style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding-top:2rem;padding-bottom:2rem;">
        <div class="card" style="max-width:440px;width:100%;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div>
                    <div class="app-title">FlexReserve</div>
                    <div class="muted">Inicio de sesión</div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin:0;padding-left:1.1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('iniciarSesion.submit') }}" method="POST">
                @csrf
                <div class="mb-1">
                    <label for="correo">Correo*</label>
                    <input type="email" name="correo" id="correo" value="{{ old('correo') }}" required>
                </div>

                <div class="mb-1">
                    <label for="contraseña">Contraseña*</label>
                    <input type="password" name="contraseña" id="contraseña" required>
                </div>

                <div class="mb-1">
                    <label for="roles">Rol</label>
                    <select name="roles" id="roles">
                        <option value="cliente" {{ old('roles') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="proveedor" {{ old('roles') == 'proveedor' ? 'selected' : '' }}>Proveedor</option>
                    </select>
                </div>

                <div style="display:flex;gap:.6rem;align-items:center;justify-content:space-between;margin-top:1rem;">
                    <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
                    <a href="{{ route('registrar') }}" class="btn btn-ghost">Regístrate</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>