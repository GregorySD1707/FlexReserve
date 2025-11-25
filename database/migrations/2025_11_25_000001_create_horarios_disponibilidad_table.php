<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    // Este método crea la tabla horarios_disponibilidad
    public function up()
    {
        Schema::create('horarios_disponibilidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('available')->default(true);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    // Este método elimina la tabla horarios_disponibilidad, se utiliza para revertir la migración
    public function down()
    {
        Schema::dropIfExists('horarios_disponibilidad');
    }
};
