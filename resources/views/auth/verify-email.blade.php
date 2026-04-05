@extends('layouts.auth')
@section('title', 'Verificar correo')

@section('content')

<div class="brand">
    <span class="brand-icon">📬</span>
    <h1 style="font-size:1.5rem;">Verifica tu correo</h1>
    <p>Ingresa el código que enviamos a tu Gmail</p>
</div>

@if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('verify.email.post') }}">
    @csrf

    <div class="form-group">
        <label for="code">Código de verificación</label>
        <input
            type="text"
            id="code"
            name="code"
            placeholder="000000"
            maxlength="6"
            style="text-align:center; font-size:1.4rem; letter-spacing:0.4em;"
            inputmode="numeric"
            autocomplete="one-time-code"
        >
        @error('code')
            <span class="error-msg">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn-primary">
        Verificar correo ✓
    </button>
</form>

<div class="auth-footer" style="margin-top:1rem;">
    ¿No te llegó el correo?
    <form method="POST" action="{{ route('verify.email.resend') }}" style="display:inline;">
        @csrf
        <button type="submit" style="background:none;border:none;color:var(--accent1);cursor:pointer;font-size:0.85rem;">
            Reenviar código
        </button>
    </form>
</div>

<div class="auth-footer">
    <a href="{{ route('register') }}" class="link">← Volver al registro</a>
</div>

@endsection
