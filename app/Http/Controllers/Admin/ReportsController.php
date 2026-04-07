<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emotion;
use App\Models\User;
use App\Models\VibesNotification;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $emocionesGlobales = Emotion::selectRaw('emocion_amo, COUNT(*) as total')
            ->groupBy('emocion_amo')
            ->orderByDesc('total')
            ->get();

        $totalRegistros = Emotion::count();

        $emocionesPorMesRaw = Emotion::selectRaw('MONTH(fecha_emo) as mes, YEAR(fecha_emo) as anio, COUNT(*) as total')
            ->where('fecha_emo', '>=', now()->subMonths(6))
            ->groupBy('mes', 'anio')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();

        $mesesLabels  = [];
        $mesesTotales = [];
        foreach ($emocionesPorMesRaw as $r) {
            $mesesLabels[]  = str_pad($r->mes, 2, '0', STR_PAD_LEFT) . '/' . $r->anio;
            $mesesTotales[] = $r->total;
        }

        $topUsuarios = User::where('role', 'usuario')
            ->withCount('emotions')
            ->orderByDesc('emotions_count')
            ->take(5)
            ->get();

        $intensidadPromedio = Emotion::selectRaw('emocion_amo, AVG(intensidad_emo) as promedio')
            ->groupBy('emocion_amo')
            ->orderByDesc('promedio')
            ->get();

        return view('admin.reports.index', compact(
            'emocionesGlobales', 'totalRegistros',
            'mesesLabels', 'mesesTotales',
            'topUsuarios', 'intensidadPromedio'
        ));
    }

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
