<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Inicio</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f; --surface: #12121a; --border: #1e1e2e;
            --accent1: #c084fc; --accent2: #f472b6; --accent3: #38bdf8;
            --text: #e2e2f0; --muted: #6b6b8a;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg); color: var(--text);
            min-height: 100vh; display: flex; flex-direction: column;
            align-items: center; justify-content: center; padding: 2rem;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(192,132,252,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(244,114,182,0.10) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        .container { position: relative; z-index: 1; text-align: center; max-width: 500px; width: 100%; }
        .emoji { font-size: 3.5rem; margin-bottom: 1rem; display: block; }
        h1 {
            font-family: 'Playfair Display', serif; font-size: 2.2rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; margin-bottom: 0.5rem;
        }
        p { color: var(--muted); font-size: 1rem; margin-bottom: 2rem; line-height: 1.6; }
        .cta-box {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 16px; padding: 1.5rem;
        }
        .user-name { font-size: 1.1rem; margin-bottom: 1.2rem; color: var(--text); }
        .user-name strong {
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-primary {
            display: block; width: 100%; padding: 0.85rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            border: none; border-radius: 12px; color: #fff;
            font-family: 'DM Sans', sans-serif; font-size: 0.95rem;
            font-weight: 500; cursor: pointer; text-decoration: none;
            transition: opacity 0.2s, transform 0.1s; margin-bottom: 0.8rem;
        }
        .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn-outline {
            display: block; width: 100%; padding: 0.85rem;
            background: transparent; border: 1px solid var(--border);
            border-radius: 12px; color: var(--muted);
            font-family: 'DM Sans', sans-serif; font-size: 0.9rem;
            cursor: pointer; text-decoration: none;
            transition: border-color 0.2s, color 0.2s; margin-bottom: 0.8rem;
        }
        .btn-outline:hover { border-color: var(--accent1); color: var(--accent1); }
        .btn-danger {
            display: block; width: 100%; padding: 0.85rem;
            background: transparent; border: 1px solid rgba(239,68,68,0.4);
            border-radius: 12px; color: #ef4444;
            font-family: 'DM Sans', sans-serif; font-size: 0.9rem;
            cursor: pointer; text-decoration: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .btn-danger:hover { border-color: #ef4444; background: rgba(239,68,68,0.1); }
    </style>
</head>
<body>
<div class="container">
    <span class="emoji">🎨</span>
    <h1>Vibes Art</h1>
    <p>Tu diario emocional creativo. Expresa cómo te sientes y conviértelo en arte.</p>

    <div class="cta-box">
        <div class="user-name">
            Hola, <strong>{{ Auth::user()->nom_user }}</strong> 👋
        </div>

        <a href="{{ route('emotions.diary') }}" class="btn-primary">
            ✍️ Escribir en mi diario
        </a>
        <a href="{{ route('gallery.index') }}" class="btn-primary">
            🖼️ Ver mi galería
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-outline">Cerrar sesión</button>
        </form>

        <form method="POST" action="{{ route('account.delete') }}"
            onsubmit="return confirm('¿Estás seguro? Esta acción eliminará tu cuenta y todos tus datos permanentemente.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">🗑️ Eliminar mi cuenta</button>
        </form>

    </div>
</div>
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
