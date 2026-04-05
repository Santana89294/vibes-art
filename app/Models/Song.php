<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';

    protected $fillable = [
        'emocion_can',
        'nom_can',
        'artista_can',
        'url_can',
        'genero_can',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    // ─── Obtener canción aleatoria por emoción ────────────────────────
    public static function getByEmocion(string $emocion): ?self
    {
        return self::where('emocion_can', $emocion)
            ->where('activa', true)
            ->inRandomOrder()
            ->first();
    }
}
