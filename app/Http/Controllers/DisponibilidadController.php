<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disponibilidad;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider;

class DisponibilidadController extends Controller
{
    // Mostrar vista con disponibilidades existentes
    public function mostrarDisponibilidad()
    {
        if (!Auth::user()->hasRole('proveedor')) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        // Obtener todas las disponibilidades del proveedor autenticado
        $disponibilidades = Disponibilidad::where('user_id', Auth::id())
            ->orderBy('date') 
            ->orderBy('start_time')
            ->get()
            ->groupBy('date');  // Agrupar por fecha
        
        return view('VistaMiDisponibilidad', compact('disponibilidades'));
    }

    public function guardarDisponibilidad(Request $request)
    {
        if (!Auth::user()->hasRole('proveedor')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        // validación
        $informacionValidada = $request->validate([
            'date' => [
                'required',
                'date',
                'after_or_equal:today' // La fecha no puede ser en el pasado
            ],
            'start_time' => [
                'required',
                'date_format:H:i' // Formato de hora 24 horas
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time' // La hora de fin debe ser después de la hora de inicio
            ]
        ], [
            // Mensajes de error personalizados
            'date.required' => 'La fecha es obligatoria.',
            'date.after_or_equal' => 'La fecha no puede ser en el pasado.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'end_time.required' => 'La hora de fin es obligatoria.',
            'end_time.after' => 'La hora de fin debe ser después de la hora de inicio.'
        ]);

        // Verificar solapamientos
        $solapamiento = Disponibilidad::where('user_id', Auth::id())
            ->where('date', $informacionValidada['date'])
            ->where(function ($query) use ($informacionValidada) {
                $query->whereBetween('start_time', [$informacionValidada['start_time'], $informacionValidada['end_time']])
                      ->orWhereBetween('end_time', [$informacionValidada['start_time'], $informacionValidada['end_time']])
                      ->orWhere(function ($q) use ($informacionValidada) {
                          $q->where('start_time', '<=', $informacionValidada['start_time'])
                            ->where('end_time', '>=', $informacionValidada['end_time']);
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
            'date' => $informacionValidada['date'],
            'start_time' => $informacionValidada['start_time'],
            'end_time' => $informacionValidada['end_time'],
        ]);

        return redirect()
            ->route('MiDisponibilidad.mostrar')
            ->with('success', 'Disponibilidad guardada correctamente.');
    }
}