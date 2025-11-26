<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlexReserve - Panel Principal</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="panel" style="padding-top:2rem;padding-bottom:2rem;">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card" style="margin-bottom:1rem;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div class="app-title">FlexReserve</div>
                    <div class="muted">Panel Principal</div>
                </div>
                <div class="muted">Bienvenido, <strong>{{ Auth::user()->name }}</strong></div>
            </div>
            

            <div class="card" style="margin-bottom:1rem;">
                <p class="muted">Tu rol: <strong>{{ Auth::user()->getRoleNames()->first() }}</strong></p>

                @if(Auth::check() && Auth::user()->getRoleNames()->first() === 'proveedor')
                    <div style="margin-top:0.75rem;">
                        <h3 style="margin:0 0 .5rem;">Panel de Proveedor</h3>
                        <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                            @if(Route::has('MiDisponibilidad.mostrar'))
                                <a href="{{ route('MiDisponibilidad.mostrar') }}" class="btn btn-accent">Mi Disponibilidad</a>
                            @else
                                <a href="{{ url('/MiDisponibilidad') }}" class="btn btn-accent">Mi Disponibilidad</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div style="display:flex;gap:.75rem;align-items:center">
                <form action="{{ route('logout') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="btn btn-ghost">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
