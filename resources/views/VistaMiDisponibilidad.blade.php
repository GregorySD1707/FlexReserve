<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Disponibilidad</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="panel" style="padding-top:2rem;padding-bottom:2rem;">
        <div class="container">
            <div class="card" style="margin-bottom:1rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div class="app-title">Mi Disponibilidad</div>
                        <div class="muted">Registra tus horarios disponibles</div>
                    </div>
                    <div>
                        <button onclick="window.history.back()" class="btn btn-ghost">Volver</button>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mt-1">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error mt-1">
                        <ul style="margin:0;padding-left:1.1rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('MiDisponibilidad.guardar') }}" method="POST" style="margin-top:1rem;">
                    @csrf
                    <div class="form-row">
                        <div>
                            <label for="date">Fecha</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div>
                            <label for="start_time">Hora Inicio</label>
                            <input type="time" id="start_time" name="start_time" required>
                        </div>
                        <div>
                            <label for="end_time">Hora Fin</label>
                            <input type="time" id="end_time" name="end_time" required>
                        </div>
                    </div>
                    <div style="margin-top:1rem;">
                        <button class="btn btn-primary" type="submit">Registrar Horario</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <h3 style="margin-top:0">Horarios Registrados</h3>
                @if($disponibilidades->isEmpty())
                    <p class="muted">No has registrado horarios de disponibilidad aún.</p>
                @else
                    <div style="display:flex;flex-direction:column;gap:.75rem">
                        @foreach($disponibilidades as $date => $bloques)
                            <div class="card" style="background:#fbfeff;">
                                <div style="display:flex;align-items:center;justify-content:space-between;">
                                    <strong>{{ \Illuminate\Support\Carbon::parse($date)->toDateString() }}</strong>
                                </div>
                                <ul class="list" style="margin-top:.5rem;">
                                    @foreach($bloques as $bloque)
                                        <li>{{ $bloque->start_time }} - {{ $bloque->end_time }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>