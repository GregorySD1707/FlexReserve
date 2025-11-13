# TODO: Implementación HU-01 y HU-02 para FlexReserve

## Paso 1: Modificar migración de usuarios ✅
- Agregar campos: username, telefono, direccion a la tabla users.
- Ejecutar migración.

## Paso 2: Configurar Spatie Laravel Permission ✅
- Publicar migraciones de Spatie.
- Ejecutar migraciones de roles y permisos.
- Crear roles 'cliente' y 'proveedor'.

## Paso 3: Actualizar modelo User ✅
- Agregar HasRoles trait.
- Actualizar fillable con nuevos campos.

## Paso 4: Implementar registro (HU-01) ✅
- Validación: nombre, email, password (segura), username, telefono, direccion, rol.
- Crear usuario con campos adicionales.
- Asignar rol usando Spatie.
- Mensajes de error según criterios de aceptación.

## Paso 5: Implementar login (HU-02) ✅
- Validación: email, password.
- Autenticación usando Auth::attempt.
- Redirección al panel principal.

## Paso 6: Actualizar vistas ✅
- VistaRegistro: agregar campos username, telefono, direccion.
- VistaInicioSesion: ajustar si necesario.
- Mostrar errores de validación.

## Paso 7: Configurar rutas y middleware ✅
- Proteger rutas con auth middleware.
- Ajustar rutas para redirecciones correctas.

## Paso 8: Pruebas
- Probar registro con datos válidos e inválidos.
- Probar login con credenciales correctas e incorrectas.
- Verificar asignación de roles.
