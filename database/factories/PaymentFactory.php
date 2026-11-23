<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
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
            'pedido_id' => Order::factory(),
            'cliente_id' => fn (array $attributes) => Order::query()->find($attributes['pedido_id'])?->cliente_id,
            'metodo' => Order::PAYMENT_TRANSFER_VES,
            'moneda' => 'VES',
            'monto' => 179.25,
            'tasa' => $tasa,
            'monto_usd' => 7.8,
            'referencia' => 'OP-' . fake()->bothify('########'),
            'banco' => fake()->randomElement(['Banco de Venezuela', 'Provincial', 'Continentales', 'Occidental']),
            'telefono_pagante' => fake()->phoneNumber(),
            'prueba_path' => 'pruebas/' . fake()->uuid() . '.jpg',
            'estado' => Payment::ESTADO_ENVIADO,
            'verificado_por' => null,
            'verificado_el' => null,
            'motivo_rechazo' => null,
        ];
    }

    public function pendiente(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Payment::ESTADO_PENDIENTE,
            'verificado_por' => null,
            'verificado_el' => null,
        ]);
    }

    public function verificado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Payment::ESTADO_VERIFICADO,
        ]);
    }
}
