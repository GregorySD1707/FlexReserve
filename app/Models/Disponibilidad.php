<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    // Define the table associated with the model (if not following Laravel's naming convention)
    protected $table = 'horarios_disponibilidad';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        // Add other relevant fields
    ];

    protected $casts = [
        'fehca' => 'date'
    ];

    // relacion con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}