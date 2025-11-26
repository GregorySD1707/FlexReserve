<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Disponibilidad</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Mi Disponibilidad</h1>

    {{--Mensaje de éxito --}}
    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    {{-- Errores generales --}}
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('MiDisponibilidad.guardar') }}" method="POST">
        @csrf
        <label for="date">Fecha: </label>
        <input type="date" id="date" name="date"> 
        <br><br>
        <label for="start_time">Hora Inicio: </label>
        <input type="time" id="start_time" name="start_time" min="0" max="23">
        <br><br>
        <label for="end_time">Hora Fin: </label>
        <input type="time" id="end_time" name="end_time" min="0" max="23">
        <br><br>
        <button>Registrar Horario</button>
    </form> <br>
    <button onclick="window.history.back()">Volver</button>
    <br>
    
    <hr>

    <h2>Horarios Registrados:</h2>
    
    @if($disponibilidades->isEmpty())
        <p>No has registrado horarios de disponibilidad aún.</p>
    @else
        @foreach($disponibilidades as $date => $bloques)
            <div>
                <h3>{{ \Illuminate\Support\Carbon::parse($date)->toDateString() }}</h3>
                @foreach($bloques as $bloque)
                    <div>
                        <ul>
                            <li>{{$bloque->start_time}} - {{$bloque->end_time}}</li>
                        </ul>            
                    </div>
                @endforeach
                <br>
            </div>
        @endforeach
    @endif
</body>
</html>