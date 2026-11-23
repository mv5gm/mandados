<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderBatch;
use App\Models\OrderRating;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoOrdersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $client = User::firstWhere('email', 'cliente@example.com') ?? User::first();
        $driver = Driver::firstWhere('placa', 'V-12345') ?? Driver::first();
        $rate = 41.00;

        $recibido = Order::updateOrCreate(
            ['code' => 'MND-000001'],
            [
                'cliente_id' => $client->id,
                'tracking_mrw' => 'TRK-261111-0001',
                'remitente' => 'Tienda Cashea',
                'rango_peso' => Order::WEIGHT_UNDER_2,
                'tipo_paquete' => Order::PACKAGE_ENVELOPE,
                'tipo_servicio' => Order::SERVICE_TYPE_STANDARD,
                'estado' => Order::STATUS_RECEIVED,
                'sector_entrega' => 'Sector 4, Carúpano',
                'calle_entrega' => 'Avenida Libertad, Edificio Los Pinos, PB',
                'referencia_entrega' => 'Cerca del campo de fútbol principal',
                'lat_entrega' => 10.0815,
                'lon_entrega' => -63.2589,
                'fecha_recogida_agendada' => now()->addDay()->toDateString(),
                'pin_entrega' => '4512',
                'aceptacion_terminos_el' => now(),
                'tarifa_base_usd' => 3.50,
                'total_usd' => 3.50,
                'tasa_cambio' => $rate,
                'total_ves' => 3.50 * $rate,
                'metodo_pago' => Order::PAYMENT_CASH_USD,
                'estado_pago' => Order::PAYMENT_PENDING,
                'comision_plataforma_porc' => 25,
                'comision_conductor_porc' => 75,
                'ganancia_conductor_usd' => 0,
                'ganancia_plataforma_usd' => 0,
            ],
        );

        Payment::updateOrCreate(
            ['pedido_id' => $recibido->id, 'metodo' => Order::PAYMENT_CASH_USD],
            [
                'moneda' => 'USD',
                'monto' => 3.50,
                'monto_usd' => 3.50,
                'referencia' => 'PYM-000001',
                'estado' => Payment::ESTADO_PENDIENTE,
            ],
        );

        $lote = OrderBatch::updateOrCreate(
            ['code' => 'BATCH-STAN1'],
            [
                'conductor_id' => $driver->id,
                'tipo_servicio' => Order::SERVICE_TYPE_STANDARD,
                'estado' => OrderBatch::ESTADO_ASIGNADO,
                'fecha_agendada' => now()->addDay()->toDateString(),
                'asignado_el' => now(),
            ],
        );

        $asignado = Order::updateOrCreate(
            ['code' => 'MND-000002'],
            [
                'cliente_id' => $client->id,
                'conductor_id' => $driver->id,
                'lote_id' => $lote->id,
                'tracking_mrw' => 'TRK-261111-0002',
                'remitente' => 'Ventas Sur',
                'rango_peso' => Order::WEIGHT_2_5,
                'tipo_paquete' => Order::PACKAGE_MEDIUM_BOX,
                'tipo_servicio' => Order::SERVICE_TYPE_STANDARD,
                'estado' => Order::STATUS_ASSIGNED,
                'sector_entrega' => 'Sector 6, Yaguaraparo',
                'calle_entrega' => 'Avenida Miranda',
                'referencia_entrega' => 'Cerca del Aeropuerto',
                'lat_entrega' => 10.1345,
                'lon_entrega' => -63.1678,
                'fecha_recogida_agendada' => now()->toDateString(),
                'pin_entrega' => '8765',
                'aceptacion_terminos_el' => now(),
                'tarifa_base_usd' => 3.50,
                'total_usd' => 3.50,
                'tasa_cambio' => $rate,
                'total_ves' => 3.50 * $rate,
                'metodo_pago' => Order::PAYMENT_CASH_VES,
                'estado_pago' => Payment::ESTADO_PENDIENTE,
                'comision_plataforma_porc' => 25,
                'comision_conductor_porc' => 75,
                'asignado_el' => now(),
            ],
        );

        $entregado = Order::updateOrCreate(
            ['code' => 'MND-000003'],
            [
                'cliente_id' => $client->id,
                'conductor_id' => $driver->id,
                'tracking_mrw' => 'TRK-261111-0003',
                'remitente' => 'Empresa ExpressZ',
                'rango_peso' => Order::WEIGHT_UNDER_2,
                'tipo_paquete' => Order::PACKAGE_ENVELOPE,
                'tipo_servicio' => Order::SERVICE_TYPE_EXPRESS,
                'estado' => Order::STATUS_DELIVERED,
                'sector_entrega' => 'Sector 7, Yaguaraparo',
                'calle_entrega' => 'Calle Libertad',
                'referencia_entrega' => 'BloqueRO01, PB',
                'lat_entrega' => 10.1099,
                'lon_entrega' => -63.1941,
                'aceptacion_terminos_el' => now(),
                'tarifa_base_usd' => 10.00,
                'total_usd' => 10.00,
                'tasa_cambio' => $rate,
                'total_ves' => 10.00 * $rate,
                'metodo_pago' => Order::PAYMENT_CASH_VES,
                'estado_pago' => Payment::ESTADO_PENDIENTE,
                'comision_plataforma_porc' => 25,
                'comision_conductor_porc' => 75,
                'entregado_el' => now(),
            ],
        );

        Payment::updateOrCreate(
            ['pedido_id' => $entregado->id, 'metodo' => Order::PAYMENT_CASH_VES],
            [
                'moneda' => 'VES',
                'monto' => 206.00,
                'tasa' => $rate,
                'monto_usd' => 10.00,
                'referencia' => 'PYM-000003',
                'estado' => Payment::ESTADO_PENDIENTE,
            ],
        );

        OrderRating::updateOrCreate(
            ['pedido_id' => $entregado->id],
            [
                'cliente_id' => $client->id,
                'conductor_id' => $driver->id,
                'puntuacion' => 5,
                'comentario' => 'Paquete llegó bien y a tiempo.',
            ],
        );
    }
}
