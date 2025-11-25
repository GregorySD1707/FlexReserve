<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('provider') && Schema::hasColumn('provider', 'company_name')) {
            Schema::table('provider', function (Blueprint $table) {
                // drop the column if it exists
                $table->dropColumn('company_name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('provider') && ! Schema::hasColumn('provider', 'company_name')) {
            Schema::table('provider', function (Blueprint $table) {
                $table->string('company_name')->nullable()->after('user_id');
            });
        }
    }
};
