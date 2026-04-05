<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emotion;
use App\Models\User;
use Illuminate\Http\Request;

class AISupervisionController extends Controller
{
    public function index()
    {
        // ─── Estadísticas generales del sistema ───────────────────────
        $stats = [
            'total_emociones'    => Emotion::count(),
            'emociones_hoy'      => Emotion::whereDate('created_at', today())->count(),
            'emociones_mes'      => Emotion::whereMonth('created_at', now()->month)->count(),
            'usuarios_activos'   => Emotion::whereDate('created_at', today())
                                        ->distinct('user_id')->count(),
        ];

        // ─── Emociones predominantes globales ─────────────────────────
        $emocionesGlobales = Emotion::selectRaw('emocion_amo, COUNT(*) as total')
            ->groupBy('emocion_amo')
            ->orderByDesc('total')
            ->get();

        // ─── Intensidad promedio por emoción ──────────────────────────
        $intensidadPromedio = Emotion::selectRaw('emocion_amo, AVG(intensidad_emo) as promedio')
            ->groupBy('emocion_amo')
            ->orderByDesc('promedio')
            ->get();

        // ─── Últimas detecciones ──────────────────────────────────────
        $ultimasDetecciones = Emotion::with('user')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // ─── Emociones por día (últimos 7 días) ───────────────────────
        $emocionesUltimos7Dias = Emotion::selectRaw('DATE(created_at) as dia, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return view('admin.supervision', compact(
            'stats',
            'emocionesGlobales',
            'intensidadPromedio',
            'ultimasDetecciones',
            'emocionesUltimos7Dias'
        ));
    }
}