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
        <label for="nombre">Nombre*: </label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"> <br>
        <br>
        <!-- Username removed: using email as unique identifier -->
        <label for="correo">Correo*: </label>
        <input type="email" name="correo" id="correo" value="{{ old('correo') }}"> <br>
        <br>
        <label for="contraseña">Contraseña*: </label>
        <input type="password" name="contraseña" id="contraseña"> <br>
        <br>
        <label for="telefono">Teléfono*: </label>
        <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"> <br>
        <br>
        <label for="direccion">Dirección*: </label>
        <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"> <br>
        <br>
        <div id="proveedor_fields" style="display: none;">
            <label for="descripcion_proveedor">Descripción (obligatoria): </label>
            <textarea name="descripcion_proveedor" id="descripcion_proveedor" required>{{ old('descripcion_proveedor') }}</textarea>
            <br><br>
        </div>

        <div id="cliente_fields" style="display: none;">
            <label for="fecha_nacimiento">Fecha de nacimiento*: </label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"> <br><br>
        </div>
        <br>
        <label for="roles">Rol: </label>
        <select name="roles" id="roles">
            <option value="cliente" {{ old('roles') == 'cliente' ? 'selected' : '' }}>Cliente</option>
            <option value="proveedor" {{ old('roles') == 'proveedor' ? 'selected' : '' }}>Proveedor</option>
        </select>
        <br><br>
        <input type="submit" value="Registrarse">
    </form>

    <script>
        const rolesSelect = document.getElementById('roles');
        const proveedorFields = document.getElementById('proveedor_fields');
        const clienteFields = document.getElementById('cliente_fields');

        function toggleFields() {
            const val = rolesSelect.value;
            if (val === 'proveedor') {
                proveedorFields.style.display = 'block';
                clienteFields.style.display = 'none';
            } else if (val === 'cliente') {
                proveedorFields.style.display = 'none';
                clienteFields.style.display = 'block';
            } else {
                proveedorFields.style.display = 'none';
                clienteFields.style.display = 'none';
            }
        }

        rolesSelect.addEventListener('change', toggleFields);
        // inicializar según valor actual
        toggleFields();
    </script>

    <a href="{{ route('iniciarSesion') }}">Inicia sesión</a>
</body>
</html>