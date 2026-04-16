<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Reportes</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
function toggleTheme() {
    const btn = document.getElementById('themeBtn');

    if (document.body.classList.contains('light')) {
        document.body.classList.remove('light');
        btn.textContent = '🌙';
        localStorage.setItem('theme', 'dark');
    } else {
        document.body.classList.add('light');
        btn.textContent = '☀️';
        localStorage.setItem('theme', 'light');
    }
    // 🔥 ESTO VA FUERA del if/else (MUY IMPORTANTE)
    if (typeof chart !== 'undefined') {
        chart.destroy();
        chart = crearGrafica();
    }
}

// aplicar tema al cargar
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('themeBtn');
    const theme = localStorage.getItem('theme');

    if (theme === 'light') {
        document.body.classList.add('light');
        if (btn) btn.textContent = '☀️';
    } else {
        document.body.classList.remove('light');
        if (btn) btn.textContent = '🌙';
    }
});
</script>

    <style>
        :root {
            --bg: #0a0a0f; --surface: #12121a; --border: #1e1e2e;
            --accent1: #c084fc; --accent2: #f472b6;
            --text: #e2e2f0; --muted: #6b6b8a;
            --chart-grid: #1e1e2e;
            --chart-text: #6b6b8a;
        }
        body.light {
    --bg: #f5f5f9;
    --surface: #ffffff;
    --border: #e5e7eb;
    --text: #1f2937;
    --muted: #6b7280;

    --accent1: #9333ea;
    --accent2: #ec4899;
    --chart-grid: #e5e7eb;
    --chart-text: #6b7280;
}
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; padding: 2rem 1rem; }
        body::before {
            content: ''; position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(192,132,252,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(244,114,182,0.06) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .container { position: relative; z-index: 1; max-width: 900px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .brand {
            font-family: 'Playfair Display', serif; font-size: 1.5rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .nav-links { display: flex; gap: 1rem; }
        .nav-links a { color: var(--muted); text-decoration: none; font-size: 0.85rem; transition: color 0.2s; }
        .nav-links a:hover { color: var(--accent1); }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 0.4rem; }
        .page-sub { color: var(--muted); font-size: 0.88rem; margin-bottom: 2rem; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 16px; padding: 1.4rem;
        }
        .stat-label { font-size: 0.75rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.5rem; }
        .stat-value { font-family: 'Playfair Display', serif; font-size: 2rem; }
        .stat-value.purple { background: linear-gradient(135deg, var(--accent1), var(--accent2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Cards */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 1.8rem; margin-bottom: 1.5rem; }
        .card-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 1.2rem; }

        /* Emociones */
        .emotion-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.9rem; }
        .emotion-row:last-child { margin-bottom: 0; }
        .emo-badge {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;
        }
        .emo-bar-wrap { flex: 1; }
        .emo-name { font-size: 0.85rem; margin-bottom: 0.25rem; text-transform: capitalize; }
        .emo-track { height: 8px; background: var(--border); border-radius: 100px; overflow: hidden; }
        .emo-fill { height: 100%; border-radius: 100px; }
        .emo-count { font-size: 0.82rem; color: var(--muted); min-width: 40px; text-align: right; }

        /* Top usuarios */
        .user-row {
            display: flex; align-items: center; gap: 1rem;
            padding: 0.75rem 0; border-bottom: 1px solid var(--border);
        }
        .user-row:last-child { border-bottom: none; }
        .user-rank { width: 28px; height: 28px; border-radius: 50%; background: var(--border); display: flex; align-items: center; justify-content: center; font-size: 0.78rem; font-weight: 600; flex-shrink: 0; }
        .user-rank.gold { background: linear-gradient(135deg, #FFD700, #FFA500); color: #000; }
        .user-rank.silver { background: linear-gradient(135deg, #C0C0C0, #A0A0A0); color: #000; }
        .user-rank.bronze { background: linear-gradient(135deg, #CD7F32, #A0522D); color: #fff; }
        .user-name { flex: 1; font-size: 0.9rem; }
        .user-count { font-size: 0.82rem; color: var(--muted); }

        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        @media (max-width: 640px) { .two-col { grid-template-columns: 1fr; } }

        .chart-wrap { position: relative; height: 220px; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="brand">🎨 Vibes Art</div>
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.notifications') }}">Notificaciones</a>
        </div>
    </div>

    <div class="page-title">📊 Reportes Emocionales</div>
    <div class="page-sub">Análisis global anónimo de emociones registradas en la plataforma.</div>

    <!-- Stats rápidas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Registros</div>
            <div class="stat-value purple">{{ number_format($totalRegistros) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Emociones Distintas</div>
            <div class="stat-value purple">{{ $emocionesGlobales->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Emoción #1</div>
            <div class="stat-value" style="font-size:1.4rem;text-transform:capitalize;">
                @if($emocionesGlobales->count())
                    {{ $emocionesGlobales->first()->emocion_amo }}
                @else —
                @endif
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Usuarios Activos</div>
            <div class="stat-value purple">{{ $topUsuarios->count() }}</div>
        </div>
    </div>

    <div class="two-col">
        <!-- Emociones globales -->
        <div class="card">
            <div class="card-title">Emociones Predominantes</div>
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
                $maxTotal = $emocionesGlobales->max('total') ?: 1;
            @endphp
            @forelse($emocionesGlobales as $item)
            @php
                $c = $colores[$item->emocion_amo] ?? '#808080';
                $e = $emojis[$item->emocion_amo] ?? '😐';
                $pct = round(($item->total / $maxTotal) * 100);
            @endphp
            <div class="emotion-row">
                <div class="emo-badge" style="background:{{ $c }}22;border:1px solid {{ $c }}44;">{{ $e }}</div>
                <div class="emo-bar-wrap">
                    <div class="emo-name">{{ $item->emocion_amo }}</div>
                    <div class="emo-track">
                        <div class="emo-fill" style="width:{{ $pct }}%;background:linear-gradient(90deg,{{ $c }}88,{{ $c }});"></div>
                    </div>
                </div>
                <div class="emo-count">{{ $item->total }}</div>
            </div>
            @empty
            <p style="color:var(--muted);font-size:0.88rem;">Sin datos aún.</p>
            @endforelse
        </div>

        <!-- Top usuarios -->
        <div class="card">
            <div class="card-title">Top Usuarios Activos</div>
            @forelse($topUsuarios as $i => $user)
            <div class="user-row">
                <div class="user-rank {{ $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : '')) }}">
                    {{ $i + 1 }}
                </div>
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-count">{{ $user->emotions_count }} registros</div>
            </div>
            @empty
            <p style="color:var(--muted);font-size:0.88rem;">Sin datos aún.</p>
            @endforelse
        </div>
    </div>

    <!-- Gráfico mensual -->
    <div class="card">
        <div class="card-title">Registros Últimos 6 Meses</div>
        <div class="chart-wrap">
            <canvas id="monthChart"></canvas>
        </div>
    </div>

    <!-- Intensidad promedio -->
    <div class="card">
        <div class="card-title">Intensidad Promedio por Emoción</div>
        @forelse($intensidadPromedio as $item)
        @php
            $c = $colores[$item->emocion_amo] ?? '#808080';
            $pct = round(($item->promedio / 10) * 100);
        @endphp
        <div class="emotion-row">
            <div class="emo-badge" style="background:{{ $c }}22;border:1px solid {{ $c }}44;">
                {{ $emojis[$item->emocion_amo] ?? '😐' }}
            </div>
            <div class="emo-bar-wrap">
                <div class="emo-name">{{ $item->emocion_amo }}</div>
                <div class="emo-track">
                    <div class="emo-fill" style="width:{{ $pct }}%;background:linear-gradient(90deg,{{ $c }}88,{{ $c }});"></div>
                </div>
            </div>
            <div class="emo-count">{{ number_format($item->promedio, 1) }}/10</div>
        </div>
        @empty
        <p style="color:var(--muted);font-size:0.88rem;">Sin datos aún.</p>
        @endforelse
    </div>

</div>

<script>
let chart;

function crearGrafica() {
    const styles = getComputedStyle(document.body);

    return new Chart(document.getElementById('monthChart'), {
        type: 'bar',
        data: {
            labels: @json($mesesLabels),
            datasets: [{
                label: 'Registros',
                data: @json($mesesTotales),
                backgroundColor: 'rgba(192,132,252,0.4)',
                borderColor: '#c084fc',
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: { color: styles.getPropertyValue('--muted') },
                    grid: { color: styles.getPropertyValue('--border') }
                },
                y: {
                    ticks: { color: styles.getPropertyValue('--muted') },
                    grid: { color: styles.getPropertyValue('--border') },
                    beginAtZero: true
                }
            }
        }
    });
}

// crear gráfica al cargar
document.addEventListener('DOMContentLoaded', () => {
    chart = crearGrafica();
});
</script>
<button onclick="toggleTheme()" id="themeBtn" style="
    position:fixed; bottom:1.5rem; right:1.5rem;
    width:48px; height:48px; border-radius:50%;
    background:var(--surface); border:1px solid var(--border);
    color:var(--text); font-size:1.3rem; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.3); z-index:999;">
    🌙
</button>
</body>
</html>
