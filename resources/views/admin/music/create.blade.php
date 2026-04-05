@extends('layouts.admin')
@section('title', 'Agregar canción')

@section('content')

<div class="page-header">
    <div class="page-title">
        Agregar canción
        <span>Nueva canción al catálogo</span>
    </div>
    <a href="{{ route('admin.music.index') }}" class="btn btn-outline">← Volver</a>
</div>

<div class="card" style="max-width:520px;">

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.music.store') }}">
        @csrf

        <div class="form-group">
            <label>Emoción asociada</label>
            <select name="emocion_can" required>
                <option value="">Selecciona una emoción</option>
                @foreach($emociones as $emo)
                    <option value="{{ $emo }}" {{ old('emocion_can') === $emo ? 'selected' : '' }}>
                        {{ ucfirst($emo) }}
                    </option>
                @endforeach
            </select>
            @error('emocion_can')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Nombre de la canción</label>
            <input type="text" name="nom_can"
                placeholder="Ej: Someone Like You"
                value="{{ old('nom_can') }}" required>
            @error('nom_can')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Artista</label>
            <input type="text" name="artista_can"
                placeholder="Ej: Adele"
                value="{{ old('artista_can') }}" required>
            @error('artista_can')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>URL de YouTube</label>
            <input type="url" name="url_can"
                placeholder="https://www.youtube.com/watch?v=..."
                value="{{ old('url_can') }}" required>
            @error('url_can')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Género musical (opcional)</label>
            <input type="text" name="genero_can"
                placeholder="Ej: Pop, Rock, Indie..."
                value="{{ old('genero_can') }}">
        </div>

        <div style="display:flex;gap:0.8rem;margin-top:1.5rem;">
            <button type="submit" class="btn btn-gradient" style="flex:1;">
                Guardar canción
            </button>
            <a href="{{ route('admin.music.index') }}" class="btn btn-outline"
                style="flex:1;text-align:center;">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
