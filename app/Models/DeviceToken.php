<?php

namespace App\Models;

use Database\Factories\DeviceTokenFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['usuario_id', 'token', 'plataforma'])]
class DeviceToken extends Model
{

    protected $table = "dispositivos_push";
    /** @use HasFactory<DeviceTokenFactory> */
    use HasFactory;

    public const PLATFORM_ANDROID = 'android';

    public const PLATFORM_IOS = 'ios';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
