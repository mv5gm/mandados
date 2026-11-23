<?php

namespace App\Models;

use Database\Factories\ExchangeRateFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['moneda', 'tasa', 'origen', 'fecha_efectiva', 'activo', 'creado_por'])]
class ExchangeRate extends Model
{

    protected $table = "tasas_cambio";
    /** @use HasFactory<ExchangeRateFactory> */
    use HasFactory;

    public const ORIGEN_BCV = 'bcv';

    public const ORIGEN_MANUAL = 'manual';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tasa' => 'decimal:4',
            'fecha_efectiva' => 'date',
            'activo' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    /**
     * @param  Builder<ExchangeRate>  $query
     */
    public function scopeActivo(Builder $query): void
    {
        $query->where('activo', true);
    }

    public static function actual(string $moneda = 'USD'): ?self
    {
        return static::query()
            ->where('moneda', $moneda)
            ->where('activo', true)
            ->latest('fecha_efectiva')
            ->latest('id')
            ->first();
    }
}
