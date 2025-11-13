<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create roles (verify if they exist first)
        $roleCliente = Role::firstOrCreate(['name' => 'cliente', 'guard_name' => 'web']);
        $roleProveedor = Role::firstOrCreate(['name' => 'proveedor', 'guard_name' => 'web']);
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Create permissions
        $permissions = [
            // Cliente permissions
            'crear_reserva' => 'Cliente puede crear una reserva',
            'ver_mis_reservas' => 'Cliente puede ver sus reservas',
            'cancelar_reserva' => 'Cliente puede cancelar una reserva',
            
            // Proveedor permissions
            'crear_espacio' => 'Proveedor puede crear espacio',
            'ver_espacios' => 'Proveedor puede ver sus espacios',
            'editar_espacio' => 'Proveedor puede editar espacio',
            'ver_reservas_espacio' => 'Proveedor puede ver reservas de su espacio',
            
            // Admin permissions
            'gestionar_usuarios' => 'Admin puede gestionar usuarios',
            'ver_reportes' => 'Admin puede ver reportes',
            'gestionar_roles' => 'Admin puede gestionar roles',
        ];

        foreach ($permissions as $permission => $description) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Assign permissions to roles
        $roleCliente->givePermissionTo(['crear_reserva', 'ver_mis_reservas', 'cancelar_reserva']);
        $roleProveedor->givePermissionTo(['crear_espacio', 'ver_espacios', 'editar_espacio', 'ver_reservas_espacio']);
        $roleAdmin->givePermissionTo(Permission::all());
    }
}
