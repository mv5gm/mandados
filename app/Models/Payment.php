<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'pedido_id',
    'cliente_id',
    'metodo',
    'moneda',
    'monto',
    'tasa',
    'monto_usd',
    'referencia',
    'banco',
    'telefono_pagante',
    'prueba_path',
    'estado',
    'verificado_por',
    'verificado_el',
    'motivo_rechazo',
])]
class Payment extends Model
{

    protected $table = "pagos";
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    public const ESTADO_PENDIENTE = 'pendiente';

    public const ESTADO_ENVIADO = 'enviado';

    public const ESTADO_VERIFICADO = 'verificado';

    public const ESTADO_RECHAZADO = 'rechazado';

    public const ESTADO_REEMBOLSADO = 'reembolsado';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tasa' => 'decimal:4',
            'monto' => 'decimal:2',
            'monto_usd' => 'decimal:2',
            'verificado_el' => 'datetime',
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
     * @return BelongsTo<User, $this>
     */
    public function verificadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verificado_por');
    }

    public function isVerificado(): bool
    {
        return $this->estado === self::ESTADO_VERIFICADO;
    }
}
