<?php

namespace App\Models;

use Database\Factories\DriverPayoutMethodFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'conductor_id',
    'tipo',
    'banco',
    'titular',
    'cedula',
    'telefono',
    'email',
    'id_billetera',
    'predeterminado',
])]
class DriverPayoutMethod extends Model
{

    protected $table = "conductores_metodos_pago";
    /** @use HasFactory<DriverPayoutMethodFactory> */
    use HasFactory;

    public const TIPO_PAGO_MOVIL = 'pago_movil';

    public const TIPO_BINANCE = 'binance';

    public const TIPO_BYBIT = 'bybit';

    public const TIPO_AIRTM = 'airtm';

    public const TIPO_ZINLI = 'zinli';

    public const TIPO_WALLY = 'wally';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'predeterminado' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Driver, $this>
     */
    public function conductor(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'conductor_id');
    }
}
