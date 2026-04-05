@extends('layouts.auth')
@section('title', 'Nueva contraseña')

@section('content')

<div class="brand">
    <span class="brand-icon">🔒</span>
    <h1 style="font-size:1.5rem;">Nueva contraseña</h1>
    <p>Elige una contraseña segura</p>
</div>

@if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <div class="form-group">
        <label for="contra_user">Nueva contraseña</label>
        <input
            type="password"
            id="contra_user"
            name="contra_user"
            placeholder="Mínimo 6 caracteres"
            autocomplete="new-password"
        >
        @error('contra_user')
            <span class="error-msg">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="contra_user_confirmation">Confirmar contraseña</label>
        <input
            type="password"
            id="contra_user_confirmation"
            name="contra_user_confirmation"
            placeholder="Repite la contraseña"
            autocomplete="new-password"
        >
    </div>

    <button type="submit" class="btn-primary">
        Guardar nueva contraseña
    </button>
</form>

@endsection
