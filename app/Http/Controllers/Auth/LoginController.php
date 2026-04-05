<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_user'  => 'required|email',
            'contra_user' => 'required|string',
        ], [
            'email_user.required'  => 'El correo es obligatorio.',
            'email_user.email'     => 'Ingresa un correo válido.',
            'contra_user.required' => 'La contraseña es obligatoria.',
        ]);

        $user = \App\Models\User::where('email_user', $request->email_user)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->contra_user, $user->contra_user)) {
            return back()->withErrors([
                'email_user' => 'El correo o la contraseña son incorrectos.',
            ])->withInput($request->only('email_user'));
        }


        if ($user->registro_user === 'bloqueado') {
            return back()->withErrors([
                'email_user' => 'Tu cuenta ha sido suspendida.',
            ])->withInput();
        }

        auth()->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home')->with('success', '¡De vuelta, ' . $user->nom_user . '! 🎨');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('info', 'Sesión cerrada correctamente.');
    }
}
