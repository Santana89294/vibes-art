{{-- ════════════════════════════════════════════════════════
     verify-code.blade.php  ─ PASO 2: verificar código
════════════════════════════════════════════════════════ --}}
@extends('layouts.auth')
@section('title', 'Verificar código')

@section('content')

<div class="brand">
    <span class="brand-icon">📬</span>
    <h1 style="font-size:1.5rem;">Código enviado</h1>
    <p>Ingresa el código de 6 dígitos</p>
</div>

@if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('password.verify.post') }}">
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
        Verificar código
    </button>
</form>

<div class="auth-footer">
    <a href="{{ route('password.request') }}" class="link">Solicitar nuevo código</a>
</div>

@endsection
