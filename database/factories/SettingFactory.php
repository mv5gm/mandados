<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clave' => fake()->unique()->snake(fake()->randomElement([
                'tarifa_estandar_usd',
                'tarifa_estandar_ves',
                'tarifa_express_usd',
                'comision_plataforma_porc',
                'comision_conductor_porc',
                'peso_maximo_kg',
                'hora_corte_estandar',
            ])),
            'valor' => fake()->numerify('##.##'),
            'tipo' => 'decimal',
            'grupo' => 'pricing',
            'etiqueta' => fake()->sentence(3),
            'descripcion' => fake()->sentence(),
        ];
    }

    public function booleano(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => 'boolean',
            'valor' => (string) fake()->boolean(),
        ]);
    }

    public function hora(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => 'time',
            'valor' => '19:00',
        ]);
    }

    public function general(): static
    {
        return $this->state(fn (array $attributes) => [
            'grupo' => 'general',
        ]);
    }
}
