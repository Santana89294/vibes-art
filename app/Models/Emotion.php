<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
{
    protected $table = 'emotions';

    protected $fillable = [
        'user_id',
        'texto_emo',
        'emocion_amo',
        'intensidad_emo',
        'all_scores',
        'art_image',
        'fecha_emo',
    ];

    protected $casts = [
        'fecha_emo'      => 'date',
        'intensidad_emo' => 'integer',
        'all_scores'     => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
