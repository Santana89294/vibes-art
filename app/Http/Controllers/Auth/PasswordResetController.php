<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class PasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email_user' => 'required|email|exists:users,email_user',
        ], [
            'email_user.required' => 'El correo es obligatorio.',
            'email_user.email'    => 'Ingresa un correo válido.',
            'email_user.exists'   => 'No existe una cuenta con ese correo.',
        ]);

        $code = random_int(100000, 999999);
        Cache::put('reset_code_' . $request->email_user, $code, now()->addMinutes(15));
        session(['reset_email' => $request->email_user]);

        // Enviar correo real
        Mail::send([], [], function ($message) use ($request, $code) {
            $message->to($request->email_user)
                ->subject('🎨 Vibes Art - Código de recuperación')
                ->html("
                    <div style='font-family:sans-serif;max-width:480px;margin:auto;background:#12121a;color:#e2e2f0;padding:2rem;border-radius:16px;'>
                        <h1 style='background:linear-gradient(135deg,#c084fc,#f472b6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-size:1.8rem;'>🎨 Vibes Art</h1>
                        <p>Recibimos una solicitud para restablecer tu contraseña.</p>
                        <p>Tu código de verificación es:</p>
                        <div style='background:#1e1e2e;border-radius:12px;padding:1.5rem;text-align:center;margin:1.5rem 0;'>
                            <span style='font-size:2.5rem;font-weight:bold;letter-spacing:0.5rem;color:#c084fc;'>{$code}</span>
                        </div>
                        <p style='color:#6b6b8a;font-size:0.85rem;'>Este código expira en 15 minutos. Si no solicitaste esto, ignora este correo.</p>
                    </div>
                ");
        });

        return redirect()->route('password.verify')
            ->with('success', 'Código enviado a tu correo Gmail ✓');
    }

    public function showVerifyForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.digits'   => 'El código debe tener 6 dígitos.',
        ]);

        $email     = session('reset_email');
        $savedCode = Cache::get('reset_code_' . $email);

        if (!$savedCode || $request->code != $savedCode) {
            return back()->withErrors(['code' => 'Código incorrecto o expirado.']);
        }

        session(['reset_verified' => true]);
        return redirect()->route('password.reset');
    }

    public function showResetForm()
    {
        if (!session('reset_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session('reset_verified')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'contra_user' => 'required|string|min:6|confirmed',
        ], [
            'contra_user.required'  => 'La contraseña es obligatoria.',
            'contra_user.min'       => 'Mínimo 6 caracteres.',
            'contra_user.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::where('email_user', session('reset_email'))->first();
        $user->update(['contra_user' => Hash::make($request->contra_user)]);

        Cache::forget('reset_code_' . session('reset_email'));
        session()->forget(['reset_email', 'reset_verified']);

        return redirect()->route('login')
            ->with('success', '¡Contraseña actualizada! Ya puedes iniciar sesión.');
    }
}
