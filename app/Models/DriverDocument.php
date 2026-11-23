<?php

namespace App\Models;

use Database\Factories\DriverDocumentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'conductor_id',
    'tipo',
    'path',
    'estado',
    'revision_el',
    'revision_por',
    'notas',
])]
class DriverDocument extends Model
{

    protected $table = "conductores_documentos";
    /** @use HasFactory<DriverDocumentFactory> */
    use HasFactory;

    public const TIPO_CEDULA_FRENTE = 'cedula_frente';

    public const TIPO_LICENCIA = 'licencia';

    public const TIPO_CERTIFICADO_MEDICO = 'certificado_medico';

    public const TIPO_CARNET_CIRCULACION = 'carnet_circulacion';

    public const TIPO_MOTO_ACTUAL = 'moto_actual';

    public const TIPO_SELFIE = 'selfie';

    public const ESTADO_PENDIENTE = 'pendiente';

    public const ESTADO_APROBADO = 'aprobado';

    public const ESTADO_RECHAZADO = 'rechazado';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'revision_el' => 'datetime',
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
     * @return BelongsTo<User, $this>
     */
    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revision_por');
    }
}
