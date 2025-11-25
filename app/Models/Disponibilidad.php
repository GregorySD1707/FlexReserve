<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    // Definir tabla asociada al modelo
    protected $table = 'horarios_disponibilidad';

    // Definir campos asignables masivamente
    protected $fillable = [
        'service_id',
        'user_id',
        'date',
        'start_time',
        'end_time',
        'available',
    ];

    protected $casts = [
        'date' => 'date',
        'available' => 'boolean'
    ];

    // relacion con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relacion con provider
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'user_id', 'user_id');
    }
}