<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emotion;
use App\Models\User;
use App\Models\VibesNotification;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    // ─── HU019: Reportes generales de emociones ───────────────────────
    public function index()
    {
        // Emociones predominantes globales
        $emocionesGlobales = Emotion::selectRaw('emocion_amo, COUNT(*) as total')
            ->groupBy('emocion_amo')
            ->orderByDesc('total')
            ->get();

        // Total de registros
        $totalRegistros = Emotion::count();

        // Emociones por mes (últimos 6 meses) ✅ FIX PostgreSQL
        $emocionesPorMes = Emotion::selectRaw("
                EXTRACT(MONTH FROM fecha_emo) as mes,
                EXTRACT(YEAR FROM fecha_emo) as anio,
                COUNT(*) as total
            ")
            ->where('fecha_emo', '>=', now()->subMonths(6))
            ->groupByRaw("EXTRACT(YEAR FROM fecha_emo), EXTRACT(MONTH FROM fecha_emo)")
            ->orderByRaw("EXTRACT(YEAR FROM fecha_emo) ASC")
            ->orderByRaw("EXTRACT(MONTH FROM fecha_emo) ASC")
            ->get();

        // 🔥 Preparar datos para Chart.js
        $mesesLabels = [];
        $mesesTotales = [];

        $mesesNombres = [
            1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',
            7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic'
        ];

        foreach ($emocionesPorMes as $item) {
            $mes = (int) $item->mes;
            $mesesLabels[] = $mesesNombres[$mes] . ' ' . $item->anio;
            $mesesTotales[] = $item->total;
        }

        // Top usuarios más activos
        $topUsuarios = User::where('role', 'usuario')
            ->withCount('emotions')
            ->orderByDesc('emotions_count')
            ->take(5)
            ->get();

        // Intensidad promedio por emoción
        $intensidadPromedio = Emotion::selectRaw('emocion_amo, AVG(intensidad_emo) as promedio')
            ->groupBy('emocion_amo')
            ->orderByDesc('promedio')
            ->get();

        return view('admin.reports.index', compact(
            'emocionesGlobales',
            'totalRegistros',
            'emocionesPorMes',
            'topUsuarios',
            'intensidadPromedio',
            'mesesLabels',
            'mesesTotales'
        ));
    }

    // ─── HU020: Gestión de notificaciones ─────────────────────────────
    public function notifications()
    {
        $notifications = VibesNotification::orderBy('tipo')->get();
        return view('admin.reports.notifications', compact('notifications'));
    }

    public function storeNotification(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:255',
            'tipo'    => 'required|in:general,racha,recordatorio',
        ], [
            'mensaje.required' => 'El mensaje es obligatorio.',
            'tipo.required'    => 'El tipo es obligatorio.',
        ]);

        VibesNotification::create($request->only(['mensaje', 'tipo']));

        return redirect()->route('admin.notifications')
            ->with('success', 'Notificación creada correctamente.');
    }

    public function toggleNotification(VibesNotification $notification)
    {
        $notification->update(['activo' => !$notification->activo]);
        return redirect()->back()->with('success', 'Notificación actualizada.');
    }

    public function destroyNotification(VibesNotification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notifications')
            ->with('success', 'Notificación eliminada.');
    }
}
