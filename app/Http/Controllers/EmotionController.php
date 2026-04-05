<?php

namespace App\Http\Controllers;

use App\Models\Emotion;
use App\Models\Song;
use App\Services\EmotionDetectionService;
use App\Services\ArtGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmotionController extends Controller
{
    protected EmotionDetectionService $detector;
    protected ArtGenerationService $artGenerator;

    public function __construct()
    {
        $this->detector     = new EmotionDetectionService();
        $this->artGenerator = new ArtGenerationService();
    }

    public function showDiary()
    {
        $todayEmotion = Emotion::where('user_id', Auth::id())
            ->whereDate('fecha_emo', today())
            ->first();

        return view('emotions.diary', compact('todayEmotion'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'texto_emo' => 'required|string|min:10|max:1000',
        ], [
            'texto_emo.required' => 'Escribe algo sobre cómo te sientes.',
            'texto_emo.min'      => 'Escribe al menos 10 caracteres.',
            'texto_emo.max'      => 'Máximo 1000 caracteres.',
        ]);

        $result = $this->detector->detect($request->texto_emo);

        $existing = Emotion::where('user_id', Auth::id())
            ->whereDate('fecha_emo', today())
            ->first();

        if ($existing) {
            $existing->update([
                'texto_emo'      => $request->texto_emo,
                'emocion_amo'    => $result['emotion'],
                'intensidad_emo' => $result['intensity'],
                'all_scores'     => $result['all_scores'],
            ]);
            $emotion = $existing;
        } else {
            $emotion = Emotion::create([
                'user_id'        => Auth::id(),
                'texto_emo'      => $request->texto_emo,
                'emocion_amo'    => $result['emotion'],
                'intensidad_emo' => $result['intensity'],
                'all_scores'     => $result['all_scores'],
                'fecha_emo'      => today(),
            ]);
        }
// HU013 - Actualizar racha
$streak = \App\Models\Streak::firstOrCreate(
    ['user_id' => Auth::id()],
    ['dias_racha' => 0, 'racha_maxima' => 0]
);
$streak->actualizar();
        return redirect()->route('emotions.result', $emotion->id);
    }

    public function result(Emotion $emotion)
    {
        if ($emotion->user_id !== Auth::id()) {
            abort(403);
        }

        $color = $this->detector->getColor($emotion->emocion_amo);
        $emoji = $this->detector->getEmoji($emotion->emocion_amo);

        $artConfig = $this->artGenerator->getConfig(
            $emotion->emocion_amo,
            $emotion->intensidad_emo
        );

        // Preparar colores de todas las emociones detectadas
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

        $song = Song::getByEmocion($emotion->emocion_amo);

        return view('emotions.result', compact(
            'emotion', 'color', 'emoji', 'artConfig', 'song', 'allEmotionColors'
        ));
    }
}
