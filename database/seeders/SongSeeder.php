<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    public function run(): void
    {
        $songs = [
            // ─── IRA ──────────────────────────────────────────────────
            ['emocion_can' => 'ira', 'nom_can' => 'Break Stuff', 'artista_can' => 'Limp Bizkit', 'url_can' => 'https://www.youtube.com/watch?v=ZpUYjpKg9KY', 'genero_can' => 'Rock'],
            ['emocion_can' => 'ira', 'nom_can' => 'Killing in the Name', 'artista_can' => 'Rage Against the Machine', 'url_can' => 'https://www.youtube.com/watch?v=bWXazVhlyxQ', 'genero_can' => 'Rock'],
            ['emocion_can' => 'ira', 'nom_can' => 'Given Up', 'artista_can' => 'Linkin Park', 'url_can' => 'https://www.youtube.com/watch?v=0xyxtzD54rM', 'genero_can' => 'Rock'],

            // ─── MIEDO ────────────────────────────────────────────────
            ['emocion_can' => 'miedo', 'nom_can' => 'Thriller', 'artista_can' => 'Michael Jackson', 'url_can' => 'https://www.youtube.com/watch?v=sOnqjkJTMaA', 'genero_can' => 'Pop'],
            ['emocion_can' => 'miedo', 'nom_can' => 'Paint It Black', 'artista_can' => 'The Rolling Stones', 'url_can' => 'https://www.youtube.com/watch?v=O4irXQhgMqg', 'genero_can' => 'Rock'],
            ['emocion_can' => 'miedo', 'nom_can' => 'Creep', 'artista_can' => 'Radiohead', 'url_can' => 'https://www.youtube.com/watch?v=XFkzRNyygfk', 'genero_can' => 'Alternative'],

            // ─── ASCO ─────────────────────────────────────────────────
            ['emocion_can' => 'asco', 'nom_can' => 'Loser', 'artista_can' => 'Beck', 'url_can' => 'https://www.youtube.com/watch?v=YgSPaXgAdzE', 'genero_can' => 'Alternative'],
            ['emocion_can' => 'asco', 'nom_can' => 'Smells Like Teen Spirit', 'artista_can' => 'Nirvana', 'url_can' => 'https://www.youtube.com/watch?v=hTWKbfoikeg', 'genero_can' => 'Grunge'],
            ['emocion_can' => 'asco', 'nom_can' => 'Numb', 'artista_can' => 'Linkin Park', 'url_can' => 'https://www.youtube.com/watch?v=kXYiU_JCYtU', 'genero_can' => 'Rock'],

            // ─── TRISTEZA ─────────────────────────────────────────────
            ['emocion_can' => 'tristeza', 'nom_can' => 'The Night We Met', 'artista_can' => 'Lord Huron', 'url_can' => 'https://www.youtube.com/watch?v=KtlgYxa6BMU', 'genero_can' => 'Indie'],
            ['emocion_can' => 'tristeza', 'nom_can' => 'Someone Like You', 'artista_can' => 'Adele', 'url_can' => 'https://www.youtube.com/watch?v=hLQl3WQQoQ0', 'genero_can' => 'Pop'],
            ['emocion_can' => 'tristeza', 'nom_can' => 'Fix You', 'artista_can' => 'Coldplay', 'url_can' => 'https://www.youtube.com/watch?v=k4V3Mo61fJM', 'genero_can' => 'Pop'],

            // ─── FELICIDAD ────────────────────────────────────────────
            ['emocion_can' => 'felicidad', 'nom_can' => 'Happy', 'artista_can' => 'Pharrell Williams', 'url_can' => 'https://www.youtube.com/watch?v=ZbZSe6N_BXs', 'genero_can' => 'Pop'],
            ['emocion_can' => 'felicidad', 'nom_can' => 'Good as Hell', 'artista_can' => 'Lizzo', 'url_can' => 'https://www.youtube.com/watch?v=SmbmeOgWsqE', 'genero_can' => 'Pop'],
            ['emocion_can' => 'felicidad', 'nom_can' => 'Can\'t Stop the Feeling', 'artista_can' => 'Justin Timberlake', 'url_can' => 'https://www.youtube.com/watch?v=ru0K8uYEZWw', 'genero_can' => 'Pop'],

            // ─── SORPRESA ─────────────────────────────────────────────
            ['emocion_can' => 'sorpresa', 'nom_can' => 'Superstition', 'artista_can' => 'Stevie Wonder', 'url_can' => 'https://www.youtube.com/watch?v=0CFuCYNx-1g', 'genero_can' => 'Soul'],
            ['emocion_can' => 'sorpresa', 'nom_can' => 'Bohemian Rhapsody', 'artista_can' => 'Queen', 'url_can' => 'https://www.youtube.com/watch?v=fJ9rUzIMcZQ', 'genero_can' => 'Rock'],
            ['emocion_can' => 'sorpresa', 'nom_can' => 'Uptown Funk', 'artista_can' => 'Mark Ronson ft. Bruno Mars', 'url_can' => 'https://www.youtube.com/watch?v=OPf0YbXqDm0', 'genero_can' => 'Pop'],

            // ─── NEUTRAL ──────────────────────────────────────────────
            ['emocion_can' => 'neutral', 'nom_can' => 'Weightless', 'artista_can' => 'Marconi Union', 'url_can' => 'https://www.youtube.com/watch?v=UfcAVejslrU', 'genero_can' => 'Ambient'],
            ['emocion_can' => 'neutral', 'nom_can' => 'Experience', 'artista_can' => 'Ludovico Einaudi', 'url_can' => 'https://www.youtube.com/watch?v=hN_q-_nGv4U', 'genero_can' => 'Classical'],
        ];

        foreach ($songs as $song) {
            Song::create($song);
        }
    }
}
