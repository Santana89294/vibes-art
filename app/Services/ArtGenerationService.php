<?php

namespace App\Services;

class ArtGenerationService
{
    // ─── Configuración visual por emoción ─────────────────────────────
    protected array $emotionConfig = [
        'ira' => [
            'colors'     => ['#FF4444', '#FF6B35', '#FF0000', '#CC0000'],
            'shapes'     => 'angular',
            'speed'      => 'fast',
            'particles'  => 80,
        ],
        'miedo' => [
            'colors'     => ['#9B59B6', '#6C3483', '#1A1A2E', '#4A235A'],
            'shapes'     => 'spiky',
            'speed'      => 'slow',
            'particles'  => 40,
        ],
        'asco' => [
            'colors'     => ['#27AE60', '#1E8449', '#2ECC71', '#145A32'],
            'shapes'     => 'irregular',
            'speed'      => 'medium',
            'particles'  => 50,
        ],
        'tristeza' => [
            'colors'     => ['#3498DB', '#2471A3', '#1A5276', '#85C1E9'],
            'shapes'     => 'smooth',
            'speed'      => 'slow',
            'particles'  => 30,
        ],
        'felicidad' => [
            'colors'     => ['#F39C12', '#F1C40F', '#FF6B9D', '#FFF176'],
            'shapes'     => 'round',
            'speed'      => 'fast',
            'particles'  => 90,
        ],
        'sorpresa' => [
            'colors'     => ['#F1C40F', '#F39C12', '#FF5733', '#DAF7A6'],
            'shapes'     => 'burst',
            'speed'      => 'fast',
            'particles'  => 70,
        ],
        'neutral' => [
            'colors'     => ['#808080', '#A0A0A0', '#606060', '#C0C0C0'],
            'shapes'     => 'smooth',
            'speed'      => 'slow',
            'particles'  => 20,
        ],
    ];

    // ─── Obtener configuración para la vista ──────────────────────────
    public function getConfig(string $emotion, int $intensity): array
    {
        $config = $this->emotionConfig[$emotion] ?? $this->emotionConfig['neutral'];

        return [
            'colors'    => $config['colors'],
            'shapes'    => $config['shapes'],
            'speed'     => $config['speed'],
            'particles' => (int)($config['particles'] * ($intensity / 10)),
            'intensity' => $intensity,
            'emotion'   => $emotion,
        ];
    }
}
