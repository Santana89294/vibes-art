<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Vibes Art | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>

        :root {
            --bg:       #08080e;
            --surface:  #10101a;
            --card:     #14141f;
            --border:   #1c1c2e;
            --accent1:  #c084fc;
            --accent2:  #f472b6;
            --accent3:  #38bdf8;
            --text:     #e2e2f0;
            --muted:    #6b6b8a;
            --error:    #f87171;
            --success:  #4ade80;
            --warning:  #fbbf24;
            --sidebar-w: 240px;
        }
        body.light {
    --bg:       #f5f5f9;
    --surface:  #ffffff;
    --card:     #ffffff;
    --border:   #e5e7eb;
    --text:     #1f2937;
    --muted:    #6b7280;

    --accent1:  #9333ea;
    --accent2:  #ec4899;
    --accent3:  #0284c7;

    --error:    #dc2626;
    --success:  #16a34a;
    --warning:  #d97706;
}
        /* 🔥 FORZAR COLORES GLOBALES */
body,
.sidebar,
.main,
.card,
.stat-card,
table,
th,
td,
input,
select {
    background: var(--bg);
    color: var(--text);
}

/* superficies */
.sidebar,
.card,
.stat-card {
    background: var(--surface);
}

/* inputs */
input, select {
    background: var(--card);
    color: var(--text);
    border: 1px solid var(--border);
}

/* tablas */
th, td {
    border-color: var(--border);
}

/* hover filas */
tr:hover td {
    background: rgba(0,0,0,0.05);
}

/* modo oscuro hover fix */
body:not(.light) tr:hover td {
    background: rgba(255,255,255,0.02);
}
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 1.5rem 1rem;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
        }
        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.3rem;
        }
        .sidebar-sub {
            font-size: 0.72rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 2rem;
        }
        .nav-label {
            font-size: 0.68rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 0 0.5rem;
            margin-bottom: 0.5rem;
            margin-top: 1rem;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.6rem 0.75rem;
            border-radius: 10px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.88rem;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 0.2rem;
        }
        .nav-item:hover, .nav-item.active {
            background: rgba(192,132,252,0.1);
            color: var(--accent1);
        }
        .nav-item .icon { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid var(--border);
            padding-top: 1rem;
        }
        .admin-info { font-size: 0.8rem; color: var(--muted); margin-bottom: 0.8rem; }
        .admin-info strong { color: var(--text); display: block; }

        /* ── Main content ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 2rem 2.5rem;
            max-width: calc(100vw - var(--sidebar-w));
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--text);
        }
        .page-title span { color: var(--muted); font-family: 'DM Sans', sans-serif; font-size: 0.85rem; font-weight: 400; display: block; margin-top: 0.2rem; }

        /* ── Cards ── */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.5rem;
        }

        /* ── Stat cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.2rem;
            text-align: center;
        }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stat-label { font-size: 0.78rem; color: var(--muted); margin-top: 0.3rem; text-transform: uppercase; letter-spacing: 0.05em; }

        /* ── Table ── */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--muted);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            font-size: 0.88rem;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,0.02); }

        /* ── Badges ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.65rem;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .badge-active   { background: rgba(74,222,128,0.15); color: var(--success); }
        .badge-blocked  { background: rgba(248,113,113,0.15); color: var(--error); }
        .badge-admin    { background: rgba(192,132,252,0.15); color: var(--accent1); }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.9rem;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: opacity 0.2s, transform 0.1s;
        }
        .btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .btn-sm { padding: 0.35rem 0.7rem; font-size: 0.78rem; }
        .btn-gradient { background: linear-gradient(135deg, var(--accent1), var(--accent2)); color: #fff; }
        .btn-danger  { background: rgba(248,113,113,0.15); color: var(--error); border: 1px solid rgba(248,113,113,0.3); }
        .btn-warning { background: rgba(251,191,36,0.15);  color: var(--warning); border: 1px solid rgba(251,191,36,0.3); }
        .btn-outline { background: transparent; color: var(--muted); border: 1px solid var(--border); }

        /* ── Form styles ── */
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-size: 0.78rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.4rem; }
        .form-group input, .form-group select {
            width: 100%; padding: 0.7rem 0.9rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus, .form-group select:focus { border-color: var(--accent1); }
        .error-msg { color: var(--error); font-size: 0.78rem; margin-top: 0.3rem; display: block; }

        /* ── Alert ── */
        .alert { padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1.2rem; font-size: 0.85rem; }
        .alert-success { background: rgba(74,222,128,0.1); border: 1px solid rgba(74,222,128,0.3); color: var(--success); }
        .alert-error   { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.3); color: var(--error); }

        /* ── Search bar ── */
        .search-bar { display: flex; gap: 0.8rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center; }
        .search-bar input, .search-bar select {
            padding: 0.6rem 1rem;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            outline: none;
        }
        .search-bar input { flex: 1; min-width: 200px; }
        .search-bar input:focus { border-color: var(--accent1); }

        /* ── Pagination ── */
        .pagination { display: flex; gap: 0.4rem; margin-top: 1.5rem; justify-content: center; }
        .pagination a, .pagination span {
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.82rem;
            text-decoration: none;
            color: var(--muted);
            border: 1px solid var(--border);
        }
        .pagination a:hover { border-color: var(--accent1); color: var(--accent1); }
        .pagination .active span { background: linear-gradient(135deg, var(--accent1), var(--accent2)); color: #fff; border-color: transparent; }
        body.light .stat-num,
body.light .sidebar-brand {
    -webkit-text-fill-color: initial;
    color: var(--accent1);
    background: none;
}
    </style>
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#c084fc">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Vibes Art">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW registrado'))
                    .catch(err => console.log('SW error:', err));
            });
        }
    </script>
