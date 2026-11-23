<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\DriverWallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DriverWallet>
 */
class DriverWalletFactory extends Factory
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
            'saldo_a_favor' => fake()->randomFloat(2, 0, 500),
            'saldo_prepayado' => fake()->randomFloat(2, 0, 200),
            'total_entregado' => fake()->randomFloat(2, 500, 5000),
            'total_pagado' => fake()->randomFloat(2, 0, 500),
        ];
    }
}
