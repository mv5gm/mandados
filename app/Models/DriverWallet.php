<?php

namespace App\Models;

use Database\Factories\DriverWalletFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'conductor_id',
    'saldo_a_favor',
    'saldo_prepayado',
    'total_entregado',
    'total_pagado',
])]
class DriverWallet extends Model
{

    protected $table = "conductores_billeteras";
    /** @use HasFactory<DriverWalletFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'saldo_a_favor' => 'decimal:2',
            'saldo_prepayado' => 'decimal:2',
            'total_entregado' => 'decimal:2',
            'total_pagado' => 'decimal:2',
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
