<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['availability', 'horarios_disponibilidad'];

        foreach ($tables as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            // If the table has a day_of_week column, add a date column and drop day_of_week
            if (Schema::hasColumn($table, 'day_of_week')) {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    // add new date column (nullable to avoid breaking existing rows)
                    if (! Schema::hasColumn($table, 'date')) {
                        $t->date('date')->nullable()->after('day_of_week');
                    }
                });

                // NOTE: We are not attempting to convert day_of_week integer values into concrete dates,
                // because mapping depends on context (which week). If you want to preserve a best-effort
                // mapping (e.g., next date matching the weekday), tell me and I can implement it.

                Schema::table($table, function (Blueprint $t) {
                    if (Schema::hasColumn($t->getTable(), 'day_of_week')) {
                        $t->dropColumn('day_of_week');
                    }
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['availability', 'horarios_disponibilidad'];

        foreach ($tables as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            // restore day_of_week (nullable integer) and drop date
            if (Schema::hasColumn($table, 'date')) {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    if (! Schema::hasColumn($table, 'day_of_week')) {
                        $t->tinyInteger('day_of_week')->nullable()->after('date');
                    }
                });

                Schema::table($table, function (Blueprint $t) {
                    if (Schema::hasColumn($t->getTable(), 'date')) {
                        $t->dropColumn('date');
                    }
                });
            }
        }
    }
};
