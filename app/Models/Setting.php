<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['clave', 'valor', 'tipo', 'grupo', 'etiqueta', 'descripcion'])]
class Setting extends Model
{

    protected $table = 'ajustes';

    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    public const TIPO_STRING = 'string';

    public const TIPO_ENTERO = 'integer';

    public const TIPO_DECIMAL = 'decimal';

    public const TIPO_BOOLEAN = 'boolean';

    public const TIPO_TIME = 'time';

    public const GRUPO_GENERAL = 'general';

    public const GRUPO_PRICING = 'pricing';

    public static function get(string $key): mixed
    {
        $setting = static::query()->where('clave', $key)->first();

        return $setting?->valor;
    }

    public static function set(string $key, mixed $value): void
    {
        static::query()->updateOrCreate(['clave' => $key], ['valor' => $value]);
    }
}
