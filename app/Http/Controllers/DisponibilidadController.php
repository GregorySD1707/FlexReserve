<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disponibilidad;
use Illuminate\Support\Facades\Auth;

class DisponibilidadController extends Controller
{
    // Mostrar vista con disponibilidades existentes
    public function mostrarDisponibilidad()
    {
        // Obtener todas las disponibilidades del proveedor autenticado
        $disponibilidades = Disponibilidad::where('user_id', Auth::id())
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get()
            ->groupBy('fecha');  // Agrupar por fecha
        
        return view('provider.disponibilidad', compact('disponibilidades'));
    }

    public function guardarDisponibilidad(Request $request)
    {
        // validación
        $informacionValidada = $request->validate([
            'fecha' => [
                'required',
                'date',
                'after_or_equal:today' // La fecha no puede ser en el pasado
            ],
            'hora_inicio' => [
                'required',
                'date_format:H:i' // Formato de hora 24 horas
            ],
            'hora_fin' => [
                'required',
                'date_format:H:i',
                'after:hora_inicio' // La hora de fin debe ser después de la hora de inicio
            ]
        ], [
            // Mensajes de error personalizados
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.after_or_equal' => 'La fecha no puede ser en el pasado.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.after' => 'La hora de fin debe ser después de la hora de inicio.'
        ]);

        // Verificar solapamientos
        $solapamiento = Disponibilidad::where('user_id', Auth::id())
            ->where('fecha', $informacionValidada['fecha'])
            ->where(function ($query) use ($informacionValidada) {
                $query->whereBetween('hora_inicio', [$informacionValidada['hora_inicio'], $informacionValidada['hora_fin']])
                      ->orWhereBetween('hora_fin', [$informacionValidada['hora_inicio'], $informacionValidada['hora_fin']])
                      ->orWhere(function ($q) use ($informacionValidada) {
                          $q->where('hora_inicio', '<=', $informacionValidada['hora_inicio'])
                            ->where('hora_fin', '>=', $informacionValidada['hora_fin']);
                      });
            })
            ->exists();
        
        if ($solapamiento) {
            return back()
            ->withErrors(['solapamiento' => 'El horario proporcionado se solapa con una disponibilidad existente.'])
            ->withInput();
        }

        // Guardar disponibilidad
        Disponibilidad::create([
            'user_id' => Auth::id(),
            'fecha' => $informacionValidada['fecha'],
            'hora_inicio' => $informacionValidada['hora_inicio'],
            'hora_fin' => $informacionValidada['hora_fin'],
        ]);

        return redirect()
            ->route('provider.disponibilidad.mostrarDisponibilidad')
            ->with('success', 'Disponibilidad guardada correctamente.');
    }
}