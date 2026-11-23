<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\DriverDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DriverDocument>
 */
class DriverDocumentFactory extends Factory
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
            'tipo' => DriverDocument::TIPO_CEDULA_FRENTE,
            'path' => 'documentos/' . fake()->uuid() . '.jpg',
            'estado' => DriverDocument::ESTADO_APROBADO,
            'revision_el' => now(),
            'revision_por' => User::factory(),
            'notas' => fake()->optional()->text(),
        ];
    }

    public function pendiente(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => DriverDocument::ESTADO_PENDIENTE,
            'revision_el' => null,
            'revision_por' => null,
        ]);
    }
}
