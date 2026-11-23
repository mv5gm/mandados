<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tasa = fake()->randomFloat(4, 30, 60);

        return [
            'code' => 'MND-' . fake()->numberBetween(100000, 999999),
            'cliente_id' => User::factory(),
            'conductor_id' => null,
            'lote_id' => null,
            'tipo_servicio' => Order::SERVICE_TYPE_STANDARD,
            'estado' => Order::STATUS_RECEIVED,
            'client_uuid' => fake()->uuid(),
            'tracking_mrw' => fake()->bothify('MRW########'),
            'remitente' => fake()->name(),
            'rango_peso' => Order::WEIGHT_UNDER_2,
            'tipo_paquete' => Order::PACKAGE_ENVELOPE,
            'tipo_seguro' => Order::INSURANCE_BASIC,
            'valor_declarado_usd' => null,
            'tarifa_seguro_usd' => 0,
            'aceptacion_terminos_el' => now(),
            'sector_entrega' => fake()->randomElement(['Sector 1, Carúpano', 'Sector 4, Yaguaraparo', 'Sector 7, Yaguaraparo']),
            'calle_entrega' => fake()->streetName(),
            'referencia_entrega' => fake()->optional()->text(),
            'lat_entrega' => fake()->latitude(),
            'lon_entrega' => fake()->longitude(),
            'fecha_recogida_agendada' => today(),
            'pin_entrega' => fake()->numerify('####'),
            'foto_recogida' => null,
            'foto_entrega' => null,
            'firma_entrega' => null,
            'tarifa_base_usd' => 3.5,
            'total_usd' => 3.5,
            'tasa_cambio' => $tasa,
            'total_ves' => 5 * $tasa,
            'metodo_pago' => Order::PAYMENT_CASH_USD,
            'estado_pago' => Order::PAYMENT_PENDING,
            'comision_plataforma_porc' => 25,
            'comision_conductor_porc' => 75,
            'ganancia_conductor_usd' => 2.63,
            'ganancia_plataforma_usd' => 0.87,
            'aprobado_el' => null,
            'asignado_el' => null,
            'recogido_el' => null,
            'en_trayecto_el' => null,
            'entregado_el' => null,
            'cancelado_el' => null,
            'motivo_cancelacion' => null,
            'notas' => null,
        ];
    }

    public function estandar(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo_servicio' => Order::SERVICE_TYPE_STANDARD,
        ]);
    }

    public function express(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo_servicio' => Order::SERVICE_TYPE_EXPRESS,
            'tarifa_base_usd' => 10,
            'total_usd' => 10,
        ]);
    }

    public function recibido(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Order::STATUS_RECEIVED,
        ]);
    }

    public function aprobado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Order::STATUS_APPROVED,
            'aprobado_el' => now(),
        ]);
    }

    public function asignado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Order::STATUS_ASSIGNED,
            'asignado_el' => now(),
        ]);
    }

    public function entregado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Order::STATUS_DELIVERED,
            'entregado_el' => now(),
        ]);
    }
}
