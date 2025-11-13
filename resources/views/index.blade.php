<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlexReserve - Panel Principal</title>
</head>
<body>
    <h1>FlexReserve</h1>
    <h2>Panel Principal</h2>

    @if(session('success'))
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <p>Bienvenido, {{ Auth::user()->name }}!</p>
    <p>Tu rol: {{ Auth::user()->getRoleNames()->first() }}</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
</body>
</html>
