<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - FlexReserve</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="panel" style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding-top:2rem;padding-bottom:2rem;">
        <div class="card" style="max-width:720px;width:100%;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div>
                    <div class="app-title">FlexReserve</div>
                    <div class="muted">Registro de usuario</div>
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

            <form action="{{ route('registrar.submit') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="nombre">Nombre*</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>

                        <label for="correo" class="mt-1">Correo*</label>
                        <input type="email" name="correo" id="correo" value="{{ old('correo') }}" required>

                        <label for="contraseña" class="mt-1">Contraseña*</label>
                        <input type="password" name="contraseña" id="contraseña" required>
                    </div>

                    <div class="col">
                        <label for="telefono">Teléfono*</label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" required>

                        <label for="direccion" class="mt-1">Dirección*</label>
                        <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" required>

                        <label for="roles" class="mt-1">Rol</label>
                        <select name="roles" id="roles">
                            <option value="cliente" {{ old('roles') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="proveedor" {{ old('roles') == 'proveedor' ? 'selected' : '' }}>Proveedor</option>
                        </select>
                    </div>
                </div>

                <div id="proveedor_fields" style="display: none; margin-top:1rem;">
                    <label for="descripcion_proveedor">Descripción*</label>
                    <textarea name="descripcion_proveedor" id="descripcion_proveedor">{{ old('descripcion_proveedor') }}</textarea>
                </div>

                <div id="cliente_fields" style="display: none; margin-top:1rem;">
                    <label for="fecha_nacimiento">Fecha de nacimiento*</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
                </div>

                <div style="display:flex;gap:.6rem;align-items:center;justify-content:space-between;margin-top:1rem;">
                    <input type="submit" class="btn btn-primary" value="Registrarse">
                    <a href="{{ route('iniciarSesion') }}" class="btn btn-ghost">Inicia sesión</a>
                </div>
            </form>

            <script>
                const rolesSelect = document.getElementById('roles');
                const proveedorFields = document.getElementById('proveedor_fields');
                const clienteFields = document.getElementById('cliente_fields');

                function toggleFields() {
                    const val = rolesSelect.value;
                    const desc = document.getElementById('descripcion_proveedor');
                    const birth = document.getElementById('fecha_nacimiento');
                    if (val === 'proveedor') {
                        proveedorFields.style.display = 'block';
                        clienteFields.style.display = 'none';
                        if (desc) desc.disabled = false;
                        if (birth) { birth.disabled = true; birth.required = false; }
                    } else if (val === 'cliente') {
                        proveedorFields.style.display = 'none';
                        clienteFields.style.display = 'block';
                        if (desc) desc.disabled = true;
                        if (birth) { birth.disabled = false; birth.required = true; }
                    } else {
                        proveedorFields.style.display = 'none';
                        clienteFields.style.display = 'none';
                        if (desc) desc.disabled = true;
                        if (birth) { birth.disabled = true; birth.required = false; }
                    }
                }

                rolesSelect.addEventListener('change', toggleFields);
                // inicializar
                toggleFields();
            </script>
        </div>
    </div>
</body>
</html>