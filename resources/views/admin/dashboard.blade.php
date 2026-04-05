@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div class="page-title">
        Dashboard
        <span>Resumen general de la plataforma</span>
    </div>
</div>

<!-- Estadísticas (HU016) -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-num">{{ $stats['total'] }}</div>
        <div class="stat-label">Total usuarios</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="background:linear-gradient(135deg,#4ade80,#22d3ee);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $stats['activos'] }}</div>
        <div class="stat-label">Activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-num" style="background:linear-gradient(135deg,#f87171,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $stats['bloqueados'] }}</div>
        <div class="stat-label">Bloqueados</div>
    </div>
    <div class="stat-card">
        <div class="stat-num">{{ $stats['hoy'] }}</div>
        <div class="stat-label">Nuevos hoy</div>
    </div>
    <div class="stat-card">
        <div class="stat-num">{{ $stats['este_mes'] }}</div>
        <div class="stat-label">Este mes</div>
    </div>
</div>

<!-- Últimos registros -->
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.2rem;">
        <h2 style="font-size:1rem; font-weight:500;">Últimos registros</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">Ver todos →</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Edad</th>
                <th>Estado</th>
                <th>Registrado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ultimosUsuarios as $user)
            <tr>
                <td>{{ $user->nom_user }}</td>
                <td style="color:var(--muted);">{{ $user->email_user }}</td>
                <td>{{ $user->edad_user }} años</td>
                <td>
                    <span class="badge {{ $user->registro_user === 'activo' ? 'badge-active' : 'badge-blocked' }}">
                        {{ ucfirst($user->registro_user) }}
                    </span>
                </td>
                <td style="color:var(--muted);">{{ $user->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:var(--muted); padding:2rem;">
                    No hay usuarios registrados aún.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
