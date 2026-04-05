@extends('layouts.admin')
@section('title', 'Editar canción')

@section('content')

<div class="page-header">
    <div class="page-title">
        Editar canción
        <span>Modificando: {{ $song->nom_can }}</span>
    </div>
    <a href="{{ route('admin.music.index') }}" class="btn btn-outline">← Volver</a>
</div>

<div class="card" style="max-width:520px;">

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.music.update', $song) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Emoción asociada</label>
            <select name="emocion_can" required>
                <option value="">Selecciona una emoción</option>
                @foreach($emociones as $emo)
                    <option value="{{ $emo }}"
                        {{ old('emocion_can', $song->emocion_can) === $emo ? 'selected' : '' }}>
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
                value="{{ old('nom_can', $song->nom_can) }}" required>
            @error('nom_can')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Artista</label>
            <input type="text" name="artista_can"
                value="{{ old('artista_can', $song->artista_can) }}" required>
            @error('artista_can')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>URL de YouTube</label>
            <input type="url" name="url_can"
                value="{{ old('url_can', $song->url_can) }}" required>
            @error('url_can')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Género musical (opcional)</label>
            <input type="text" name="genero_can"
                value="{{ old('genero_can', $song->genero_can) }}">
        </div>

        <div style="display:flex;gap:0.8rem;margin-top:1.5rem;">
            <button type="submit" class="btn btn-gradient" style="flex:1;">
                Guardar cambios
            </button>
            <a href="{{ route('admin.music.index') }}" class="btn btn-outline"
                style="flex:1;text-align:center;">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
