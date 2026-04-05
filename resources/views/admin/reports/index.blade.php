<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Reportes</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg: #0a0a0f; --surface: #12121a; --border: #1e1e2e;
            --accent1: #c084fc; --accent2: #f472b6;
            --text: #e2e2f0; --muted: #6b6b8a;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; padding: 2rem 1rem; }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: radial-gradient(ellipse 60% 50% at 20% 20%, rgba(192,132,252,0.08) 0%, transparent 60%),
                        radial-gradient(ellipse 50% 60% at 80% 80%, rgba(244,114,182,0.06) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .container { position: relative; z-index: 1; max-width: 1000px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .brand { font-family: 'Playfair Display', serif; font-size: 1.5rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .nav-links { display: flex; gap: 1rem; }
        .nav-links a { color: var(--muted); text-decoration: none; font-size: 0.85rem; transition: color 0.2s; }
        .nav-links a:hover { color: var(--accent1); }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 0.4rem; }
        .page-subtitle { color: var(--muted); font-size: 0.9rem; margin-bottom: 2rem; }

        /* Stats rápidas */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.2rem 1.5rem; }
        .stat-num { font-family: 'Playfair Display', serif; font-size: 2rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .stat-label { font-size: 0.78rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 0.2rem; }

        /* Cards */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 1.5rem; margin-bottom: 1.5rem; }
        .card-title { font-family: 'Playfair Display', serif; font-size: 1.1rem; margin-bottom: 1.2rem;
            padding-bottom: 0.8rem; border-bottom: 1px solid var(--border); }

        /* Grid 2 columnas */
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
        @media(max-width: 640px) { .two-col { grid-template-columns: 1fr; } }

        /* Barras de emociones */
        .emotion-bars { display: flex; flex-direction: column; gap: 0.7rem; }
        .emotion-bar-item { display: flex; align-items: center; gap: 0.8rem; }
        .emotion-bar-label { width: 90px; font-size: 0.82rem; color: var(--muted); text-align: right; flex-shrink: 0; }
        .emotion-bar-track { flex: 1; height: 10px; background: var(--border); border-radius: 100px; overflow: hidden; }
        .emotion-bar-fill { height: 100%; border-radius: 100px; transition: width 1s ease; }
        .emotion-bar-count { width: 36px; font-size: 0.78rem; color: var(--muted); flex-shrink: 0; }

        /* Top usuarios */
        .user-list { display: flex; flex-direction: column; gap: 0.6rem; }
        .user-item { display: flex; align-items: center; gap: 0.8rem;
            padding: 0.7rem 1rem; background: rgba(255,255,255,0.02);
            border: 1px solid var(--border); border-radius: 10px; }
        .user-rank { font-family: 'Playfair Display', serif; font-size: 1.1rem; width: 24px;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .user-name { flex: 1; font-size: 0.88rem; }
        .user-count { font-size: 0.78rem; color: var(--muted); }

        /* Intensidad promedio */
        .intensity-list { display: flex; flex-direction: column; gap: 0.6rem; }
        .intensity-item { display: flex; align-items: center; gap: 0.8rem; }
        .intensity-emoji { font-size: 1.2rem; width: 28px; text-align: center; }
        .intensity-name { width: 80px; font-size: 0.82rem; color: var(--muted); }
        .intensity-track { flex: 1; height: 8px; background: var(--border); border-radius: 100px; overflow: hidden; }
        .intensity-fill { height: 100%; border-radius: 100px; }
        .intensity-val { width: 36px; font-size: 0.78rem; color: var(--muted); text-align: right; }

        canvas { max-height: 220px; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="brand">🎨 Vibes Art</div>
        <div class="nav-links">
            <a href="{{ route('admin.notifications') }}">Notificaciones</a>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
    </div>

    <h1 class="page-title">📊 Reportes Generales</h1>
    <p class="page-subtitle">Tendencias emocionales anónimas de la plataforma</p>

    <!-- Stats rápidas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-num">{{ $totalRegistros }}</div>
            <div class="stat-label">Registros totales</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $emocionesGlobales->count() }}</div>
            <div class="stat-label">Emociones detectadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $topUsuarios->count() }}</div>
            <div class="stat-label">Usuarios activos</div>
        </div>
        <div class="stat-card">
            @php $top = $emocionesGlobales->first(); @endphp
            <div class="stat-num" style="font-size:1.4rem;">
                @php
                    $emojis = ['ira'=>'😡','miedo'=>'😨','asco'=>'🤢','tristeza'=>'😢','felicidad'=>'😊','sorpresa'=>'😲','neutral'=>'😐'];
                @endphp
                {{ $emojis[$top->emocion_amo] ?? '😐' }} {{ ucfirst($top->emocion_amo ?? '—') }}
            </div>
            <div class="stat-label">Emoción más frecuente</div>
        </div>
    </div>

    <!-- Gráfico por mes + Top usuarios -->
    <div class="two-col">
        <div class="card">
            <div class="card-title">📅 Registros por mes</div>
            <canvas id="monthChart"></canvas>
        </div>
        <div class="card">
            <div class="card-title">🏆 Usuarios más activos</div>
            <div class="user-list">
                @forelse($topUsuarios as $i => $user)
                <div class="user-item">
                    <div class="user-rank">{{ $i + 1 }}</div>
                    <div class="user-name">{{ $user->nombre_usu ?? $user->email }}</div>
                    <div class="user-count">{{ $user->emotions_count }} registros</div>
                </div>
                @empty
                <p style="color:var(--muted);font-size:0.88rem;">Sin datos aún.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Emociones predominantes + Intensidad promedio -->
    <div class="two-col">
        <div class="card">
            <div class="card-title">🎭 Emociones predominantes</div>
            @php
                $maxTotal = $emocionesGlobales->max('total') ?: 1;
                $colores  = ['ira'=>'#FF4444','miedo'=>'#9B59B6','asco'=>'#27AE60',
                             'tristeza'=>'#3498DB','felicidad'=>'#F39C12',
                             'sorpresa'=>'#F1C40F','neutral'=>'#808080'];
            @endphp
            <div class="emotion-bars">
                @foreach($emocionesGlobales as $emo)
                @php $pct = round(($emo->total / $maxTotal) * 100); $col = $colores[$emo->emocion_amo] ?? '#808080'; @endphp
                <div class="emotion-bar-item">
                    <div class="emotion-bar-label">{{ $emojis[$emo->emocion_amo] ?? '😐' }} {{ ucfirst($emo->emocion_amo) }}</div>
                    <div class="emotion-bar-track">
                        <div class="emotion-bar-fill" style="width:{{ $pct }}%;background:{{ $col }};"></div>
                    </div>
                    <div class="emotion-bar-count">{{ $emo->total }}</div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="card-title">🌡️ Intensidad promedio</div>
            <div class="intensity-list">
                @foreach($intensidadPromedio as $item)
                @php $col = $colores[$item->emocion_amo] ?? '#808080'; $pct = round(($item->promedio / 10) * 100); @endphp
                <div class="intensity-item">
                    <div class="intensity-emoji">{{ $emojis[$item->emocion_amo] ?? '😐' }}</div>
                    <div class="intensity-name">{{ ucfirst($item->emocion_amo) }}</div>
                    <div class="intensity-track">
                        <div class="intensity-fill" style="width:{{ $pct }}%;background:{{ $col }};"></div>
                    </div>
                    <div class="intensity-val">{{ number_format($item->promedio, 1) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Gráfico dona -->
    <div class="card">
        <div class="card-title">🍩 Distribución de emociones</div>
        <div style="max-width:320px;margin:0 auto;">
            <canvas id="donutChart"></canvas>
        </div>
    </div>

</div>

<script>
@php
    $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    $labelesMes = $emocionesPorMes->map(fn($e) => $meses[$e->mes - 1].' '.$e->anio)->values();
    $totalesMes = $emocionesPorMes->pluck('total')->values();
    $labelsEmo  = $emocionesGlobales->pluck('emocion_amo')->map(fn($e) => ucfirst($e))->values();
    $totalesEmo = $emocionesGlobales->pluck('total')->values();
    $coloresEmo = $emocionesGlobales->map(fn($e) => $colores[$e->emocion_amo] ?? '#808080')->values();
@endphp

// Gráfico por mes
new Chart(document.getElementById('monthChart'), {
    type: 'bar',
    data: {
        labels: @json($labelesMes),
        datasets: [{
            label: 'Registros',
            data: @json($totalesMes),
            backgroundColor: 'rgba(192,132,252,0.4)',
            borderColor: 'rgba(192,132,252,0.9)',
            borderWidth: 2, borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: '#6b6b8a' }, grid: { color: '#1e1e2e' } },
            y: { ticks: { color: '#6b6b8a' }, grid: { color: '#1e1e2e' } }
        }
    }
});

// Gráfico dona
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: @json($labelsEmo),
        datasets: [{
            data: @json($totalesEmo),
            backgroundColor: @json($coloresEmo),
            borderColor: '#12121a', borderWidth: 3,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: '#e2e2f0', font: { family: 'DM Sans' } } }
        }
    }
});
</script>
</body>
</html>
