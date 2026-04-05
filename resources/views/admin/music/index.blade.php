@extends('layouts.admin')
@section('title', 'Catálogo Musical')

@section('content')

<div class="page-header">
    <div class="page-title">
        Catálogo Musical
        <span>HU018 — Gestión de canciones por emoción</span>
    </div>
    <a href="{{ route('admin.music.create') }}" class="btn btn-gradient">
        + Agregar canción
    </a>
</div>

<!-- Filtros -->
<form method="GET" action="{{ route('admin.music.index') }}">
    <div class="search-bar">
        <input type="text" name="search" placeholder="🔍 Buscar canción o artista..."
            value="{{ request('search') }}">
        <select name="emocion">
            <option value="">Todas las emociones</option>
            @foreach($emociones as $emo)
                <option value="{{ $emo }}" {{ request('emocion') === $emo ? 'selected' : '' }}>
                    {{ ucfirst($emo) }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-gradient btn-sm">Filtrar</button>
        @if(request('search') || request('emocion'))
            <a href="{{ route('admin.music.index') }}" class="btn btn-outline btn-sm">Limpiar</a>
        @endif
    </div>
</form>

<!-- Tabla -->
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Canción</th>
                <th>Artista</th>
                <th>Emoción</th>
                <th>Género</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($songs as $song)
            @php
                $colores = [
                    'ira'       => '#FF4444',
                    'miedo'     => '#9B59B6',
                    'asco'      => '#27AE60',
                    'tristeza'  => '#3498DB',
                    'felicidad' => '#F39C12',
                    'sorpresa'  => '#F1C40F',
                    'neutral'   => '#808080',
                ];
                $emojis = [
                    'ira'       => '😡',
                    'miedo'     => '😨',
                    'asco'      => '🤢',
                    'tristeza'  => '😢',
                    'felicidad' => '😊',
                    'sorpresa'  => '😲',
                    'neutral'   => '😐',
                ];
                $color = $colores[$song->emocion_can] ?? '#808080';
                $emoji = $emojis[$song->emocion_can] ?? '🎵';
            @endphp
            <tr>
                <td>
                    <a href="{{ $song->url_can }}" target="_blank"
                        style="color:var(--text);text-decoration:none;">
                        🎵 {{ $song->nom_can }}
                    </a>
                </td>
                <td style="color:var(--muted);">{{ $song->artista_can }}</td>
                <td>
                    <span style="display:inline-flex;align-items:center;gap:0.4rem;
                        padding:0.2rem 0.6rem;background:{{ $color }}22;
                        border:1px solid {{ $color }}44;border-radius:100px;
                        color:{{ $color }};font-size:0.78rem;">
                        {{ $emoji }} {{ ucfirst($song->emocion_can) }}
                    </span>
                </td>
                <td style="color:var(--muted);">{{ $song->genero_can ?? '—' }}</td>
                <td>
                    <span class="badge {{ $song->activa ? 'badge-active' : 'badge-blocked' }}">
                        {{ $song->activa ? '● Activa' : '● Inactiva' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
                        <a href="{{ route('admin.music.edit', $song) }}"
                            class="btn btn-outline btn-sm">✏️ Editar</a>

                        <form method="POST" action="{{ route('admin.music.toggle', $song) }}"
                            style="display:inline;">
                            @csrf
                            @if($song->activa)
                                <button type="submit" class="btn btn-warning btn-sm">
                                    ⏸ Desactivar
                                </button>
                            @else
                                <button type="submit" class="btn btn-sm"
                                    style="background:rgba(74,222,128,0.15);color:var(--success);
                                    border:1px solid rgba(74,222,128,0.3);">
                                    ▶ Activar
                                </button>
                            @endif
                        </form>

                        <form method="POST" action="{{ route('admin.music.destroy', $song) }}"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar esta canción?')">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;color:var(--muted);padding:2rem;">
                    No hay canciones en el catálogo.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($songs->hasPages())
        <div class="pagination">
            {{ $songs->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
