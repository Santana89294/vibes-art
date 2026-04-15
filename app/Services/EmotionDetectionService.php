<?php

namespace App\Services;

class EmotionDetectionService
{
    protected array $keywords = [
        'ira' => [
             'critico', 'distante', 'frustrado', 'agresivo', 'loco',
            'lleno de odio', 'amenazado', 'herido', 'sarcastico', 'esceptico',
            'desconfiado', 'introvertido', 'irritado', 'enfurecido', 'hostil',
            'provocador', 'rabioso', 'furioso', 'ultrajado',
            'resentido', 'celoso', 'atacado', 'devastado', 'apenado',

        ],
        'miedo' => [
           'humillado', 'rechazado', 'sumiso', 'inseguro',
            'ansioso', 'asustado', 'ridiculizado', 'irrespetado',
            'alienado', 'marginado', 'insignificante', 'inutil', 'inferior',
            'insuficiente', 'preocupado', 'agobiado',
            'espantado', 'aterrado',
        ],
        'asco' => [
            'asco','disconforme', 'desepcionado', 'horrible', 'abstinencia',
            'moralista', 'reacio', 'repugnante', 'revoltoso', 'odioso',
            'aversion', 'vacilante',
        ],
        'tristeza' => [
            'triste', 'culpable', 'abandonado', 'desesperado',
            'deprimido', 'solo', 'aburrido', 'arrepentido',
            'avergonzado', 'ignorado', 'victimizado', 'desvalido',
            'vulnerable', 'melancolico', 'vacio', 'desamparado',
            'aislado', 'apatico', 'indiferente',
        ],
        'felicidad' => [
            'feliz', 'alegre', 'interesado', 'orgulloso',
            'aceptado', 'poderoso', 'pacifico', 'intimo',
            'optimista', 'liberado', 'euforico', 'entretenido',
            'curioso', 'importante', 'seguro', 'respetado',
            'satisfecho', 'valiente', 'provocativo', 'cariñoso', 'esperanzado',
            'sensible', 'bromista', 'abierto', 'inspirado',

        ],
        'sorpresa' => [
            'sorprendido', 'confundido', 'asombrado',
            'entusiasmado', 'conmocionado', 'abatido',
            'desilusionado', 'perplejo', 'estupefacto', 'impresionado',
            'entusiasta', 'energico',
        ],
    ];

    public function detect(string $text): array
    {
        $scores    = [];
        $positions = [];

        // 1️ Normalizar texto
        $lowerText = strtolower($text);
        $lowerText = str_replace(
            ['á','é','í','ó','ú','ü','ñ'],
            ['a','e','i','o','u','u','n'],
            $lowerText
        );

        foreach ($this->keywords as $emotion => $words) {
            $count    = 0;
            $firstPos = PHP_INT_MAX;

            foreach ($words as $word) {
                // 2️ Normalizar palabra clave
                $wordNorm = str_replace(
                    ['á','é','í','ó','ú','ü','ñ'],
                    ['a','e','i','o','u','u','n'],
                    strtolower($word)
                );

                // 3️ Búsqueda exacta → 2 puntos
                $pattern = '/\b' . preg_quote($wordNorm, '/') . '\b/u';
                $matches = preg_match_all($pattern, $lowerText);
                $count  += $matches * 2;

                // 4️ Búsqueda parcial → 1 punto extra
                if (str_contains($lowerText, $wordNorm)) {
                    $count += 1;
                    $pos = strpos($lowerText, $wordNorm);
                    if ($pos !== false && $pos < $firstPos) {
                        $firstPos = $pos;
                    }
                }
            }

            $scores[$emotion]    = $count;
            $positions[$emotion] = $firstPos;
        }

        // 5️ Puntaje máximo
        $maxScore = max($scores);

        if ($maxScore === 0) {
            return [
                'emotion'    => 'neutral',
                'intensity'  => 1,
                'all_scores' => $scores,
            ];
        }

        // 6️ Si hay empate → gana la que aparece primero en el texto
        $topEmotions = array_keys(array_filter($scores, fn($s) => $s === $maxScore));
        $dominant    = $topEmotions[0];
        foreach ($topEmotions as $emotion) {
            if ($positions[$emotion] < $positions[$dominant]) {
                $dominant = $emotion;
            }
        }

        // 7️ Intensidad del 1 al 10
        $intensity = min(10, max(1, (int)($maxScore / 2)));

        return [
            'emotion'    => $dominant,
            'intensity'  => $intensity,
            'all_scores' => $scores,
        ];
    }

    public function getColor(string $emotion): string
    {
        return [
            'ira'        => '#FF4444',
            'miedo'      => '#9B59B6',
            'asco'       => '#27AE60',
            'tristeza'   => '#3498DB',
            'felicidad'  => '#F39C12',
            'sorpresa'   => '#F1C40F',
            'neutral'    => '#808080',
        ][$emotion] ?? '#808080';
    }

    public function getEmoji(string $emotion): string
    {
        return [
            'ira'        => '😡',
            'miedo'      => '😨',
            'asco'       => '🤢',
            'tristeza'   => '😢',
            'felicidad'  => '😊',
            'sorpresa'   => '😲',
            'neutral'    => '😐',
        ][$emotion] ?? '😐';
    }
}
