<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderDocument>
 */
class OrderDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pedido_id' => Order::factory(),
            'tipo' => OrderDocument::TIPO_CEDULA_CLIENTE,
            'ruta' => 'documentos/' . fake()->uuid() . '.jpg',
            'estado' => OrderDocument::ESTADO_APROBADO,
            'subido_por' => User::factory(),
        ];
    }
}
