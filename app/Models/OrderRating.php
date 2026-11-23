<?php

namespace App\Models;

use Database\Factories\OrderRatingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pedido_id', 'cliente_id', 'conductor_id', 'puntuacion', 'comentario'])]
class OrderRating extends Model
{

    protected $table = "calificaciones";
    /** @use HasFactory<OrderRatingFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'puntuacion' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Order, $this>
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'pedido_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /**
     * @return BelongsTo<Driver, $this>
     */
    public function conductor(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'conductor_id');
    }
}
