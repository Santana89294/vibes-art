{{-- ════════════════════════════════════════════════════════
     forgot-password.blade.php  ─ PASO 1: ingresar correo
════════════════════════════════════════════════════════ --}}
@extends('layouts.auth')
@section('title', 'Recuperar contraseña')

@section('content')

<div class="brand">
    <span class="brand-icon">🔑</span>
    <h1 style="font-size:1.5rem;">Recuperar acceso</h1>
    <p>Te enviaremos un código a tu correo</p>
</div>

@if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="form-group">
        <label for="email_user">Correo registrado</label>
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

    <button type="submit" class="btn-primary">
        Enviar código de recuperación
    </button>
</form>

<div class="auth-footer">
    <a href="{{ route('login') }}" class="link">← Volver al login</a>
</div>

@endsection
