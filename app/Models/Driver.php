<?php

namespace App\Models;

use Database\Factories\DriverFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'usuario_id',
    'direccion',
    'nombre_contacto_emergencia',
    'telefono_contacto_emergencia',
    'marca',
    'modelo',
    'anio',
    'color',
    'placa',
    'estatus',
    'aprobado_el',
    'aprobado_por',
    'motivo_rechazo',
    'disponible',
    'ultima_asignacion_el',
    'calificacion_promedio',
    'cantidad_calificaciones',
])]
class Driver extends Model
{

    protected $table = "conductores";
    /** @use HasFactory<DriverFactory> */
    use HasFactory;

    public const ESTATUS_PENDIENTE = 'pendiente';

    public const ESTATUS_APROBADO = 'aprobado';

    public const ESTATUS_RECHAZADO = 'rechazado';

    public const ESTATUS_SUSPENDIDO = 'suspendido';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'anio' => 'integer',
            'aprobado_el' => 'datetime',
            'disponible' => 'boolean',
            'ultima_asignacion_el' => 'datetime',
            'calificacion_promedio' => 'decimal:2',
            'cantidad_calificaciones' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function aprobadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    /**
     * @return HasMany<DriverDocument, $this>
     */
    public function documentos(): HasMany
    {
        return $this->hasMany(DriverDocument::class, 'conductor_id');
    }

    /**
     * @return HasMany<DriverPayoutMethod, $this>
     */
    public function metodosPago(): HasMany
    {
        return $this->hasMany(DriverPayoutMethod::class, 'conductor_id');
    }

    /**
     * @return HasOne<DriverWallet, $this>
     */
    public function billetera(): HasOne
    {
        return $this->hasOne(DriverWallet::class, 'conductor_id');
    }

    /**
     * @return HasMany<Order, $this>
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Order::class, 'conductor_id');
    }

    /**
     * @return HasMany<OrderBatch, $this>
     */
    public function lotes(): HasMany
    {
        return $this->hasMany(OrderBatch::class, 'conductor_id');
    }

    /**
     * @return HasMany<OrderRating, $this>
     */
    public function calificaciones(): HasMany
    {
        return $this->hasMany(OrderRating::class, 'conductor_id');
    }

    /**
     * @return HasMany<WalletTransaction, $this>
     */
    public function transacciones(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'conductor_id');
    }

    /**
     * @param  Builder<Driver>  $query
     */
    public function scopeAprobados(Builder $query): void
    {
        $query->where('estatus', self::ESTATUS_APROBADO);
    }

    /**
     * @param  Builder<Driver>  $query
     */
    public function scopeDisponiblesParaAsignacion(Builder $query): void
    {
        $query->aprobados()->where('disponible', true);
    }

    public function isAprobado(): bool
    {
        return $this->estatus === self::ESTATUS_APROBADO;
    }
}
