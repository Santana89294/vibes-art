<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    public function showForm()
    {
        if (!session('pending_email')) {
            return redirect()->route('register');
        }
        return view('auth.verify-email');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.digits'   => 'El código debe tener 6 dígitos.',
        ]);

        $email   = session('pending_email');
        $pending = Cache::get('pending_user_' . $email);

        if (!$pending || $request->code != $pending['code']) {
            return back()->withErrors(['code' => 'Código incorrecto o expirado.']);
        }

        // AHORA sí se crea la cuenta
        $user = User::create([
            'nom_user'       => $pending['nom_user'],
            'edad_user'      => $pending['edad_user'],
            'email_user'     => $pending['email_user'],
            'contra_user'    => $pending['contra_user'],
            'role'           => 'usuario',
            'registro_user'  => 'activo',
            'email_verified' => true,
        ]);

        // Limpiar caché y sesión
        Cache::forget('pending_user_' . $email);
        session()->forget('pending_email');

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', '¡Cuenta creada y verificada! Bienvenido a Vibes Art 🎨');
    }

    public function resend(Request $request)
    {
        $email   = session('pending_email');
        $pending = Cache::get('pending_user_' . $email);

        if (!$pending) {
            return redirect()->route('register')
                ->with('error', 'El código expiró. Regístrate de nuevo.');
        }

        $code = random_int(100000, 999999);
        $pending['code'] = $code;
        Cache::put('pending_user_' . $email, $pending, now()->addMinutes(15));

        Mail::send([], [], function ($message) use ($email, $code, $pending) {
            $message->to($email)
                ->subject('🎨 Vibes Art - Nuevo código de verificación')
                ->html("
                    <div style='font-family:sans-serif;max-width:480px;margin:auto;background:#12121a;color:#e2e2f0;padding:2rem;border-radius:16px;'>
                        <h1 style='background:linear-gradient(135deg,#c084fc,#f472b6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-size:1.8rem;'>🎨 Vibes Art</h1>
                        <p>Tu nuevo código de verificación es:</p>
                        <div style='background:#1e1e2e;border-radius:12px;padding:1.5rem;text-align:center;margin:1.5rem 0;'>
                            <span style='font-size:2.5rem;font-weight:bold;letter-spacing:0.5rem;color:#c084fc;'>{$code}</span>
                        </div>
                        <p style='color:#6b6b8a;font-size:0.85rem;'>Este código expira en 15 minutos.</p>
                    </div>
                ");
        });

        return back()->with('success', 'Nuevo código enviado ✓');
    }
}