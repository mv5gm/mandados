<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'code',
    'cliente_id',
    'conductor_id',
    'lote_id',
    'tipo_servicio',
    'estado',
    'client_uuid',
    'tracking_mrw',
    'remitente',
    'rango_peso',
    'tipo_paquete',
    'tipo_seguro',
    'valor_declarado_usd',
    'tarifa_seguro_usd',
    'aceptacion_terminos_el',
    'sector_entrega',
    'calle_entrega',
    'referencia_entrega',
    'lat_entrega',
    'lon_entrega',
    'fecha_recogida_agendada',
    'pin_entrega',
    'foto_recogida',
    'foto_entrega',
    'firma_entrega',
    'tarifa_base_usd',
    'total_usd',
    'tasa_cambio',
    'total_ves',
    'metodo_pago',
    'estado_pago',
    'comision_plataforma_porc',
    'comision_conductor_porc',
    'ganancia_conductor_usd',
    'ganancia_plataforma_usd',
    'aprobado_el',
    'asignado_el',
    'recogido_el',
    'en_trayecto_el',
    'entregado_el',
    'cancelado_el',
    'motivo_cancelacion',
    'notas',
])]
#[Hidden(['pin_entrega'])]
class Order extends Model
{

    protected $table = "pedidos";
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    public const SERVICE_TYPE_STANDARD = 'estándar';

    public const SERVICE_TYPE_EXPRESS = 'express';

    public const STATUS_RECEIVED = 'recibido';

    public const STATUS_VALIDATING = 'validando';

    public const STATUS_APPROVED = 'aprobado';

    public const STATUS_ASSIGNED = 'asignado';

    public const STATUS_PICKUP_IN_PROGRESS = 'recogida_en_progreso';

    public const STATUS_PICKED_UP = 'recogido';

    public const STATUS_IN_TRANSIT = 'en_trayecto';

    public const STATUS_DELIVERED = 'entregado';

    public const STATUS_CANCELLED = 'cancelado';

    public const WEIGHT_UNDER_2 = 'menos_2';

    public const WEIGHT_2_5 = '2_5';

    public const WEIGHT_5_10 = '5_10';

    public const PACKAGE_ENVELOPE = 'sobre';

    public const PACKAGE_MEDIUM_BOX = 'caja_mediana';

    public const PACKAGE_LARGE_BOX = 'caja_grande';

    public const INSURANCE_BASIC = 'básico';

    public const INSURANCE_EXTENDED = 'ampliado';

    public const PAYMENT_CASH_USD = 'efectivo_usd';

    public const PAYMENT_CASH_VES = 'efectivo_ves';

    public const PAYMENT_TRANSFER_VES = 'transferencia_ves';

    public const PAYMENT_BINANCE = 'binance';

    public const PAYMENT_BYBIT = 'bybit';

    public const PAYMENT_AIRTM = 'airtm';

    public const PAYMENT_ZINLI = 'zinli';

    public const PAYMENT_WALLY = 'wally';

    public const PAYMENT_PENDING = 'pendiente';

    public const PAYMENT_SUBMITTED = 'enviado';

    public const PAYMENT_VERIFIED = 'verificado';

    public const PAYMENT_REJECTED = 'rechazado';

    public const PAYMENT_REFUNDED = 'reembolsado';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'lat_entrega' => 'decimal:7',
            'lon_entrega' => 'decimal:7',
            'aceptacion_terminos_el' => 'datetime',
            'valor_declarado_usd' => 'decimal:2',
            'tarifa_seguro_usd' => 'decimal:2',
            'tasa_cambio' => 'decimal:4',
            'tarifa_base_usd' => 'decimal:2',
            'total_usd' => 'decimal:2',
            'total_ves' => 'decimal:2',
            'comision_plataforma_porc' => 'decimal:2',
            'comision_conductor_porc' => 'decimal:2',
            'ganancia_conductor_usd' => 'decimal:2',
            'ganancia_plataforma_usd' => 'decimal:2',
            'aprobado_el' => 'datetime',
            'asignado_el' => 'datetime',
            'recogido_el' => 'datetime',
            'en_trayecto_el' => 'datetime',
            'entregado_el' => 'datetime',
            'cancelado_el' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function client(): BelongsTo
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

    /**
     * @return BelongsTo<OrderBatch, $this>
     */
    public function lote(): BelongsTo
    {
        return $this->belongsTo(OrderBatch::class, 'lote_id');
    }

    /**
     * @return HasMany<OrderStatusHistory, $this>
     */
    public function historial(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'pedido_id');
    }

    /**
     * @return HasMany<OrderDocument, $this>
     */
    public function documentos(): HasMany
    {
        return $this->hasMany(OrderDocument::class, 'pedido_id');
    }

    /**
     * @return HasMany<Payment, $this>
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Payment::class, 'pedido_id');
    }

    /**
     * @return HasOne<OrderRating, $this>
     */
    public function calificacion(): HasOne
    {
        return $this->hasOne(OrderRating::class, 'pedido_id');
    }
}
