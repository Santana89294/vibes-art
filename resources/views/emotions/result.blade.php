<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Tu Resultado</title>
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
                radial-gradient(ellipse 60% 50% at 20% 20%, {{ $color }}22 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, {{ $color }}15 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .container { position: relative; z-index: 1; max-width: 640px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .brand {
            font-family: 'Playfair Display', serif; font-size: 1.5rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .nav-links { display: flex; gap: 1rem; }
        .nav-links a { color: var(--muted); text-decoration: none; font-size: 0.85rem; transition: color 0.2s; }
        .nav-links a:hover { color: var(--accent1); }
        .art-canvas {
            width: 100%; height: 350px; border-radius: 20px;
            position: relative; overflow: hidden; margin-bottom: 1.5rem;
            border: 1px solid {{ $color }}44;
            box-shadow: 0 0 80px {{ $color }}44, 0 20px 40px rgba(0,0,0,0.5);
        }
        .art-canvas canvas { display: block; width: 100%; height: 100%; }
        .card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 20px; padding: 2rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3); margin-bottom: 1rem;
        }
        .emotion-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 1.2rem; background: {{ $color }}22;
            border: 1px solid {{ $color }}44; border-radius: 100px;
            font-size: 1rem; font-weight: 500; margin-bottom: 1rem; color: {{ $color }};
        }
        .emotion-title { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 0.5rem; }
        .emotion-subtitle { color: var(--muted); font-size: 0.9rem; margin-bottom: 1.5rem; }

        /* ── Emociones detectadas ── */
        .emotions-detected {
            display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;
        }
        .emotion-chip {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.3rem 0.7rem; border-radius: 100px;
            font-size: 0.78rem; font-weight: 500;
            border: 1px solid; transition: transform 0.2s;
        }
        .emotion-chip.dominant {
            padding: 0.4rem 1rem; font-size: 0.88rem;
            box-shadow: 0 0 15px currentColor;
        }

        .intensity-bar { margin-bottom: 1.5rem; }
        .intensity-label {
            display: flex; justify-content: space-between;
            font-size: 0.78rem; color: var(--muted);
            text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.5rem;
        }
        .intensity-track { height: 8px; background: var(--border); border-radius: 100px; overflow: hidden; }
        .intensity-fill {
            height: 100%; border-radius: 100px;
            background: linear-gradient(90deg, {{ $color }}88, {{ $color }});
            width: {{ $emotion->intensidad_emo * 10 }}%;
            animation: fillBar 1.5s ease-out;
        }
        @keyframes fillBar { from { width: 0%; } to { width: {{ $emotion->intensidad_emo * 10 }}%; } }
        .text-preview {
            background: rgba(255,255,255,0.03); border: 1px solid var(--border);
            border-radius: 12px; padding: 1rem; font-size: 0.88rem; color: var(--muted);
            line-height: 1.6; margin-bottom: 1.5rem; max-height: 100px;
            overflow: hidden; position: relative;
        }
        .text-preview::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 40px; background: linear-gradient(transparent, var(--surface));
        }
        .music-box {
            background: rgba(255,255,255,0.04); border: 1px solid var(--border);
            border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;
        }
        .music-info { display: flex; align-items: center; gap: 0.8rem; margin-bottom: 0.8rem; }
        .music-title { font-size: 0.9rem; font-weight: 500; }
        .music-artist { font-size: 0.78rem; color: var(--muted); }
        .btn-primary {
            width: 100%; padding: 0.9rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            border: none; border-radius: 12px; color: #fff;
            font-family: 'DM Sans', sans-serif; font-size: 0.95rem; font-weight: 500;
            cursor: pointer; transition: opacity 0.2s, transform 0.1s;
            text-decoration: none; display: block; text-align: center; margin-bottom: 0.8rem;
        }
        .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn-outline {
            width: 100%; padding: 0.9rem; background: transparent;
            border: 1px solid var(--border); border-radius: 12px; color: var(--muted);
            font-family: 'DM Sans', sans-serif; font-size: 0.95rem; cursor: pointer;
            text-decoration: none; display: block; text-align: center;
            transition: border-color 0.2s, color 0.2s;
        }
        .btn-outline:hover { border-color: var(--accent1); color: var(--accent1); }
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

    <!-- Arte abstracto -->
    <div class="art-canvas">
        <canvas id="artCanvas"></canvas>
    </div>

    <div class="card">
        <div class="emotion-badge">
            {{ $emoji }} {{ ucfirst($emotion->emocion_amo) }}
        </div>
        <h1 class="emotion-title">Tu Vibe de hoy</h1>
        <p class="emotion-subtitle">
            {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
        </p>

        <!-- Emociones detectadas -->
        @if(count($allEmotionColors) > 0)
        <div class="emotions-detected">
            @foreach($allEmotionColors as $emo => $data)
                <span class="emotion-chip {{ $emo === $emotion->emocion_amo ? 'dominant' : '' }}"
                    style="color:{{ $data['color'] }};border-color:{{ $data['color'] }}44;background:{{ $data['color'] }}11;">
                    {{ $data['emoji'] }} {{ ucfirst($emo) }}
                    @if($emo === $emotion->emocion_amo)
                        ★
                    @endif
                </span>
            @endforeach
        </div>
        @endif

        <!-- Intensidad -->
        <div class="intensity-bar">
            <div class="intensity-label">
                <span>Intensidad emocional</span>
                <span>{{ $emotion->intensidad_emo }}/10</span>
            </div>
            <div class="intensity-track">
                <div class="intensity-fill"></div>
            </div>
        </div>

        <div class="text-preview">{{ $emotion->texto_emo }}</div>

        @if($song)
        <div class="music-box">
            <div class="music-info">
                <span style="font-size:1.5rem;">🎵</span>
                <div>
                    <div class="music-title">{{ $song->nom_can }}</div>
                    <div class="music-artist">{{ $song->artista_can }} • {{ $song->genero_can }}</div>
                </div>
            </div>
            <a href="{{ $song->url_can }}" target="_blank"
                style="display:flex;align-items:center;justify-content:center;gap:0.5rem;
                width:100%;padding:0.75rem;background:rgba(255,0,0,0.15);
                border:1px solid rgba(255,0,0,0.3);border-radius:8px;
                color:#ff4444;text-decoration:none;font-size:0.88rem;">
                ▶ Escuchar en YouTube
            </a>
        </div>
        @endif

        <a href="{{ route('emotions.diary') }}" class="btn-primary">Actualizar mi Vibe ✍️</a>
        <a href="{{ route('home') }}" class="btn-outline">Volver al inicio</a>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    const canvas = document.getElementById('artCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    canvas.width  = canvas.offsetWidth  || 640;
    canvas.height = canvas.offsetHeight || 350;
    const W = canvas.width;
    const H = canvas.height;

    const dominantColor = '{{ $color }}';
    const intensity     = {{ $artConfig['intensity'] }};
    const particles     = {{ $artConfig['particles'] }};
    const allColors     = @json(array_column($allEmotionColors, 'color'));
    const allScores     = @json(array_column($allEmotionColors, 'score'));

    // Si no hay colores secundarios usar solo el dominante
    const colors = allColors.length > 0 ? allColors : [dominantColor];
    const totalScore = allScores.reduce((a, b) => a + b, 0) || 1;

    const rand = (min, max) => Math.random() * (max - min) + min;
    const randColor = () => colors[Math.floor(Math.random() * colors.length)];

    // Color ponderado según puntaje
    const weightedColor = () => {
        const r = Math.random() * totalScore;
        let acc = 0;
        for (let i = 0; i < colors.length; i++) {
            acc += allScores[i] || 1;
            if (r <= acc) return colors[i];
        }
        return dominantColor;
    };

    // ── Fondo ──
    const bgGrad = ctx.createLinearGradient(0, 0, W, H);
    bgGrad.addColorStop(0, '#0a0a0f');
    bgGrad.addColorStop(0.5, dominantColor + '18');
    bgGrad.addColorStop(1, '#0a0a0f');
    ctx.fillStyle = bgGrad;
    ctx.fillRect(0, 0, W, H);

    // Capas de fondo por cada emoción
    colors.forEach((color, i) => {
        const x = rand(0, W), y = rand(0, H), r = rand(60, 180);
        const grad = ctx.createRadialGradient(x, y, 0, x, y, r);
        grad.addColorStop(0, color + '44');
        grad.addColorStop(1, color + '00');
        ctx.fillStyle = grad;
        ctx.beginPath();
        ctx.arc(x, y, r, 0, Math.PI * 2);
        ctx.fill();
    });

    // ── Formas orgánicas ──
    const drawOrganic = (x, y, size, color, dominant) => {
        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(rand(0, Math.PI * 2));
        ctx.beginPath();
        const pts = dominant ? 8 : 5;
        for (let i = 0; i <= pts; i++) {
            const angle = (i / pts) * Math.PI * 2;
            const r = size * (0.5 + Math.random() * 0.9);
            const px = Math.cos(angle) * r;
            const py = Math.sin(angle) * r;
            i === 0 ? ctx.moveTo(px, py) : ctx.quadraticCurveTo(
                Math.cos(angle - 0.3) * r * 1.3,
                Math.sin(angle - 0.3) * r * 1.3,
                px, py
            );
        }
        ctx.closePath();
        const grad = ctx.createRadialGradient(0, 0, 0, 0, 0, size);
        grad.addColorStop(0, color + (dominant ? 'ee' : 'aa'));
        grad.addColorStop(1, color + '22');
        ctx.fillStyle = grad;
        ctx.fill();
        if (dominant) {
            ctx.strokeStyle = color + 'cc';
            ctx.lineWidth = 2;
            ctx.stroke();
            // Brillo extra para la dominante
            ctx.shadowColor = color;
            ctx.shadowBlur = 20;
            ctx.stroke();
            ctx.shadowBlur = 0;
        }
        ctx.restore();
    };

    // ── Espirales ──
    const drawSpiral = (x, y, color, dominant) => {
        ctx.save();
        ctx.translate(x, y);
        ctx.beginPath();
        const maxAngle = Math.PI * (dominant ? intensity * 3 : intensity);
        for (let a = 0; a < maxAngle; a += 0.08) {
            const r = a * (dominant ? intensity * 2 : intensity);
            const px = Math.cos(a) * r;
            const py = Math.sin(a) * r;
            a === 0 ? ctx.moveTo(px, py) : ctx.lineTo(px, py);
        }
        ctx.strokeStyle = color + (dominant ? 'ee' : '77');
        ctx.lineWidth = dominant ? rand(2, 4) : rand(1, 2);
        if (dominant) {
            ctx.shadowColor = color;
            ctx.shadowBlur = 15;
        }
        ctx.stroke();
        ctx.shadowBlur = 0;
        ctx.restore();
    };

    // ── Círculos concéntricos ──
    const drawConcentric = (x, y, maxR, color, dominant) => {
        const rings = dominant ? 7 : 4;
        for (let r = maxR; r > 5; r -= maxR / rings) {
            ctx.beginPath();
            ctx.arc(x, y, r, 0, Math.PI * 2);
            ctx.strokeStyle = color + (dominant ? 'cc' : '66');
            ctx.lineWidth = dominant ? rand(1.5, 3) : rand(0.5, 1.5);
            if (dominant) {
                ctx.shadowColor = color;
                ctx.shadowBlur = 8;
            }
            ctx.stroke();
            ctx.shadowBlur = 0;
        }
    };

    // ── Rectángulos rotados ──
    const drawRect = (x, y, w, h, color) => {
        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(rand(0, Math.PI));
        ctx.strokeStyle = color + '99';
        ctx.lineWidth = rand(1, 2.5);
        ctx.strokeRect(-w/2, -h/2, w, h);
        ctx.fillStyle = color + '18';
        ctx.fillRect(-w/2, -h/2, w, h);
        ctx.restore();
    };

    // ── Triángulos ──
    const drawTriangle = (x, y, size, color, dominant) => {
        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(rand(0, Math.PI * 2));
        ctx.beginPath();
        ctx.moveTo(0, -size);
        ctx.lineTo(size * 0.866, size * 0.5);
        ctx.lineTo(-size * 0.866, size * 0.5);
        ctx.closePath();
        ctx.fillStyle = color + (dominant ? '66' : '33');
        ctx.fill();
        ctx.strokeStyle = color + (dominant ? 'ee' : '77');
        ctx.lineWidth = dominant ? 2.5 : 1;
        ctx.stroke();
        ctx.restore();
    };

    // ── Líneas dinámicas ──
    const drawLine = (color) => {
        ctx.beginPath();
        ctx.moveTo(rand(0, W), rand(0, H));
        for (let i = 0; i < 3; i++) {
            ctx.bezierCurveTo(
                rand(0, W), rand(0, H),
                rand(0, W), rand(0, H),
                rand(0, W), rand(0, H)
            );
        }
        ctx.strokeStyle = color + '66';
        ctx.lineWidth = rand(0.5, intensity * 0.5);
        ctx.stroke();
    };

    // ══ GENERAR ARTE ══

    // Formas secundarias primero (emociones no dominantes)
    for (let i = 0; i < Math.floor(particles/6); i++) {
        const c = weightedColor();
        const isDominant = c === dominantColor;
        drawOrganic(rand(0,W), rand(0,H), rand(15, 40+intensity*2), c, false);
    }

    // Rectángulos
    for (let i = 0; i < Math.floor(particles/10)+2; i++)
        drawRect(rand(0,W), rand(0,H), rand(15,60), rand(15,60), weightedColor());

    // Triángulos secundarios
    for (let i = 0; i < Math.floor(intensity/3)+1; i++)
        drawTriangle(rand(0,W), rand(0,H), rand(10,25), weightedColor(), false);

    // Líneas
    for (let i = 0; i < Math.floor(intensity)+3; i++)
        drawLine(weightedColor());

    // ── DOMINANTE — más grande y brillante ──
    const cx = W / 2, cy = H / 2;

    // Espiral dominante en el centro
    drawSpiral(cx + rand(-50,50), cy + rand(-50,50), dominantColor, true);

    // Círculos concéntricos dominantes
    for (let i = 0; i < 2; i++)
        drawConcentric(
            cx + rand(-80,80), cy + rand(-80,80),
            rand(50, 80+intensity*5),
            dominantColor, true
        );

    // Formas orgánicas dominantes grandes
    for (let i = 0; i < 3; i++)
        drawOrganic(
            rand(W*0.2, W*0.8), rand(H*0.2, H*0.8),
            rand(50, 90+intensity*6),
            dominantColor, true
        );

    // Triángulos dominantes
    for (let i = 0; i < Math.floor(intensity/2)+1; i++)
        drawTriangle(rand(0,W), rand(0,H), rand(20,45), dominantColor, true);

    // Capa de brillo final sobre la dominante
    const glowGrad = ctx.createRadialGradient(cx, cy, 0, cx, cy, W*0.4);
    glowGrad.addColorStop(0, dominantColor + '22');
    glowGrad.addColorStop(1, 'transparent');
    ctx.fillStyle = glowGrad;
    ctx.fillRect(0, 0, W, H);
});
</script>
</body>
</html>
