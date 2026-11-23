<?php

namespace App\Models;

use Database\Factories\ClientAddressFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'cliente_id',
    'tipo',
    'sector',
    'calle',
    'referencia',
    'lat',
    'lon',
    'predeterminada',
])]
class ClientAddress extends Model
{

    protected $table = "direcciones_clientes";
    /** @use HasFactory<ClientAddressFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'lat' => 'decimal:7',
            'lon' => 'decimal:7',
            'predeterminada' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
