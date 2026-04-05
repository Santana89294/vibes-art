@extends('layouts.auth')
@section('title', 'Crear cuenta')

@section('content')

<div class="brand">
    <span class="brand-icon">🎨</span>
    <h1>Vibes Art</h1>
    <p>Expresa lo que sientes, crea arte</p>
</div>

<form method="POST" action="{{ route('register.post') }}">
    @csrf

    <!-- Nombre -->
    <div class="form-group">
        <label for="nom_user">Tu nombre</label>
        <input
            type="text"
            id="nom_user"
            name="nom_user"
            placeholder="¿Cómo te llamas?"
            value="{{ old('nom_user') }}"
            autocomplete="name"
        >
        @error('nom_user')
            <span class="error-msg">{{ $message }}</span>
        @enderror
    </div>

    <!-- Edad -->
    <div class="form-group">
        <label for="edad_user">Edad</label>
        <input
            type="number"
            id="edad_user"
            name="edad_user"
            placeholder="Tu edad"
            value="{{ old('edad_user') }}"
            min="10" max="100"
        >
        @error('edad_user')
            <span class="error-msg">{{ $message }}</span>
        @enderror
    </div>

    <!-- Correo -->
    <div class="form-group">
        <label for="email_user">Correo electrónico</label>
        <input
            type="email"
            id="email_user"
            name="email_user"
            placeholder="tu@correo.com"
            value="{{ old('email_user') }}"
            autocomplete="email"
        >
        @error('email_user')
            <span class="error-msg">{{ $message }}</span>
        @enderror
    </div>

    <!-- Contraseña -->
    <div class="form-group">
        <label for="contra_user">Contraseña</label>
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

    <!-- Confirmar contraseña -->
    <div class="form-group">
        <label for="contra_user_confirmation">Confirmar contraseña</label>
        <input
            type="password"
            id="contra_user_confirmation"
            name="contra_user_confirmation"
            placeholder="Repite tu contraseña"
            autocomplete="new-password"
        >
    </div>

    <button type="submit" class="btn-primary">
        Crear mi cuenta 🎨
    </button>
</form>

<div class="auth-footer">
    ¿Ya tienes cuenta?
    <a href="{{ route('login') }}" class="link">Inicia sesión</a>
</div>

@endsection
