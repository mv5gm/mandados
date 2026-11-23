<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\DriverPayoutMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DriverPayoutMethod>
 */
class DriverPayoutMethodFactory extends Factory
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
            'tipo' => DriverPayoutMethod::TIPO_PAGO_MOVIL,
            'banco' => fake()->randomElement(['Banesco', 'BFC', 'Banco de Venezuela', 'BOD']),
            'titular' => fake()->name(),
            'cedula' => fake()->unique()->cedula(),
            'telefono' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'id_billetera' => fake()->uuid(),
            'predeterminado' => true,
        ];
    }
}
