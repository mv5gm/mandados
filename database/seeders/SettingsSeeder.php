<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaults = [
            'tarifa_estandar_usd' => ['3.50', 'decimal'],
            'tarifa_estandar_ves' => ['5.00', 'decimal'],
            'tarifa_express_usd' => ['10.00', 'decimal'],
            'comision_plataforma_porc' => ['25', 'decimal'],
            'comision_conductor_porc' => ['75', 'decimal'],
            'porc_recargo_seguro_ampliado' => ['5', 'decimal'],
            'tarifa_base_seguro_usd' => ['35', 'decimal'],
            'peso_maximo_kg' => ['10', 'integer'],
            'hora_corte_estandar' => ['19:00', 'time'],
            'hora_corte_express' => ['13:00', 'time'],
            'paquetes_maximos_por_lote' => ['8', 'integer'],
        ];

        foreach ($defaults as $clave => [$valor, $tipo]) {
            Setting::updateOrCreate(
                ['clave' => $clave],
                ['valor' => $valor, 'tipo' => $tipo, 'grupo' => 'pricing', 'etiqueta' => $clave],
            );
        }

        ExchangeRate::updateOrCreate(
            ['moneda' => 'USD', 'fecha_efectiva' => now()->startOfDay()],
            ['tasa' => 41.00, 'activo' => true],
        );
    }
}
