<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - FlexReserve</title>
</head>
<body>
    <h1>FlexReserve</h1>
    <h2>Registro</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('registrar.submit') }}" method="POST">

        @csrf
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"> <br>
        <br>
        <label for="apellido">Apellido: </label>
        <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}"> <br>
        <br>
        <label for="email">Correo: </label>
        <input type="email" name="correo" id="correo" value="{{ old('correo') }}"> <br>
        <br>
        <label for="contraseña">Contraseña: </label>
        <input type="password" name="contraseña" id="contraseña"> <br>
        <br>
        <label for="FechaDeNacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fechaDeNacimiento" id="fechaDeNacimiento"> <br>
        <br>
        <label for="rol">Rol: </label>
        <select name="roles" id="roles">
            <option value="cliente">Cliente</option>
            <option value="proveedor">Proveedor</option>
        </select> <br>
        <br>
        <input type="submit" value="Registrarse">
    </form>

    <a href="{{ route('iniciarSesion') }}">Inicia sesión</a>
</body>
</html>