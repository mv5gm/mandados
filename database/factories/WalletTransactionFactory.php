<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WalletTransaction>
 */
class WalletTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conductor_id' => Driver::factory(),
            'pedido_id' => Order::factory(),
            'tipo' => WalletTransaction::TIPO_INGRESO,
            'monto' => fake()->randomFloat(2, 50, 500),
            'saldo_final' => fake()->randomFloat(2, 0, 500),
            'descripcion' => fake()->sentence(),
            'creado_por' => User::factory(),
        ];
    }
}
