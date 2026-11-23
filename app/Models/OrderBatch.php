<?php

namespace App\Models;

use Database\Factories\OrderBatchFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'code',
    'conductor_id',
    'tipo_servicio',
    'estado',
    'fecha_agendada',
    'hora_corte',
    'asignado_el',
    'completado_el',
])]
class OrderBatch extends Model
{

    protected $table = "lotes_pedidos";
    /** @use HasFactory<OrderBatchFactory> */
    use HasFactory;

    public const ESTADO_ABIERTO = 'abierto';

    public const ESTADO_ASIGNADO = 'asignado';

    public const ESTADO_EN_PROGRESO = 'en_progreso';

    public const ESTADO_COMPLETADO = 'completado';

    public const ESTADO_CANCELADO = 'cancelado';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_agendada' => 'date',
            'hora_corte' => 'datetime',
            'asignado_el' => 'datetime',
            'completado_el' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Driver, $this>
     */
    public function conductor(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'conductor_id');
    }

    /**
     * @return HasMany<Order, $this>
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Order::class, 'lote_id');
    }
}
