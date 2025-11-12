<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - FlexReserve</title>
</head>
<body>
    <!--
    <h1>Bienvenido, {{ Auth::user()->nombre ?? 'Invitado' }}</h1>
    -->
    <h1>FlexReserve</h1>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
    
</body>
</html>