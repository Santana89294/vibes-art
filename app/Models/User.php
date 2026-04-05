<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
    'nom_user',
    'edad_user',
    'email_user',
    'contra_user',
    'config_notif_user',
    'registro_user',
    'role',
    'avatar_url',
    'email_verified',
    'verification_code',
];

    protected $hidden = [
        'contra_user',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->contra_user;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return $this->registro_user === 'activo';
    }
    // ─── Relación con emociones ───────────────────────────────────────
public function emotions()
{
    return $this->hasMany(\App\Models\Emotion::class);
}
}
