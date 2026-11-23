<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderRating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderRating>
 */
class OrderRatingFactory extends Factory
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
            'cliente_id' => User::factory(),
            'conductor_id' => Driver::factory(),
            'puntuacion' => fake()->numberBetween(1, 5),
            'comentario' => fake()->optional()->sentence(),
        ];
    }
}