</head>
<body>

<!-- ── Sidebar ── -->
<aside class="sidebar">
    <div class="sidebar-brand">🎨 Vibes Art</div>
    <div class="sidebar-sub">Panel Administrador</div>

    <span class="nav-label">Principal</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="icon">📊</span> Dashboard
    </a>

    <span class="nav-label">Usuarios</span>
    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <span class="icon">👥</span> Gestionar usuarios
    </a>
    <a href="{{ route('admin.supervision') }}" class="nav-item {{ request()->routeIs('admin.supervision') ? 'active' : '' }}">
    <span class="icon">🧠</span> Supervisión
    </a>
    <a href="{{ route('admin.music.index') }}" class="nav-item {{ request()->routeIs('admin.music.*') ? 'active' : '' }}">
    <span class="icon">🎵</span> Catálogo musical
</a>
<span class="nav-label">Reportes</span>
<a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
    <span class="icon">📊</span> Reportes
</a>
<a href="{{ route('admin.notifications') }}" class="nav-item {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
    <span class="icon">🔔</span> Notificaciones
</a>

    <div class="sidebar-footer">
        <div class="admin-info">
            <strong>{{ Auth::user()->nom_user }}</strong>
            Administrador
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline" style="width:100%; justify-content:center;">
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

<!-- ── Contenido principal ── -->
<main class="main">

    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error') || $errors->any())
        <div class="alert alert-error">✗ {{ session('error') ?? $errors->first() }}</div>
    @endif

    @yield('content')
</main>
<button id="toggleTheme" class="btn btn-outline" style="position:fixed; top:20px; right:20px; z-index:999;">
    ☀️ Modo claro
</button>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('toggleTheme');

    function aplicarTema() {
        const theme = localStorage.getItem('theme');

        if (theme === 'light') {
            document.body.classList.add('light');
            btn.textContent = '🌙 Modo oscuro';
        } else {
            document.body.classList.remove('light');
            btn.textContent = '☀️ Modo claro';
        }
    }

    aplicarTema();

    btn.addEventListener('click', () => {
        if (document.body.classList.contains('light')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
        aplicarTema();
    });

});
</script>
</body>
</html>
