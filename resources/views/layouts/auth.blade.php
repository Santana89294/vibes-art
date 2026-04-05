<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – @yield('title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:        #0a0a0f;
            --surface:   #12121a;
            --border:    #1e1e2e;
            --accent1:   #c084fc;   /* violeta suave */
            --accent2:   #f472b6;   /* rosa */
            --accent3:   #38bdf8;   /* azul */
            --text:      #e2e2f0;
            --muted:     #6b6b8a;
            --error:     #f87171;
            --success:   #4ade80;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* ── Fondo animado con gradientes ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(192, 132, 252, 0.12) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(244, 114, 182, 0.10) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 50% 50%, rgba(56, 189, 248, 0.06) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Partículas decorativas ── */
        .particle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            animation: float linear infinite;
            opacity: 0.4;
        }
        @keyframes float {
            0%   { transform: translateY(100vh) rotate(0deg);   opacity: 0; }
            10%  { opacity: 0.4; }
            90%  { opacity: 0.4; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* ── Card principal ── */
        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(192,132,252,0.08);
            animation: slideUp 0.5s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Logo / Brand ── */
        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        .brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .brand p {
            color: var(--muted);
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        /* ── Formulario ── */
        .form-group {
            margin-bottom: 1.2rem;
        }
        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.4rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-group input:focus {
            border-color: var(--accent1);
            box-shadow: 0 0 0 3px rgba(192,132,252,0.15);
        }
        .form-group input::placeholder {
            color: var(--muted);
        }
        .form-group .error-msg {
            color: var(--error);
            font-size: 0.78rem;
            margin-top: 0.3rem;
        }

        /* ── Botón principal ── */
        .btn-primary {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, var(--accent1), var(--accent2));
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            margin-top: 0.5rem;
            letter-spacing: 0.02em;
        }
        .btn-primary:hover  { opacity: 0.88; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }

        /* ── Links ── */
        .link { color: var(--accent1); text-decoration: none; transition: color 0.2s; }
        .link:hover { color: var(--accent2); }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--muted);
        }

        /* ── Alerts ── */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.2rem;
            font-size: 0.85rem;
        }
        .alert-success { background: rgba(74,222,128,0.1); border: 1px solid rgba(74,222,128,0.3); color: var(--success); }
        .alert-error   { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.3); color: var(--error); }
        .alert-info    { background: rgba(56,189,248,0.1);  border: 1px solid rgba(56,189,248,0.3);  color: var(--accent3); }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin: 1.2rem 0;
            color: var(--muted);
            font-size: 0.78rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Checkbox ── */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .checkbox-group input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--accent1);
            cursor: pointer;
        }
        .checkbox-group label {
            font-size: 0.85rem;
            color: var(--muted);
            cursor: pointer;
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

    <!-- Partículas decorativas -->
    <div class="particle" style="width:6px;height:6px;background:var(--accent1);left:15%;animation-duration:12s;animation-delay:0s;"></div>
    <div class="particle" style="width:4px;height:4px;background:var(--accent2);left:35%;animation-duration:16s;animation-delay:3s;"></div>
    <div class="particle" style="width:8px;height:8px;background:var(--accent3);left:65%;animation-duration:10s;animation-delay:6s;"></div>
    <div class="particle" style="width:3px;height:3px;background:var(--accent1);left:80%;animation-duration:14s;animation-delay:1s;"></div>
    <div class="particle" style="width:5px;height:5px;background:var(--accent2);left:50%;animation-duration:18s;animation-delay:4s;"></div>

    <div class="card">

        <!-- Alertas de sesión -->
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✗ {{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">ℹ {{ session('info') }}</div>
        @endif

        @yield('content')
    </div>

</body>
</html>
