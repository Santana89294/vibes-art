<?php

namespace App\Http\Controllers;

use App\Models\Emotion;
use App\Models\Streak;
use App\Models\VibesNotification;
use App\Services\EmotionDetectionService;
use App\Services\ArtGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    protected EmotionDetectionService $detector;
    protected ArtGenerationService $artGenerator;

    public function __construct()
    {
        $this->detector     = new EmotionDetectionService();
        $this->artGenerator = new ArtGenerationService();
    }

    // ─── HU011: Galería organizada por días ───────────────────────────
    public function index(Request $request)
    {
        $mes  = $request->get('mes', now()->month);
        $anio = $request->get('anio', now()->year);

        $emociones = Emotion::where('user_id', Auth::id())
            ->whereMonth('fecha_emo', $mes)
            ->whereYear('fecha_emo', $anio)
            ->orderBy('fecha_emo', 'desc')
            ->get();

        // HU012 - Emoción predominante del mes
        $emocionMensual = null;
        if ($emociones->count() > 0) {
            $emocionMensual = $emociones
                ->groupBy('emocion_amo')
                ->map->count()
                ->sortDesc()
                ->keys()
                ->first();
        }

        // HU013 - Racha del usuario
        $streak = Streak::firstOrCreate(
            ['user_id' => Auth::id()],
            ['dias_racha' => 0, 'racha_maxima' => 0]
        );

        // HU014 - Notificación del día
        $notificacion = VibesNotification::getRandom();

        $diasConRegistro = $emociones->pluck('fecha_emo')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->toArray();

        $stats = [
            'total'    => $emociones->count(),
            'dias_mes' => now()->setMonth($mes)->daysInMonth,
        ];

        return view('gallery.index', compact(
            'emociones', 'emocionMensual', 'streak',
            'diasConRegistro', 'stats', 'mes', 'anio', 'notificacion'
        ));
    }

    // ─── Ver detalle de una emoción ───────────────────────────────────
    public function show(Emotion $emotion)
    {
        if ($emotion->user_id !== Auth::id()) {
            abort(403);
        }

        $color     = $this->detector->getColor($emotion->emocion_amo);
        $emoji     = $this->detector->getEmoji($emotion->emocion_amo);
        $artConfig = $this->artGenerator->getConfig(
            $emotion->emocion_amo,
            $emotion->intensidad_emo
        );

        $allEmotionColors = [];
        if ($emotion->all_scores) {
            foreach ($emotion->all_scores as $emo => $score) {
                if ($score > 0) {
                    $allEmotionColors[$emo] = [
                        'color' => $this->detector->getColor($emo),
                        'score' => $score,
                        'emoji' => $this->detector->getEmoji($emo),
                    ];
                }
            }
            arsort($allEmotionColors);
        }

        return view('gallery.show', compact(
            'emotion', 'color', 'emoji', 'artConfig', 'allEmotionColors'
        ));

    }
    public function saveArt(Request $request, Emotion $emotion)
{
    if ($emotion->user_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'art_image' => 'required|string',
    ]);

    $emotion->update([
        'art_image' => $request->art_image,
    ]);

    return response()->json(['success' => true]);
}
}
