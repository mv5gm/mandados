<?php

namespace Database\Factories;

use App\Models\ExchangeRate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExchangeRate>
 */
class ExchangeRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'moneda' => 'USD',
            'tasa' => fake()->randomFloat(4, 30, 60),
            'origen' => ExchangeRate::ORIGEN_BCV,
            'fecha_efectiva' => now()->startOfDay(),
            'activo' => true,
            'creado_por' => User::query()->first()?->id,
        ];
    }

    public function inactiva(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }

    public function manual(): static
    {
        return $this->state(fn (array $attributes) => [
            'origen' => ExchangeRate::ORIGEN_MANUAL,
        ]);
    }

    public function historica(): static
    {
        return $this->state(fn (array $attributes) => [
            'fecha_efectiva' => now()->subDays(fake()->numberBetween(1, 90))->startOfDay(),
        ]);
    }
}
