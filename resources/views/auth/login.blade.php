@extends('layouts.auth')
@section('title', 'Iniciar sesión')

@section('content')

<div class="brand">
    <span class="brand-icon">🎨</span>
    <h1>Vibes Art</h1>
    <p>¿Cómo te sientes hoy?</p>
</div>

<!-- Error de credenciales -->
@if($errors->any())
    <div class="alert alert-error">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login.post') }}">
    @csrf

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
            placeholder="Tu contraseña"
            autocomplete="current-password"
        >
        @error('contra_user')
            <span class="error-msg">{{ $message }}</span>
        @enderror
    </div>

    <!-- Recordarme + olvidé contraseña -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <div class="checkbox-group" style="margin-bottom:0;">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Recordarme</label>
        </div>
        <a href="{{ route('password.request') }}" class="link" style="font-size:0.82rem;">
            ¿Olvidaste tu contraseña?
        </a>
    </div>

    <button type="submit" class="btn-primary">
        Entrar a mis Vibes 🎨
    </button>
</form>

<div class="auth-footer">
    ¿Eres nuevo?
    <a href="{{ route('register') }}" class="link">Crea tu cuenta gratis</a>
</div>

@endsection
