<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VibesNotification extends Model
{
    protected $table = 'vibes_notifications';

    protected $fillable = [
        'mensaje',
        'tipo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public static function getRandom(): ?self
    {
        return self::where('activo', true)
            ->inRandomOrder()
            ->first();
    }

    public static function getByTipo(string $tipo): ?self
    {
        return self::where('activo', true)
            ->where('tipo', $tipo)
            ->inRandomOrder()
            ->first();
    }
}
