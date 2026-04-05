<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ─── Dashboard Admin (HU016 - estadísticas) ───────────────────────
    public function dashboard()
    {
        $stats = [
            'total'      => User::where('role', 'usuario')->count(),
            'activos'    => User::where('role', 'usuario')->where('registro_user', 'activo')->count(),
            'bloqueados' => User::where('role', 'usuario')->where('registro_user', 'bloqueado')->count(),
            'hoy'        => User::where('role', 'usuario')->whereDate('created_at', today())->count(),
            'este_mes'   => User::where('role', 'usuario')->whereMonth('created_at', now()->month)->count(),
        ];

        $ultimosUsuarios = User::where('role', 'usuario')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ultimosUsuarios'));
    }

    // ─── Listar usuarios (HU004) ──────────────────────────────────────
    public function index(Request $request)
    {
        $query = User::where('role', 'usuario');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom_user', 'like', '%' . $request->search . '%')
                  ->orWhere('email_user', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('registro_user', $request->estado);
        }

        $users = $query->orderByDesc('created_at')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // ─── Ver detalle de usuario ───────────────────────────────────────
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // ─── Formulario editar usuario ────────────────────────────────────
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // ─── Actualizar datos de usuario ──────────────────────────────────
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom_user'   => 'required|string|max:100',
            'edad_user'  => 'required|integer|min:10|max:100',
            'email_user' => 'required|email|unique:users,email_user,' . $user->id,
        ]);

        $user->update($request->only(['nom_user', 'edad_user', 'email_user']));

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // ─── Bloquear / Desbloquear usuario (HU015) ───────────────────────
    public function toggleBlock(User $user)
    {
        $nuevoEstado = $user->registro_user === 'activo' ? 'bloqueado' : 'activo';
        $user->update(['registro_user' => $nuevoEstado]);

        $msg = $nuevoEstado === 'bloqueado'
            ? 'Usuario bloqueado correctamente.'
            : 'Usuario desbloqueado correctamente.';

        return redirect()->back()->with('success', $msg);
    }
}