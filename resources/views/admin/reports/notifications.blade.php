<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Notificaciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script>
function toggleTheme() {
    const btn = document.getElementById('themeBtn');

    if (document.body.classList.contains('light')) {
        document.body.classList.remove('light');
        if (btn) btn.textContent = '🌙';
        localStorage.setItem('theme', 'dark');
    } else {
        document.body.classList.add('light');
        if (btn) btn.textContent = '☀️';
        localStorage.setItem('theme', 'light');
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

        :root { --bg:#0a0a0f; --surface:#12121a; --border:#1e1e2e; --accent1:#c084fc; --accent2:#f472b6; --text:#e2e2f0; --muted:#6b6b8a; }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;padding:2rem 1rem;}
        body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse 60% 50% at 20% 20%,rgba(192,132,252,0.08) 0%,transparent 60%),radial-gradient(ellipse 50% 60% at 80% 80%,rgba(244,114,182,0.06) 0%,transparent 60%);pointer-events:none;z-index:0;}
        .container{position:relative;z-index:1;max-width:800px;margin:0 auto;}
        .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;}
        .brand{font-family:'Playfair Display',serif;font-size:1.5rem;background:linear-gradient(135deg,var(--accent1),var(--accent2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        .nav-links{display:flex;gap:1rem;}
        .nav-links a{color:var(--muted);text-decoration:none;font-size:0.85rem;transition:color 0.2s;}
        .nav-links a:hover{color:var(--accent1);}
        .page-title{font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:0.4rem;}
        .page-subtitle{color:var(--muted);font-size:0.9rem;margin-bottom:2rem;}

        /* Alert */
        .alert{padding:0.9rem 1.2rem;border-radius:12px;margin-bottom:1.5rem;font-size:0.88rem;}
        .alert-success{background:rgba(39,174,96,0.15);border:1px solid rgba(39,174,96,0.3);color:#2ecc71;}

        /* Formulario */
        .card{background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:1.5rem;margin-bottom:1.5rem;}
        .card-title{font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:1.2rem;padding-bottom:0.8rem;border-bottom:1px solid var(--border);}
        .form-grid{display:grid;grid-template-columns:1fr auto;gap:1rem;align-items:end;}
        @media(max-width:560px){.form-grid{grid-template-columns:1fr;}}
        .form-group{display:flex;flex-direction:column;gap:0.4rem;}
        .form-group label{font-size:0.78rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;}
        .form-input,.form-select{width:100%;padding:0.75rem 1rem;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:10px;color:var(--text);font-family:'DM Sans',sans-serif;font-size:0.9rem;outline:none;transition:border-color 0.2s;}
        .form-input:focus,.form-select:focus{border-color:var(--accent1);}
        .form-select option{background:#12121a;}
        .form-row{display:grid;grid-template-columns:1fr 180px;gap:1rem;margin-bottom:1rem;}
        @media(max-width:560px){.form-row{grid-template-columns:1fr;}}
        .btn-primary{padding:0.75rem 1.5rem;background:linear-gradient(135deg,var(--accent1),var(--accent2));border:none;border-radius:10px;color:#fff;font-family:'DM Sans',sans-serif;font-size:0.88rem;cursor:pointer;white-space:nowrap;}
        .btn-primary:hover{opacity:0.88;}

        /* Filtros tipo */
        .tipo-filters{display:flex;gap:0.5rem;margin-bottom:1.2rem;flex-wrap:wrap;}
        .tipo-badge{padding:0.3rem 0.9rem;border-radius:100px;font-size:0.78rem;border:1px solid var(--border);color:var(--muted);cursor:pointer;text-decoration:none;transition:all 0.2s;}
        .tipo-badge.active,.tipo-badge:hover{border-color:var(--accent1);color:var(--accent1);}

        /* Lista notificaciones */
        .notif-list{display:flex;flex-direction:column;gap:0.7rem;}
        .notif-item{background:rgba(255,255,255,0.02);border:1px solid var(--border);border-radius:14px;padding:1rem 1.2rem;display:flex;align-items:center;gap:1rem;transition:border-color 0.2s;}
        .notif-item:hover{border-color:rgba(192,132,252,0.3);}
        .notif-item.inactivo{opacity:0.45;}
        .notif-tipo{padding:0.2rem 0.7rem;border-radius:100px;font-size:0.72rem;font-weight:500;text-transform:uppercase;letter-spacing:0.06em;flex-shrink:0;}
        .tipo-general{background:rgba(192,132,252,0.15);color:#c084fc;border:1px solid rgba(192,132,252,0.3);}
        .tipo-racha{background:rgba(255,107,53,0.15);color:#FF6B35;border:1px solid rgba(255,107,53,0.3);}
        .tipo-recordatorio{background:rgba(52,152,219,0.15);color:#3498DB;border:1px solid rgba(52,152,219,0.3);}
        .notif-msg{flex:1;font-size:0.88rem;line-height:1.5;}
        .notif-actions{display:flex;gap:0.5rem;flex-shrink:0;}
        .btn-toggle{padding:0.35rem 0.8rem;border-radius:8px;font-size:0.75rem;cursor:pointer;border:1px solid;font-family:'DM Sans',sans-serif;transition:opacity 0.2s;}
        .btn-toggle.on{background:rgba(39,174,96,0.15);border-color:rgba(39,174,96,0.4);color:#2ecc71;}
        .btn-toggle.off{background:rgba(108,108,138,0.15);border-color:var(--border);color:var(--muted);}
        .btn-delete{padding:0.35rem 0.7rem;border-radius:8px;font-size:0.75rem;cursor:pointer;border:1px solid rgba(255,68,68,0.3);background:rgba(255,68,68,0.1);color:#FF4444;font-family:'DM Sans',sans-serif;}
        .empty-state{text-align:center;padding:2.5rem;color:var(--muted);font-size:0.9rem;}
        .counter{font-size:0.78rem;color:var(--muted);margin-bottom:1rem;}
        body.light {
    --bg: #f5f5f9;
    --surface: #ffffff;
    --border: #e5e7eb;
    --text: #1f2937;
    --muted: #6b7280;

    --accent1: #9333ea;
    --accent2: #ec4899;
}
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="brand">🎨 Vibes Art</div>
        <div class="nav-links">
            <a href="{{ route('admin.reports.index') }}">Reportes</a>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
    </div>

    <h1 class="page-title">🔔 Notificaciones</h1>
    <p class="page-subtitle">Gestiona los mensajes motivacionales que reciben los usuarios</p>

    @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- Formulario crear -->
    <div class="card">
        <div class="card-title">➕ Nueva notificación</div>
        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Mensaje</label>
                    <input type="text" name="mensaje" class="form-input"
                        placeholder="Ej: ¿Cómo te sientes hoy? 🌟"
                        value="{{ old('mensaje') }}" required maxlength="255">
                    @error('mensaje')<span style="color:#FF4444;font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="general"      {{ old('tipo')=='general'      ? 'selected' : '' }}>💜 General</option>
                        <option value="racha"        {{ old('tipo')=='racha'        ? 'selected' : '' }}>🔥 Racha</option>
                        <option value="recordatorio" {{ old('tipo')=='recordatorio' ? 'selected' : '' }}>🌙 Recordatorio</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-primary">Crear notificación</button>
        </form>
    </div>

    <!-- Lista -->
    <div class="card">
        <div class="card-title">📋 Mensajes configurados</div>

        <div class="tipo-filters">
            <span class="tipo-badge active">Todos ({{ $notifications->count() }})</span>
            <span class="tipo-badge">💜 General ({{ $notifications->where('tipo','general')->count() }})</span>
            <span class="tipo-badge">🔥 Racha ({{ $notifications->where('tipo','racha')->count() }})</span>
            <span class="tipo-badge">🌙 Recordatorio ({{ $notifications->where('tipo','recordatorio')->count() }})</span>
        </div>

        <div class="counter">
            {{ $notifications->where('activo',true)->count() }} activas · {{ $notifications->where('activo',false)->count() }} inactivas
        </div>

        <div class="notif-list">
            @forelse($notifications as $notif)
            <div class="notif-item {{ $notif->activo ? '' : 'inactivo' }}">

                <span class="notif-tipo tipo-{{ $notif->tipo }}">{{ $notif->tipo }}</span>

                <div class="notif-msg">{{ $notif->mensaje }}</div>

                <div class="notif-actions">
                    <!-- Toggle activo/inactivo -->
                    <form action="{{ route('admin.notifications.toggle', $notif->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-toggle {{ $notif->activo ? 'on' : 'off' }}">
                            {{ $notif->activo ? '✓ Activa' : '✗ Inactiva' }}
                        </button>
                    </form>
                    <!-- Eliminar -->
                    <form action="{{ route('admin.notifications.destroy', $notif->id) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar esta notificación?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete">🗑</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state">No hay notificaciones configuradas aún.</div>
            @endforelse
        </div>
    </div>

</div>
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
