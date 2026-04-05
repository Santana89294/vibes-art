@extends('layouts.admin')
@section('title', 'Editar usuario')

@section('content')

<div class="page-header">
    <div class="page-title">
        Editar usuario
        <span>Modificando: {{ $user->nom_user }}</span>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">← Volver</a>
</div>

<div class="card" style="max-width:480px;">

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nom_user" value="{{ old('nom_user', $user->nom_user) }}" required>
            @error('nom_user') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Edad</label>
            <input type="number" name="edad_user" value="{{ old('edad_user', $user->edad_user) }}" min="10" max="100">
            @error('edad_user') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Correo electrónico</label>
            <input type="email" name="email_user" value="{{ old('email_user', $user->email_user) }}" required>
            @error('email_user') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div style="display:flex; gap:0.8rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-gradient" style="flex:1;">
                Guardar cambios
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="flex:1; text-align:center;">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
