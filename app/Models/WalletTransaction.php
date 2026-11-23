<?php

namespace App\Models;

use Database\Factories\WalletTransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'conductor_id',
    'pedido_id',
    'tipo',
    'monto',
    'saldo_final',
    'descripcion',
    'creado_por',
])]
class WalletTransaction extends Model
{

    protected $table = "transacciones_billetera";
    /** @use HasFactory<WalletTransactionFactory> */
    use HasFactory;

    public const TIPO_INGRESO = 'ingreso';

    public const TIPO_COMISION = 'comision';

    public const TIPO_DEPOSITO_PREPAGO = 'deposito_prepayado';

    public const TIPO_PAGO = 'pago';

    public const TIPO_AJUSTE = 'ajuste';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'saldo_final' => 'decimal:2',
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
     * @return BelongsTo<Order, $this>
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'pedido_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
