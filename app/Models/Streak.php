<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    protected $table = 'streaks';

    protected $fillable = [
        'user_id',
        'dias_racha',
        'racha_maxima',
        'ultimo_registro',
    ];

    protected $casts = [
        'ultimo_registro' => 'date',
        'dias_racha'      => 'integer',
        'racha_maxima'    => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actualizar(): void
    {
        $hoy = today();

        if (!$this->ultimo_registro) {
            $this->dias_racha      = 1;
            $this->ultimo_registro = $hoy;
        } elseif ($this->ultimo_registro->isYesterday()) {
            $this->dias_racha++;
            $this->ultimo_registro = $hoy;
        } elseif (!$this->ultimo_registro->isToday()) {
            $this->dias_racha      = 1;
            $this->ultimo_registro = $hoy;
        }

        if ($this->dias_racha > $this->racha_maxima) {
            $this->racha_maxima = $this->dias_racha;
        }

        $this->save();
    }
}
