<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Disponibilidad</title>
</head>
<body>
    <h1>Mi Disponibilidad</h1>
    <form action="{{ route('MiDisponibilidad.guardar') }}" method="POST">
        @csrf
        <label for="fecha">Fecha: </label>
        <input type="date" id="fecha" name="fecha"> 
        <br><br>
        <label for="horaInicio">Hora Inicio: </label>
        <input type="time" id="horaInicio" name="horaInicio" min="0" max="23">
        <br><br>
        <label for="horaFin">Hora Fin: </label>
        <input type="time" id="horaFin" name="horaFin" min="0" max="23">
        <br><br>
        <button>Registrar Horario</button>
    </form>

    @if($disponibildiades->isEmpty())
        <p>No has registrado horarios de disponibilidad aún.</p>
    @else
        @foreach($disponibildiades as $fecha => $bloques)
            <div>
                <h3>{{ $fecha }}</h3>
                @foreach($bloques as $bloque)
                    <div>
                        {{$bloque->hora_inicio}} - {{$bloque->hora_fin}}
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</body>
</html>