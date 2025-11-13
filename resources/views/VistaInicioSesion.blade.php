<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - FlexReserve</title>
</head>
<body>
    <h1>FlexReserve</h1>
    <h2>Inicio de Sesión</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('iniciarSesion.submit') }}" method="POST">

        @csrf
        <label for="email">Correo: </label>
        <input type="email" name="correo" id="correo" value="{{ old('correo') }}"> <br>
        <br>
        <label for="contraseña">Contraseña: </label>
        <input type="password" name="contraseña" id="contraseña"> <br>
        <br>
        <label for="roles">Rol: </label>
        <select name="roles" id="roles">
            <option value="cliente" {{ old('roles') == 'cliente' ? 'selected' : '' }}>Cliente</option>
            <option value="proveedor" {{ old('roles') == 'proveedor' ? 'selected' : '' }}>Proveedor</option>
        </select> <br>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>

    <a href="{{ route('registrar') }}">Regístrate</a>

</body>
</html>