<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Tu Resultado</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:#0a0a0f; --surface:#12121a; --border:#1e1e2e;
            --accent1:#c084fc; --accent2:#f472b6;
            --text:#e2e2f0; --muted:#6b6b8a;
        }

        *{box-sizing:border-box;margin:0;padding:0}

        body{
            font-family:'DM Sans',sans-serif;
            background:var(--bg);
            color:var(--text);
            min-height:100vh;
            padding:2rem 1rem;
        }

        body::before{
            content:"";
            position:fixed;
            inset:0;
            background:
                radial-gradient(circle at 20% 20%, {{ $color }}22, transparent 60%),
                radial-gradient(circle at 80% 80%, {{ $color }}15, transparent 60%);
            z-index:0;
        }

        .container{position:relative;z-index:1;max-width:650px;margin:auto}

        .header{display:flex;justify-content:space-between;margin-bottom:2rem}
        .brand{font-family:'Playfair Display';font-size:1.5rem}

        .art-canvas{
            width:100%;
            height:350px;
            border-radius:20px;
            overflow:hidden;
            border:1px solid {{ $color }}44;
            box-shadow:0 0 80px {{ $color }}33;
            margin-bottom:1.5rem;
        }

        canvas{width:100%;height:100%}

        .card{
            background:var(--surface);
            padding:2rem;
            border-radius:20px;
            border:1px solid var(--border);
        }

        .emotion-badge{
            display:inline-flex;
            padding:.5rem 1rem;
            border-radius:100px;
            background:{{ $color }}22;
            border:1px solid {{ $color }}44;
            color:{{ $color }};
            margin-bottom:1rem;
        }

        .btn{
            display:block;
            text-align:center;
            padding:.8rem;
            border-radius:10px;
            text-decoration:none;
            margin-top:1rem;
        }

        .btn-primary{
            background:linear-gradient(135deg,var(--accent1),var(--accent2));
            color:white;
        }

        .btn-outline{
            border:1px solid var(--border);
            color:var(--muted);
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div class="brand">🎨 Vibes Art</div>
        <div>
            <a href="{{ route('emotions.diary') }}" style="color:var(--muted)">Diario</a>
        </div>
    </div>

    <div class="art-canvas">
        <canvas id="artCanvas"></canvas>
    </div>

    <div class="card">

        <div class="emotion-badge">
            {{ $emoji }} {{ ucfirst($emotion->emocion_amo) }}
        </div>

        <h2>Tu Vibe de hoy</h2>

        <p style="color:var(--muted);margin:1rem 0">
            {{ $emotion->texto_emo }}
        </p>

        <a href="{{ route('emotions.diary') }}" class="btn btn-primary">
            Nueva emoción
        </a>

        <a href="{{ route('home') }}" class="btn btn-outline">
            Volver
        </a>

    </div>
</div>

<script>
window.addEventListener('load', () => {

    const canvas = document.getElementById('artCanvas');
    const ctx = canvas.getContext('2d');

    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;

    const W = canvas.width;
    const H = canvas.height;

    const dominantColor = "{{ $color }}";

    // 🔥 IMPORTANTE: evitar regenerar duplicado
    const storageKey = "art_saved_{{ $emotion->id }}";
    const alreadySaved = localStorage.getItem(storageKey);

    const rand = (min,max)=>Math.random()*(max-min)+min;

    // Fondo
    const grad = ctx.createLinearGradient(0,0,W,H);
    grad.addColorStop(0,"#0a0a0f");
    grad.addColorStop(0.5, dominantColor + "22");
    grad.addColorStop(1,"#0a0a0f");

    ctx.fillStyle = grad;
    ctx.fillRect(0,0,W,H);

    // Formas simples
    for(let i=0;i<25;i++){
        ctx.beginPath();
        ctx.arc(rand(0,W),rand(0,H),rand(10,60),0,Math.PI*2);
        ctx.fillStyle = dominantColor + "33";
        ctx.fill();
    }

    // Centro dominante
    ctx.beginPath();
    ctx.arc(W/2,H/2,80,0,Math.PI*2);
    ctx.strokeStyle = dominantColor;
    ctx.lineWidth = 3;
    ctx.stroke();

    // 🚫 SOLO GUARDAR UNA VEZ
    if(!alreadySaved){
        setTimeout(() => {

            const image = canvas.toDataURL("image/png");

            fetch("{{ route('gallery.save-art', $emotion->id) }}", {
                method:"POST",
                headers:{
                    "Content-Type":"application/json",
                    "X-CSRF-TOKEN":"{{ csrf_token() }}"
                },
                body: JSON.stringify({ art_image: image })
            })
            .then(r=>r.json())
            .then(() => {
                console.log("✅ Guardado una sola vez");
                localStorage.setItem(storageKey, "true");
            });

        }, 800);
    }
});
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
