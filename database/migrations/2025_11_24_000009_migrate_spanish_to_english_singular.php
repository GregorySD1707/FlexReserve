<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PROVIDER: create new 'provider' table and copy data from 'proveedores' if exists
        if (! Schema::hasTable('provider')) {
            Schema::create('provider', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->unique()->index();
                $table->string('company_name')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });

            if (Schema::hasTable('proveedores')) {
                $rows = DB::table('proveedores')->get();
                foreach ($rows as $r) {
                    DB::table('provider')->insert([
                        'id' => $r->id,
                        'user_id' => $r->user_id,
                        'company_name' => property_exists($r, 'nombre_empresa') ? $r->nombre_empresa : null,
                        'description' => property_exists($r, 'descripcion') ? $r->descripcion : null,
                        'created_at' => property_exists($r, 'created_at') ? $r->created_at : now(),
                        'updated_at' => property_exists($r, 'updated_at') ? $r->updated_at : now(),
                    ]);
                }

                Schema::dropIfExists('proveedores');
            }
        }

        // CLIENT: create new 'client' table and copy data from 'clientes' if exists
        if (! Schema::hasTable('client')) {
            Schema::create('client', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->unique()->index();
                $table->date('birth_date')->nullable();
                $table->timestamps();
            });

            if (Schema::hasTable('clientes')) {
                $rows = DB::table('clientes')->get();
                foreach ($rows as $r) {
                    DB::table('client')->insert([
                        'id' => $r->id,
                        'user_id' => $r->user_id,
                        'birth_date' => property_exists($r, 'fecha_nacimiento') ? $r->fecha_nacimiento : null,
                        'created_at' => property_exists($r, 'created_at') ? $r->created_at : now(),
                        'updated_at' => property_exists($r, 'updated_at') ? $r->updated_at : now(),
                    ]);
                }

                Schema::dropIfExists('clientes');
            }
        }

        // CATEGORY: create new 'category' table and copy data from 'categorias' if exists
        if (! Schema::hasTable('category')) {
            Schema::create('category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });

            if (Schema::hasTable('categorias')) {
                $rows = DB::table('categorias')->get();
                foreach ($rows as $r) {
                    DB::table('category')->insert([
                        'id' => $r->id,
                        'name' => property_exists($r, 'nombre') ? $r->nombre : null,
                        'description' => property_exists($r, 'descripcion') ? $r->descripcion : null,
                        'created_at' => property_exists($r, 'created_at') ? $r->created_at : now(),
                        'updated_at' => property_exists($r, 'updated_at') ? $r->updated_at : now(),
                    ]);
                }

                Schema::dropIfExists('categorias');
            }
        }

        // SERVICE: create new 'service' table and copy data from 'servicios' if exists
        if (! Schema::hasTable('service')) {
            Schema::create('service', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('provider_id')->nullable()->index();
                $table->unsignedBigInteger('category_id')->nullable()->index();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->integer('duration')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });

            if (Schema::hasTable('servicios')) {
                $rows = DB::table('servicios')->get();
                foreach ($rows as $r) {
                    DB::table('service')->insert([
                        'id' => $r->id,
                        'provider_id' => property_exists($r, 'proveedor_id') ? $r->proveedor_id : null,
                        'category_id' => property_exists($r, 'categoria_id') ? $r->categoria_id : null,
                        'name' => property_exists($r, 'nombre') ? $r->nombre : null,
                        'description' => property_exists($r, 'descripcion') ? $r->descripcion : null,
                        'price' => property_exists($r, 'precio') ? $r->precio : 0,
                        'duration' => property_exists($r, 'duracion') ? $r->duracion : null,
                        'active' => property_exists($r, 'activo') ? $r->activo : true,
                        'created_at' => property_exists($r, 'created_at') ? $r->created_at : now(),
                        'updated_at' => property_exists($r, 'updated_at') ? $r->updated_at : now(),
                    ]);
                }

                Schema::dropIfExists('servicios');
            }
        }
    }

    public function down(): void
    {
        // For rollback, recreate original spanish tables and copy data back
        if (! Schema::hasTable('proveedores') && Schema::hasTable('provider')) {
            Schema::create('proveedores', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->unique()->index();
                $table->string('nombre_empresa')->nullable();
                $table->text('descripcion')->nullable();
                $table->timestamps();
            });
            $rows = DB::table('provider')->get();
            foreach ($rows as $r) {
                DB::table('proveedores')->insert([
                    'id' => $r->id,
                    'user_id' => $r->user_id,
                    'nombre_empresa' => $r->company_name,
                    'descripcion' => $r->description,
                    'created_at' => $r->created_at ?? now(),
                    'updated_at' => $r->updated_at ?? now(),
                ]);
            }
            Schema::dropIfExists('provider');
        }

        if (! Schema::hasTable('clientes') && Schema::hasTable('client')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->unique()->index();
                $table->date('fecha_nacimiento')->nullable();
                $table->timestamps();
            });
            $rows = DB::table('client')->get();
            foreach ($rows as $r) {
                DB::table('clientes')->insert([
                    'id' => $r->id,
                    'user_id' => $r->user_id,
                    'fecha_nacimiento' => $r->birth_date,
                    'created_at' => $r->created_at ?? now(),
                    'updated_at' => $r->updated_at ?? now(),
                ]);
            }
            Schema::dropIfExists('client');
        }

        if (! Schema::hasTable('categorias') && Schema::hasTable('category')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre')->nullable(false);
                $table->text('descripcion')->nullable();
                $table->timestamps();
            });
            $rows = DB::table('category')->get();
            foreach ($rows as $r) {
                DB::table('categorias')->insert([
                    'id' => $r->id,
                    'nombre' => $r->name,
                    'descripcion' => $r->description,
                    'created_at' => $r->created_at ?? now(),
                    'updated_at' => $r->updated_at ?? now(),
                ]);
            }
            Schema::dropIfExists('category');
        }

        if (! Schema::hasTable('servicios') && Schema::hasTable('service')) {
            Schema::create('servicios', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('proveedor_id')->nullable()->index();
                $table->unsignedBigInteger('categoria_id')->nullable()->index();
                $table->string('nombre');
                $table->text('descripcion')->nullable();
                $table->decimal('precio', 10, 2)->default(0);
                $table->integer('duracion')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
            $rows = DB::table('service')->get();
            foreach ($rows as $r) {
                DB::table('servicios')->insert([
                    'id' => $r->id,
                    'proveedor_id' => $r->provider_id,
                    'categoria_id' => $r->category_id,
                    'nombre' => $r->name,
                    'descripcion' => $r->description,
                    'precio' => $r->price,
                    'duracion' => $r->duration,
                    'activo' => $r->active,
                    'created_at' => $r->created_at ?? now(),
                    'updated_at' => $r->updated_at ?? now(),
                ]);
            }
            Schema::dropIfExists('service');
        }
    }
};
