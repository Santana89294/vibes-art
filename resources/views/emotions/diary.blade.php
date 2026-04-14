<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Mi Diario</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f; --surface: #12121a; --border: #1e1e2e;
            --accent1: #c084fc; --accent2: #f472b6; --accent3: #38bdf8;
            --text: #e2e2f0; --muted: #6b6b8a; --success: #4ade80;
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
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(192,132,252,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(244,114,182,0.10) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .container {
            position: relative; z-index: 1;
            max-width: 640px; margin: 0 auto;
        }
        .header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 2rem;
        }
        .brand {
            font-family: 'Playfair Display', serif; font-size: 1.5rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-links { display: flex; gap: 1rem; }
        .nav-links a {
            color: var(--muted); text-decoration: none; font-size: 0.85rem;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--accent1); }
        .card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 20px; padding: 2rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        }
        .card-title {
            font-family: 'Playfair Display', serif; font-size: 1.6rem;
            margin-bottom: 0.4rem;
        }
        .card-subtitle { color: var(--muted); font-size: 0.9rem; margin-bottom: 1.8rem; }
        .date-badge {
            display: inline-block; padding: 0.3rem 0.8rem;
            background: rgba(192,132,252,0.12); border: 1px solid rgba(192,132,252,0.25);
            border-radius: 100px; color: var(--accent1);
            font-size: 0.78rem; text-transform: uppercase;
            letter-spacing: 0.08em; margin-bottom: 1.5rem;
        }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label {
            display: block; font-size: 0.78rem; color: var(--muted);
            text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.5rem;
        }
        textarea {
            width: 100%; padding: 1rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border); border-radius: 12px;
            color: var(--text); font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem; resize: vertical; min-height: 180px;
            outline: none; transition: border-color 0.2s, box-shadow 0.2s;
            line-height: 1.6;
        }
        textarea:focus {
            border-color: var(--accent1);
            box-shadow: 0 0 0 3px rgba(192,132,252,0.15);
        }
        textarea::placeholder { color: var(--muted); }
        .char-count {
            text-align: right; font-size: 0.78rem;
            color: var(--muted); margin-top: 0.3rem;
        }
        .error-msg { color: #f87171; font-size: 0.78rem; margin-top: 0.3rem; display: block; }
        .btn-primary {
            width: 100%; padding: 0.9rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            border: none; border-radius: 12px; color: #fff;
            font-family: 'DM Sans', sans-serif; font-size: 0.95rem;
            font-weight: 500; cursor: pointer;
            transition: opacity 0.2s, transform 0.1s; margin-top: 0.5rem;
        }
        .btn-primary:hover  { opacity: 0.88; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .alert-success {
            padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1.2rem;
            background: rgba(74,222,128,0.1); border: 1px solid rgba(74,222,128,0.3);
            color: var(--success); font-size: 0.85rem;
        }
        .existing-emotion {
            background: rgba(192,132,252,0.08); border: 1px solid rgba(192,132,252,0.2);
            border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;
        }
        .existing-emotion p { font-size: 0.85rem; color: var(--muted); }
        .existing-emotion strong { color: var(--accent1); }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <div class="header">
        <div class="brand">🎨 Vibes Art</div>
        <div class="nav-links">
            <a href="{{ route('home') }}">Inicio</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:0.85rem;">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="date-badge">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM') }}</div>

        <h1 class="card-title">¿Cómo te sientes hoy? ✍️</h1>
        <p class="card-subtitle">Escribe libremente — sin filtros, sin juicios. Este es tu espacio.</p>

        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif

        @if($todayEmotion)
            <div class="existing-emotion">
                <p>Ya registraste una emoción hoy —
                    <strong>{{ ucfirst($todayEmotion->emocion_amo) }}</strong>.
                    Puedes actualizarla escribiendo de nuevo.
                </p>
            </div>
        @endif

        <form method="POST" action="{{ route('emotions.store') }}">
            @csrf

            <div class="form-group">
                <label for="texto_emo">Tu diario emocional</label>
                <textarea
                    id="texto_emo"
                    name="texto_emo"
                    placeholder="Hoy me siento... Pasó algo que... Lo que más me preocupa es..."
                    maxlength="1000"
                    oninput="updateCount(this)"
                >{{ old('texto_emo', $todayEmotion?->texto_emo) }}</textarea>
                <div class="char-count"><span id="charCount">0</span>/1000</div>
                @error('texto_emo')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-primary">
                Generar mi Vibe 🎨
            </button>
        </form>
    </div>
</div>

<script>
    function updateCount(el) {
        document.getElementById('charCount').textContent = el.value.length;
    }
    // Inicializar contador
    const ta = document.getElementById('texto_emo');
    if (ta) document.getElementById('charCount').textContent = ta.value.length;
</script>
<button onclick="toggleTheme()" id="themeBtn" style="
    position:fixed; bottom:1.5rem; right:1.5rem;
    width:48px; height:48px; border-radius:50%;
    background:var(--surface); border:1px solid var(--border);
    color:var(--text); font-size:1.3rem; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.3); z-index:999;
    transition: transform 0.2s;">
    🌙
</button>

<script>
function toggleTheme() {
    const root = document.documentElement;
    const btn = document.getElementById('themeBtn');
    if (document.body.classList.contains('light-mode')) {
        document.body.classList.remove('light-mode');
        btn.textContent = '🌙';
        localStorage.setItem('theme', 'dark');
    } else {
        document.body.classList.add('light-mode');
        btn.textContent = '☀️';
        localStorage.setItem('theme', 'light');
    }
}
// Aplicar tema guardado
if (localStorage.getItem('theme') === 'light') {
    document.body.classList.add('light-mode');
    document.getElementById('themeBtn').textContent = '☀️';
}
</script>

<style>
body.light-mode {
    --bg: #f5f5f5;
    --surface: #ffffff;
    --border: #e0e0e0;
    --text: #1a1a2e;
    --muted: #666680;
}
</style>
</body>
</html>
