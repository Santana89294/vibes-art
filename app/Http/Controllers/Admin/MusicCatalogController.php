<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;

class MusicCatalogController extends Controller
{
    // ─── Listar canciones (HU018) ─────────────────────────────────────
    public function index(Request $request)
    {
        $query = Song::query();

        if ($request->filled('emocion')) {
            $query->where('emocion_can', $request->emocion);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom_can', 'like', '%' . $request->search . '%')
                  ->orWhere('artista_can', 'like', '%' . $request->search . '%');
            });
        }

        $songs   = $query->orderBy('emocion_can')->paginate(10);
        $emociones = ['ira', 'miedo', 'asco', 'tristeza', 'felicidad', 'sorpresa', 'neutral'];

        return view('admin.music.index', compact('songs', 'emociones'));
    }

    // ─── Formulario crear canción ─────────────────────────────────────
    public function create()
    {
        $emociones = ['ira', 'miedo', 'asco', 'tristeza', 'felicidad', 'sorpresa', 'neutral'];
        return view('admin.music.create', compact('emociones'));
    }

    // ─── Guardar canción ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'emocion_can'  => 'required|string',
            'nom_can'      => 'required|string|max:200',
            'artista_can'  => 'required|string|max:200',
            'url_can'      => 'required|url',
            'genero_can'   => 'nullable|string|max:100',
        ], [
            'emocion_can.required' => 'Selecciona una emoción.',
            'nom_can.required'     => 'El nombre es obligatorio.',
            'artista_can.required' => 'El artista es obligatorio.',
            'url_can.required'     => 'La URL es obligatoria.',
            'url_can.url'          => 'Ingresa una URL válida.',
        ]);

        Song::create($request->all());

        return redirect()->route('admin.music.index')
            ->with('success', 'Canción agregada correctamente.');
    }

    // ─── Formulario editar canción ────────────────────────────────────
    public function edit(Song $song)
    {
        $emociones = ['ira', 'miedo', 'asco', 'tristeza', 'felicidad', 'sorpresa', 'neutral'];
        return view('admin.music.edit', compact('song', 'emociones'));
    }

    // ─── Actualizar canción ───────────────────────────────────────────
    public function update(Request $request, Song $song)
    {
        $request->validate([
            'emocion_can'  => 'required|string',
            'nom_can'      => 'required|string|max:200',
            'artista_can'  => 'required|string|max:200',
            'url_can'      => 'required|url',
            'genero_can'   => 'nullable|string|max:100',
        ]);

        $song->update($request->all());

        return redirect()->route('admin.music.index')
            ->with('success', 'Canción actualizada correctamente.');
    }

    // ─── Activar / Desactivar canción ─────────────────────────────────
    public function toggleActive(Song $song)
    {
        $song->update(['activa' => !$song->activa]);
        $msg = $song->activa ? 'Canción activada.' : 'Canción desactivada.';
        return redirect()->back()->with('success', $msg);
    }

    // ─── Eliminar canción ─────────────────────────────────────────────
    public function destroy(Song $song)
    {
        $song->delete();
        return redirect()->route('admin.music.index')
            ->with('success', 'Canción eliminada correctamente.');
    }
}
