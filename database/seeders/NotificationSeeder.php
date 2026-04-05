<?php

namespace Database\Seeders;

use App\Models\VibesNotification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [
            // ─── General ──────────────────────────────────────────────
            ['mensaje' => '¿Cómo fue tu día? Cuéntanos cómo te sientes 🎨', 'tipo' => 'general'],
            ['mensaje' => '¿Pasó algo nuevo hoy? Exprésalo en tu diario ✍️', 'tipo' => 'general'],
            ['mensaje' => 'Tu espacio seguro te espera. ¿Qué sientes hoy? 💜', 'tipo' => 'general'],
            ['mensaje' => 'Cada emoción merece ser expresada. ¡Abre tu diario! 🌟', 'tipo' => 'general'],
            ['mensaje' => '¿Listo para convertir tus emociones en arte? 🎭', 'tipo' => 'general'],

            // ─── Racha ────────────────────────────────────────────────
            ['mensaje' => '¡No dejes perder tu racha de colores! Ven y completa tu galería 🔥', 'tipo' => 'racha'],
            ['mensaje' => '¡Tu racha sigue viva! Mantén el ritmo y registra cómo te sientes 💪', 'tipo' => 'racha'],
            ['mensaje' => '¡Un día más y tu racha crece! ¿Qué emoción tienes hoy? 🌈', 'tipo' => 'racha'],

            // ─── Recordatorio ─────────────────────────────────────────
            ['mensaje' => 'El día está terminando... ¿Ya expresaste cómo te sentiste? 🌙', 'tipo' => 'recordatorio'],
            ['mensaje' => 'Antes de dormir, cuéntanos cómo fue tu día 🌛', 'tipo' => 'recordatorio'],
            ['mensaje' => 'Tu galería emocional te espera. ¡Complétala hoy! 🖼️', 'tipo' => 'recordatorio'],
        ];

        foreach ($notifications as $notification) {
            VibesNotification::create($notification);
        }
    }
}
