<?php

namespace App\Services;

class EmotionDetectionService
{
    protected array $keywords = [
    'ira' => [
        'critico', 'critica', 'distante', 'frustrado', 'frustrada',
        'agresivo', 'agresiva', 'loco', 'loca',
        'lleno de odio', 'llena de odio',
        'amenazado', 'amenazada', 'herido', 'herida',
        'sarcastico', 'sarcastica', 'esceptico', 'esceptica',
        'desconfiado', 'desconfiada', 'introvertido', 'introvertida',
        'irritado', 'irritada', 'enfurecido', 'enfurecida',
        'hostil', 'provocador', 'provocadora', 'rabioso', 'rabiosa',
        'furioso', 'furiosa', 'ultrajado', 'ultrajada',
        'resentido', 'resentida', 'celoso', 'celosa',
        'atacado', 'atacada', 'devastado', 'devastada',
        'apenado', 'apenada', 'ira',
    ],

    'miedo' => [
        'humillado', 'humillada', 'rechazado', 'rechazada',
        'sumiso', 'sumisa', 'inseguro', 'insegura',
        'ansioso', 'ansiosa', 'asustado', 'asustada',
        'ridiculizado', 'ridiculizada', 'irrespetado', 'irrespetada',
        'alienado', 'alienada', 'marginado', 'marginada',
        'insignificante', 'inutil', 'inferior', 'insuficiente',
        'preocupado', 'preocupada', 'agobiado', 'agobiada',
        'espantado', 'espantada', 'aterrado', 'aterrada', 'miedo',
    ],

    'asco' => [
        'disconforme', 'decepcionado', 'decepcionada', 'horrible',
        'abstinencia', 'moralista', 'reacio', 'reacia',
        'repugnante', 'revoltoso', 'revoltosa', 'odioso', 'odiosa',
        'aversion', 'vacilante', 'asco',
    ],

    'tristeza' => [
        'triste', 'culpable', 'abandonado', 'abandonada',
        'desesperado', 'desesperada', 'deprimido', 'deprimida',
        'solo', 'sola', 'aburrido', 'aburrida',
        'arrepentido', 'arrepentida', 'avergonzado', 'avergonzada',
        'ignorado', 'ignorada', 'victimizado', 'victimizada',
        'desvalido', 'desvalida', 'vulnerable', 'melancolico', 'melancolica',
        'vacio', 'vacia', 'desamparado', 'desamparada',
        'aislado', 'aislada', 'apatico', 'apatica',
        'indiferente', 'despechado', 'despechada',
    ],

    'felicidad' => [
        'feliz', 'alegre', 'interesado', 'interesada',
        'orgulloso', 'orgullosa', 'aceptado', 'aceptada',
        'poderoso', 'poderosa', 'pacifico', 'pacifica',
        'intimo', 'intima', 'optimista', 'liberado', 'liberada',
        'euforico', 'euforica', 'entretenido', 'entretenida',
        'curioso', 'curiosa', 'importante', 'seguro', 'segura',
        'respetado', 'respetada', 'satisfecho', 'satisfecha',
        'valiente', 'provocativo', 'provocativa',
        'cariñoso', 'cariñosa', 'esperanzado', 'esperanzada',
        'sensible', 'bromista', 'abierto', 'abierta',
        'inspirado', 'inspirada', 'felicidad',
    ],

    'sorpresa' => [
        'sorprendido', 'sorprendida', 'confundido', 'confundida',
        'asombrado', 'asombrada', 'entusiasmado', 'entusiasmada',
        'conmocionado', 'conmocionada', 'abatido', 'abatida',
        'desilusionado', 'desilusionada', 'perplejo', 'perpleja',
        'estupefacto', 'estupefacta', 'impresionado', 'impresionada',
        'entusiasta', 'energico', 'energica', 'sorpresa',
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
    protected array $crisisKeywords = [
    'suicidarme', 'suicidio', 'suicidar', 'matarme', 'matar',
    'no quiero vivir', 'quiero morir', 'mejor muerto', 'mejor muerta',
    'quitarme la vida', 'acabar con mi vida', 'hacerme daño',
    'cortarme', 'lastimarme', 'no vale la pena vivir',
    'desaparecer para siempre', 'no quiero seguir',
];

public function isCrisis(string $text): bool
{
    $lowerText = strtolower($text);
    $lowerText = str_replace(
        ['á','é','í','ó','ú','ü','ñ'],
        ['a','e','i','o','u','u','n'],
        $lowerText
    );

    foreach ($this->crisisKeywords as $word) {
        $wordNorm = str_replace(
            ['á','é','í','ó','ú','ü','ñ'],
            ['a','e','i','o','u','u','n'],
            strtolower($word)
        );
        if (str_contains($lowerText, $wordNorm)) {
            return true;
        }
    }
    return false;
}
}
