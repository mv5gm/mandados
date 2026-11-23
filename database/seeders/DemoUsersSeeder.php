<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\DriverDocument;
use App\Models\DriverWallet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DemoUsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $admin->syncRoles([Role::findByName('admin', 'web')]);

        $demo = User::updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Usuario Demo',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $demo->syncRoles([Role::findByName('user', 'web')]);

        $client = User::updateOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'María Gómez',
                'cedula' => '16443212',
                'phone' => '+58 414-234-5678',
                'phone_verified_at' => now(),
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $client->syncRoles([Role::findByName('client', 'web')]);
        $client->addresses()->updateOrCreate(
            ['tipo' => 'Principal'],
            [
                'sector' => 'Sector 4, Carúpano',
                'calle' => 'Avenida Libertad, Edificio Los Pinos, PB',
                'referencia' => 'Cerca del campo de fútbol principal',
                'lat' => 10.0815,
                'lon' => -63.2589,
                'predeterminada' => true,
            ],
        );

        $driverUser = User::updateOrCreate(
            ['email' => 'motorizado@example.com'],
            [
                'name' => 'José Martínez',
                'cedula' => '23056789',
                'birth_date' => now()->subYears(32)->toDateString(),
                'phone' => '+58 414-987-6543',
                'phone_verified_at' => now(),
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $driverUser->syncRoles([Role::findByName('driver', 'web')]);

        $driver = Driver::updateOrCreate(
            ['usuario_id' => $driverUser->id],
            [
                'direccion' => 'Sector 6, Yaguaraparo',
                'nombre_contacto_emergencia' => 'Ana Rodríguez',
                'telefono_contacto_emergencia' => '+58 416-555-1212',
                'marca' => 'Toyota',
                'modelo' => 'Boxer',
                'anio' => 2018,
                'color' => 'Blanco',
                'placa' => 'V-12345',
                'estatus' => Driver::ESTATUS_APROBADO,
                'aprobado_el' => now()->subDays(2),
                'disponible' => true,
                'calificacion_promedio' => 4.7,
                'cantidad_calificaciones' => 12,
            ],
        );

        $driver->aprobadoPor()->associate($admin)->save();

        DriverDocument::updateOrCreate(
            ['conductor_id' => $driver->id, 'tipo' => DriverDocument::TIPO_CEDULA_FRENTE],
            ['path' => 'documentos/cedula-frente.jpg', 'estado' => DriverDocument::ESTADO_APROBADO],
        );
        DriverDocument::updateOrCreate(
            ['conductor_id' => $driver->id, 'tipo' => DriverDocument::TIPO_LICENCIA],
            ['path' => 'documentos/licencia.jpg', 'estado' => DriverDocument::ESTADO_APROBADO],
        );
        DriverDocument::updateOrCreate(
            ['conductor_id' => $driver->id, 'tipo' => DriverDocument::TIPO_CERTIFICADO_MEDICO],
            ['path' => 'documentos/certificado-medico.jpg', 'estado' => DriverDocument::ESTADO_APROBADO],
        );
        DriverDocument::updateOrCreate(
            ['conductor_id' => $driver->id, 'tipo' => DriverDocument::TIPO_CARNET_CIRCULACION],
            ['path' => 'documentos/carnet-circulacion.jpg', 'estado' => DriverDocument::ESTADO_APROBADO],
        );
        DriverDocument::updateOrCreate(
            ['conductor_id' => $driver->id, 'tipo' => DriverDocument::TIPO_MOTO_ACTUAL],
            ['path' => 'documentos/moto-actual.jpg', 'estado' => DriverDocument::ESTADO_APROBADO],
        );
        DriverDocument::updateOrCreate(
            ['conductor_id' => $driver->id, 'tipo' => DriverDocument::TIPO_SELFIE],
            ['path' => 'documentos/selfie-cedula.jpg', 'estado' => DriverDocument::ESTADO_APROBADO],
        );

        DriverWallet::updateOrCreate(
            ['conductor_id' => $driver->id],
            [
                'saldo_a_favor' => 145.50,
                'saldo_prepayado' => 50.00,
                'total_entregado' => 800.00,
                'total_pagado' => 200.00,
            ],
        );
    }
}
