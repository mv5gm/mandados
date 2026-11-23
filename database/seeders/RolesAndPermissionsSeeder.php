<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // Usuarios y roles (admin legado)
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',

            // Mod. Conductores
            'drivers.view',
            'drivers.create',
            'drivers.update',
            'drivers.delete',
            'drivers.approve',
            'drivers.suspend',
            'drivers.payout',

            // Mod. Clientes
            'orders.view',
            'orders.create',
            'orders.update',
            'orders.delete',
            'orders.validate',
            'orders.assign',

            // Pagos
            'payments.view',
            'payments.verify',
            'payments.reject',
            'payments.refund',

            // Billeteras
            'wallets.view',
            'wallets.adjust',
            'wallets.payout',

            // Logística: asignación y lotes
            'batches.view',
            'batches.assign',

            // Administración y parámetros
            'settings.view',
            'settings.update',
            'exchange_rates.view',
            'exchange_rates.create',

            // Reportes y calificaciones
            'reports.view',
            'reports.export',
            'ratings.view',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $adminRole = Role::findOrCreate('admin', 'web');
        $adminRole->syncPermissions($permissions);

        // Rol básico de sistema (se mantiene para compatibilidad con auth legada)
        $userRole = Role::findOrCreate('user', 'web');
        $userRole->syncPermissions([]);

        // Perfiles del nuevo documento tecnico
        $clientRole = Role::findOrCreate('client', 'web');
        $clientRole->syncPermissions([
            'orders.view',
            'orders.create',
            'orders.update',
            'orders.delete',
            'payments.view',
            'payments.view',
        ]);

        $driverRole = Role::findOrCreate('driver', 'web');
        $driverRole->syncPermissions([
            'orders.view',
            'orders.update',
            'payments.view',
            'wallets.view',
            'batches.view',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
