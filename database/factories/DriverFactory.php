<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(),
            'direccion' => fake()->streetAddress() . ', Yaguaraparo',
            'nombre_contacto_emergencia' => fake()->name(),
            'telefono_contacto_emergencia' => fake()->phoneNumber(),
            'marca' => fake()->randomElement(['Toyota', 'Fiat', 'Mitsubishi', 'Yamaha', 'Honda', 'Beagle']),
            'modelo' => fake()->randomElement(['Boxer', 'L6', 'Mojito', 'Nacional']),
            'anio' => fake()->numberBetween(2000, 2026),
            'color' => fake()->safeColorName(),
            'placa' => fake()->unique()->bothify('AS###-##'),
            'estatus' => Driver::ESTATUS_PENDIENTE,
            'aprobado_el' => null,
            'disponible' => false,
            'ultima_asignacion_el' => null,
            'calificacion_promedio' => 4.6,
            'cantidad_calificaciones' => fake()->numberBetween(0, 50),
        ];
    }

    public function aprobado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estatus' => Driver::ESTATUS_APROBADO,
            'aprobado_el' => now(),
            'disponible' => true,
        ]);
    }

    public function rechazado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estatus' => Driver::ESTATUS_RECHAZADO,
            'motivo_rechazo' => fake()->sentence(),
        ]);
    }

    public function suspendido(): static
    {
        return $this->state(fn (array $attributes) => [
            'estatus' => Driver::ESTATUS_SUSPENDIDO,
        ]);
    }

    public function disponible(): static
    {
        return $this->state(fn (array $attributes) => [
            'disponible' => true,
        ]);
    }
}
