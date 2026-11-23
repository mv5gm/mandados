<?php

namespace App\Models;

use Database\Factories\OrderDocumentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pedido_id', 'tipo', 'ruta', 'estado', 'subido_por'])]
class OrderDocument extends Model
{

    protected $table = "documentos_pedidos";
    /** @use HasFactory<OrderDocumentFactory> */
    use HasFactory;

    public const TIPO_CEDULA_CLIENTE = 'cedula_cliente';

    public const TIPO_CARTA_AUTORIZACION = 'carta_autorizacion';

    public const TIPO_CARTA_MANUSCRITA = 'carta_manuscrita';

    public const TIPO_FACTURA = 'factura';

    public const TIPO_PICKUP_PHOTO = 'foto_recogida';

    public const ESTADO_PENDIENTE = 'pendiente';

    public const ESTADO_APROBADO = 'aprobado';

    public const ESTADO_RECHAZADO = 'rechazado';

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
    public function subidoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subido_por');
    }
}
