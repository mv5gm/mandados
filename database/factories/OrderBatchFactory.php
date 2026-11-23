<?php

namespace Database\Factories;

use App\Models\OrderBatch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderBatch>
 */
class OrderBatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'BATCH-' . strtoupper(fake()->lexify('????????')),
            'conductor_id' => null,
            'tipo_servicio' => 'estándar',
            'estado' => OrderBatch::ESTADO_ABIERTO,
            'fecha_agendada' => today(),
            'hora_corte' => now()->addHour(),
            'asignado_el' => null,
            'completado_el' => null,
        ];
    }
}
