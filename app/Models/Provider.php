<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'user_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con disponibilidades
    public function disponibilidades() {
        return $this->hasMany(Disponibilidad::class, 'user_id', 'user_id');
    }
}
