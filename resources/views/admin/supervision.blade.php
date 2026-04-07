@extends('layouts.admin')
@section('title', 'Supervisión del sistema emocional')

@section('content')

<div class="page-header">
    <div class="page-title">
        Supervisión del sistema emocional
        <span>Monitoreo del motor de detección</span>
    </div>
</div>

<!-- Estadísticas generales -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-num">{{ $stats['total_emociones'] }}</div>
        <div class="stat-label">Total detecciones</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="background:linear-gradient(135deg,#4ade80,#22d3ee);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            {{ $stats['emociones_hoy'] }}
        </div>
        <div class="stat-label">Detecciones hoy</div>
    </div>
    <div class="stat-card">
        <div class="stat-num">{{ $stats['emociones_mes'] }}</div>
        <div class="stat-label">Este mes</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="background:linear-gradient(135deg,#f472b6,#c084fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            {{ $stats['usuarios_activos'] }}
        </div>
        <div class="stat-label">Usuarios activos hoy</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">

    <!-- Emociones predominantes -->
    <div class="card">
        <h2 style="font-size:1rem; font-weight:500; margin-bottom:1.2rem;">
            Emociones predominantes globales
        </h2>
        @forelse($emocionesGlobales as $emocion)
        @php
            $colores = [
                'alegría'  => '#FFD700',
                'tristeza' => '#4169E1',
                'rabia'    => '#DC143C',
                'miedo'    => '#800080',
                'asombro'  => '#FF8C00',
                'amor'     => '#FF69B4',
                'neutral'  => '#808080',
            ];
            $color = $colores[$emocion->emocion_amo] ?? '#808080';
            $porcentaje = $stats['total_emociones'] > 0
                ? round(($emocion->total / $stats['total_emociones']) * 100)
                : 0;
        @endphp
        <div style="margin-bottom:1rem;">
            <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">
                <span style="font-size:0.88rem;">{{ ucfirst($emocion->emocion_amo) }}</span>
                <span style="font-size:0.82rem; color:var(--muted);">{{ $emocion->total }} ({{ $porcentaje }}%)</span>
            </div>
            <div style="height:6px; background:var(--border); border-radius:100px; overflow:hidden;">
                <div style="height:100%; width:{{ $porcentaje }}%; background:{{ $color }}; border-radius:100px;"></div>
            </div>
        </div>
        @empty
        <p style="color:var(--muted); font-size:0.85rem;">No hay detecciones aún.</p>
        @endforelse
    </div>

    <!-- Intensidad promedio -->
    <div class="card">
        <h2 style="font-size:1rem; font-weight:500; margin-bottom:1.2rem;">
            Intensidad promedio por emoción
        </h2>
        @forelse($intensidadPromedio as $item)
        @php
            $colores = [
                'alegría'  => '#FFD700',
                'tristeza' => '#4169E1',
                'rabia'    => '#DC143C',
                'miedo'    => '#800080',
                'asombro'  => '#FF8C00',
                'amor'     => '#FF69B4',
                'neutral'  => '#808080',
            ];
            $color = $colores[$item->emocion_amo] ?? '#808080';
            $prom  = round($item->promedio, 1);
        @endphp
        <div style="margin-bottom:1rem;">
            <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">
                <span style="font-size:0.88rem;">{{ ucfirst($item->emocion_amo) }}</span>
                <span style="font-size:0.82rem; color:var(--muted);">{{ $prom }}/10</span>
            </div>
            <div style="height:6px; background:var(--border); border-radius:100px; overflow:hidden;">
                <div style="height:100%; width:{{ $prom * 10 }}%; background:{{ $color }}; border-radius:100px;"></div>
            </div>
        </div>
        @empty
        <p style="color:var(--muted); font-size:0.85rem;">No hay datos aún.</p>
        @endforelse
    </div>

</div>

<!-- Últimas detecciones -->
<div class="card">
    <h2 style="font-size:1rem; font-weight:500; margin-bottom:1.2rem;">
        Últimas detecciones del sistema
    </h2>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Emoción detectada</th>
                <th>Intensidad</th>
                <th>Texto (resumen)</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ultimasDetecciones as $det)
            @php
                $colores = [
                    'alegría'  => '#FFD700',
                    'tristeza' => '#4169E1',
                    'rabia'    => '#DC143C',
                    'miedo'    => '#800080',
                    'asombro'  => '#FF8C00',
                    'amor'     => '#FF69B4',
                    'neutral'  => '#808080',
                ];
                $color = $colores[$det->emocion_amo] ?? '#808080';
            @endphp
            <tr>
                <td>{{ $det->user->nom_user ?? '—' }}</td>
                <td>
                    <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.2rem 0.6rem;background:{{ $color }}22;border:1px solid {{ $color }}44;border-radius:100px;color:{{ $color }};font-size:0.78rem;">
                        {{ ucfirst($det->emocion_amo) }}
                    </span>
                </td>
                <td style="color:var(--muted);">{{ $det->intensidad_emo }}/10</td>
                <td style="color:var(--muted); font-size:0.82rem;">
                    {{ Str::limit($det->texto_emo, 50) }}
                </td>
                <td style="color:var(--muted); font-size:0.82rem;">
                    {{ $det->created_at->diffForHumans() }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:var(--muted); padding:2rem;">
                    No hay detecciones aún.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
