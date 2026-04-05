@extends('layouts.admin')
@section('title', 'Gestión de usuarios')

@section('content')

<div class="page-header">
    <div class="page-title">
        Gestión de usuarios
        <span>Administra las cuentas registradas en la plataforma</span>
    </div>
</div>

<!-- Filtros (HU004) -->
<form method="GET" action="{{ route('admin.users.index') }}">
    <div class="search-bar">
        <input
            type="text"
            name="search"
            placeholder="🔍 Buscar por nombre o correo..."
            value="{{ request('search') }}"
        >
        <select name="estado">
            <option value="">Todos los estados</option>
            <option value="activo"    {{ request('estado') === 'activo'    ? 'selected' : '' }}>Activos</option>
            <option value="bloqueado" {{ request('estado') === 'bloqueado' ? 'selected' : '' }}>Bloqueados</option>
        </select>
        <button type="submit" class="btn btn-gradient btn-sm">Filtrar</button>
        @if(request('search') || request('estado'))
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">Limpiar</a>
        @endif
    </div>
</form>

<!-- Tabla de usuarios -->
<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Edad</th>
                <th>Estado</th>
                <th>Registrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="color:var(--muted);">{{ $user->id }}</td>
                <td><strong>{{ $user->nom_user }}</strong></td>
                <td style="color:var(--muted);">{{ $user->email_user }}</td>
                <td>{{ $user->edad_user ?? '—' }}</td>
                <td>
                    <span class="badge {{ $user->registro_user === 'activo' ? 'badge-active' : 'badge-blocked' }}">
                        {{ $user->registro_user === 'activo' ? '● Activo' : '● Bloqueado' }}
                    </span>
                </td>
                <td style="color:var(--muted); font-size:0.82rem;">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <div style="display:flex; gap:0.4rem; flex-wrap:wrap;">

                        <!-- Editar -->
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm">
                            ✏️ Editar
                        </a>

                        <!-- Bloquear / Desbloquear (HU015) -->
                        <form method="POST" action="{{ route('admin.users.toggle-block', $user) }}" style="display:inline;">
                            @csrf
                            @if($user->registro_user === 'activo')
                                <button type="submit" class="btn btn-warning btn-sm"
                                    onclick="return confirm('¿Bloquear a {{ $user->nom_user }}?')">
                                    🔒 Bloquear
                                </button>
                            @else
                                <button type="submit" class="btn btn-sm"
                                    style="background:rgba(74,222,128,0.15);color:var(--success);border:1px solid rgba(74,222,128,0.3);"
                                    onclick="return confirm('¿Desbloquear a {{ $user->nom_user }}?')">
                                    🔓 Activar
                                </button>
                            @endif
                        </form>

    

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:var(--muted); padding:3rem;">
                    No se encontraron usuarios con esos criterios.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    @if($users->hasPages())
        <div class="pagination">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
