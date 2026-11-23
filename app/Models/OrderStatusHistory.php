<?php

namespace App\Models;

use Database\Factories\OrderStatusHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pedido_id', 'estado', 'notas', 'cambiado_por'])]
class OrderStatusHistory extends Model
{

    protected $table = "historial_pedidos";
    /** @use HasFactory<OrderStatusHistoryFactory> */
    use HasFactory;

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
    public function cambiadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cambiado_por');
    }
}
