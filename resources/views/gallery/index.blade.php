<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Mi Galería</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f; --surface: #12121a; --border: #1e1e2e;
            --accent1: #c084fc; --accent2: #f472b6;
            --text: #e2e2f0; --muted: #6b6b8a;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg); color: var(--text);
            min-height: 100vh; padding: 2rem 1rem;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(192,132,252,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(244,114,182,0.06) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .container { position: relative; z-index: 1; max-width: 800px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .brand {
            font-family: 'Playfair Display', serif; font-size: 1.5rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .nav-links { display: flex; gap: 1rem; }
        .nav-links a { color: var(--muted); text-decoration: none; font-size: 0.85rem; transition: color 0.2s; }
        .nav-links a:hover { color: var(--accent1); }

        /* ── Notificación ── */
        .notification-box {
            background: linear-gradient(135deg, rgba(192,132,252,0.1), rgba(244,114,182,0.1));
            border: 1px solid rgba(192,132,252,0.2);
            border-radius: 14px; padding: 1rem 1.2rem;
            margin-bottom: 1.5rem; font-size: 0.9rem;
            display: flex; align-items: center; gap: 0.8rem;
        }

        /* ── Racha ── */
        .streak-box {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 16px; padding: 1.2rem 1.5rem;
            display: flex; align-items: center; gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .streak-num {
            font-family: 'Playfair Display', serif; font-size: 1.8rem;
            background: linear-gradient(135deg, #FF6B35, #FFD700);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .streak-label { font-size: 0.82rem; color: var(--muted); }

        /* ── Emoción mensual ── */
        .monthly-box {
            border-radius: 16px; padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem; border: 1px solid;
            display: flex; align-items: center; gap: 1rem;
        }

        /* ── Navegación mes ── */
        .month-nav {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .month-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; }
        .btn-nav {
            padding: 0.4rem 1rem; background: var(--surface);
            border: 1px solid var(--border); border-radius: 8px;
            color: var(--muted); text-decoration: none; font-size: 0.85rem;
            transition: border-color 0.2s, color 0.2s;
        }
        .btn-nav:hover { border-color: var(--accent1); color: var(--accent1); }

        /* ── Grid de días ── */
        .days-grid {
            display: grid; grid-template-columns: repeat(7, 1fr);
            gap: 0.4rem; margin-bottom: 2rem;
        }
        .day-label {
            text-align: center; font-size: 0.72rem; color: var(--muted);
            text-transform: uppercase; padding: 0.3rem;
        }
        .day-cell {
            aspect-ratio: 1; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.82rem; border: 1px solid var(--border);
            background: var(--surface); text-decoration: none;
            color: var(--muted); transition: transform 0.2s;
        }
        .day-cell.has-emotion {
            border-color: transparent; color: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .day-cell.has-emotion:hover { transform: scale(1.1); }
        .day-cell.today { box-shadow: 0 0 0 2px var(--accent1); }
        .day-cell.empty { background: transparent; border-color: transparent; }

        /* ── Lista emociones ── */
        .emotions-list { display: flex; flex-direction: column; gap: 0.8rem; }
        .emotion-item {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 14px; padding: 1rem 1.2rem;
            display: flex; align-items: center; gap: 1rem;
            text-decoration: none; color: var(--text);
            transition: border-color 0.2s, transform 0.2s;
        }
        .emotion-item:hover { transform: translateX(4px); }
        .emotion-emoji { font-size: 1.8rem; }
        .emotion-info { flex: 1; }
        .emotion-name { font-weight: 500; font-size: 0.95rem; }
        .emotion-date { font-size: 0.78rem; color: var(--muted); margin-top: 0.2rem; }
        .intensity-dots { display: flex; gap: 2px; margin-top: 0.3rem; }
        .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--border); }
        .dot.active { background: var(--accent1); }

        .empty-state { text-align: center; padding: 3rem; color: var(--muted); }
        .empty-state .icon { font-size: 3rem; margin-bottom: 1rem; display: block; }
        .btn-primary {
            display: inline-block; padding: 0.7rem 1.5rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            border: none; border-radius: 10px; color: #fff;
            font-family: 'DM Sans', sans-serif; font-size: 0.88rem;
            text-decoration: none; transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.88; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="brand">🎨 Vibes Art</div>
        <div class="nav-links">
            <a href="{{ route('emotions.diary') }}">Mi diario</a>
            <a href="{{ route('home') }}">Inicio</a>
        </div>
    </div>

    <!-- HU014 - Notificación del día -->
    @if($notificacion)
    <div class="notification-box">
        <span style="font-size:1.3rem;">💜</span>
        <span>{{ $notificacion->mensaje }}</span>
    </div>
    @endif

    <!-- HU013 - Racha -->
    <div class="streak-box">
        <span style="font-size:2rem;">🔥</span>
        <div style="flex:1;">
            <div class="streak-num">{{ $streak->dias_racha }} días</div>
            <div class="streak-label">Racha actual de colores</div>
        </div>
        <div style="font-size:0.78rem;color:var(--muted);text-align:right;">
            Mejor racha<br>
            <strong style="color:var(--text);">{{ $streak->racha_maxima }} días</strong>
        </div>
    </div>

    <!-- HU012 - Emoción predominante mensual -->
    @if($emocionMensual)
    @php
        $colores = [
            'ira' => '#FF4444', 'miedo' => '#9B59B6', 'asco' => '#27AE60',
            'tristeza' => '#3498DB', 'felicidad' => '#F39C12',
            'sorpresa' => '#F1C40F', 'neutral' => '#808080',
        ];
        $emojis = [
            'ira' => '😡', 'miedo' => '😨', 'asco' => '🤢',
            'tristeza' => '😢', 'felicidad' => '😊',
            'sorpresa' => '😲', 'neutral' => '😐',
        ];
        $colorMensual = $colores[$emocionMensual] ?? '#808080';
        $emojiMensual = $emojis[$emocionMensual] ?? '😐';
    @endphp
    <div class="monthly-box" style="background:{{ $colorMensual }}11;border-color:{{ $colorMensual }}33;">
        <span style="font-size:2rem;">{{ $emojiMensual }}</span>
        <div>
            <div style="font-size:0.78rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;">Tu Vibe del mes</div>
            <div style="font-family:'Playfair Display',serif;font-size:1.3rem;color:{{ $colorMensual }};">
                {{ ucfirst($emocionMensual) }}
            </div>
        </div>
        <div style="margin-left:auto;font-size:0.82rem;color:var(--muted);">
            {{ $stats['total'] }}/{{ $stats['dias_mes'] }} días
        </div>
    </div>
    @endif

    <!-- Navegación de mes -->
    @php
        $mesAnterior  = \Carbon\Carbon::create($anio, $mes)->subMonth();
        $mesSiguiente = \Carbon\Carbon::create($anio, $mes)->addMonth();
        $nombreMes    = \Carbon\Carbon::create($anio, $mes)->locale('es')->isoFormat('MMMM YYYY');
    @endphp
    <div class="month-nav">
        <a href="{{ route('gallery.index', ['mes' => $mesAnterior->month, 'anio' => $mesAnterior->year]) }}" class="btn-nav">← Anterior</a>
        <div class="month-title">{{ ucfirst($nombreMes) }}</div>
        @if($mesSiguiente->lte(now()))
            <a href="{{ route('gallery.index', ['mes' => $mesSiguiente->month, 'anio' => $mesSiguiente->year]) }}" class="btn-nav">Siguiente →</a>
        @else
            <span class="btn-nav" style="opacity:0.3;">Siguiente →</span>
        @endif
    </div>

    <!-- HU011 - Grid calendario -->
    <div class="days-grid">
        @foreach(['L','M','X','J','V','S','D'] as $dia)
            <div class="day-label">{{ $dia }}</div>
        @endforeach

        @php
            $primerDia    = \Carbon\Carbon::create($anio, $mes, 1);
            $diasEnMes    = $primerDia->daysInMonth;
            $inicioSemana = $primerDia->dayOfWeek === 0 ? 6 : $primerDia->dayOfWeek - 1;
            $emocionPorDia = $emociones->keyBy(fn($e) => $e->fecha_emo->format('Y-m-d'));
        @endphp

        @for($i = 0; $i < $inicioSemana; $i++)
            <div class="day-cell empty"></div>
        @endfor

        @for($dia = 1; $dia <= $diasEnMes; $dia++)
            @php
                $fecha   = \Carbon\Carbon::create($anio, $mes, $dia)->format('Y-m-d');
                $emocion = $emocionPorDia[$fecha] ?? null;
                $esHoy   = $fecha === now()->format('Y-m-d');
                $colorDia = $emocion ? ($colores[$emocion->emocion_amo] ?? '#808080') : null;
            @endphp
            @if($emocion)
                <a href="{{ route('gallery.show', $emocion->id) }}"
                    class="day-cell has-emotion {{ $esHoy ? 'today' : '' }}"
                    style="background:{{ $colorDia }}44;border-color:{{ $colorDia }}66;"
                    title="{{ ucfirst($emocion->emocion_amo) }}">
                    {{ $dia }}
                </a>
            @else
                <div class="day-cell {{ $esHoy ? 'today' : '' }}">{{ $dia }}</div>
            @endif
        @endfor
    </div>

    <!-- Lista de emociones -->
    @if($emociones->count() > 0)
    <div class="emotions-list">
        @foreach($emociones as $emocion)
        @php
            $colorItem = $colores[$emocion->emocion_amo] ?? '#808080';
            $emojiItem = $emojis[$emocion->emocion_amo] ?? '😐';
        @endphp
        <a href="{{ route('gallery.show', $emocion->id) }}" class="emotion-item"
            style="border-left:3px solid {{ $colorItem }};">
            <span class="emotion-emoji">{{ $emojiItem }}</span>
            <div class="emotion-info">
                <div class="emotion-name">{{ ucfirst($emocion->emocion_amo) }}</div>
                <div class="emotion-date">
                    {{ $emocion->fecha_emo->locale('es')->isoFormat('dddd, D [de] MMMM') }}
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.78rem;color:var(--muted);">{{ $emocion->intensidad_emo }}/10</div>
                <div class="intensity-dots">
                    @for($i = 1; $i <= 10; $i++)
                        <div class="dot {{ $i <= $emocion->intensidad_emo ? 'active' : '' }}"
                            style="{{ $i <= $emocion->intensidad_emo ? 'background:'.$colorItem : '' }}">
                        </div>
                    @endfor
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <span class="icon">🎨</span>
        <p>No hay registros en este mes.</p>
        <br>
        <a href="{{ route('emotions.diary') }}" class="btn-primary">Crear mi primer Vibe</a>
    </div>
    @endif

</div>
</body>
</html>
