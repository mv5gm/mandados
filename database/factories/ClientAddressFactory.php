<?php

namespace Database\Factories;

use App\Models\ClientAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClientAddress>
 */
class ClientAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => User::query()->first()?->id ?? User::factory(),
            'tipo' => fake()->randomElement(['Principal', 'Familiar', 'Trabajo', 'Otros']),
            'sector' => fake()->randomElement(['Sector 1, Carúpano', 'Sector 4, Yaguaraparo', 'Sector 7, Yaguaraparo']),
            'calle' => fake()->streetName(),
            'referencia' => fake()->optional()->text(),
            'lat' => fake()->optional()->latitude(),
            'lon' => fake()->optional()->longitude(),
            'predeterminada' => false,
        ];
    }

    public function predeterminada(): static
    {
        return $this->state(fn (array $attributes) => [
            'predeterminada' => true,
        ]);
    }
}
