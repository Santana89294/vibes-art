<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom_user'    => 'required|string|max:100|min:2',
            'edad_user'   => 'required|integer|min:10|max:100',
            'email_user'  => 'required|email|unique:users,email_user',
            'contra_user' => 'required|string|min:6|confirmed',
        ], [
            'nom_user.required'     => 'El nombre es obligatorio.',
            'nom_user.min'          => 'El nombre debe tener al menos 2 caracteres.',
            'edad_user.required'    => 'La edad es obligatoria.',
            'edad_user.min'         => 'Debes tener al menos 10 años.',
            'email_user.required'   => 'El correo es obligatorio.',
            'email_user.unique'     => 'Este correo ya está registrado.',
            'contra_user.required'  => 'La contraseña es obligatoria.',
            'contra_user.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'contra_user.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Código de verificación
        $code = random_int(100000, 999999);

        // Guardar en cache (15 min)
        Cache::put('pending_user_' . $request->email_user, [
            'nom_user'    => $request->nom_user,
            'edad_user'   => $request->edad_user,
            'email_user'  => $request->email_user,
            'contra_user' => Hash::make($request->contra_user),
            'code'        => $code,
        ], now()->addMinutes(15));

        // 🔥 IMPORTANTE: intentar enviar correo SIN romper app
        try {
            Mail::send([], [], function ($message) use ($request, $code) {
                $message->to($request->email_user)
                    ->subject('🎨 Vibes Art - Verifica tu correo')
                    ->html("
                        <div style='font-family:sans-serif;max-width:480px;margin:auto;background:#12121a;color:#e2e2f0;padding:2rem;border-radius:16px;'>
                            <h1 style='color:#c084fc;'>🎨 Vibes Art</h1>
                            <p>¡Hola {$request->nom_user}!</p>
                            <p>Tu código es:</p>
                            <h2 style='text-align:center;color:#c084fc;'>{$code}</h2>
                            <p>Expira en 15 minutos.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            // ❌ No rompe la app
            Log::error('Error enviando correo: ' . $e->getMessage());
        }

        session(['pending_email' => $request->email_user]);

        return redirect()->route('verify.email')
            ->with('success', 'Código enviado (o generado). Revisa tu correo.');
    }
}
