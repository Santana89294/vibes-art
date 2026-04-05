<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('emocion_can');      // emoción asociada
            $table->string('nom_can');           // nombre de la canción
            $table->string('artista_can');       // artista
            $table->string('url_can');           // URL de YouTube o archivo
            $table->string('genero_can')->nullable(); // género musical
            $table->boolean('activa')->default(true); // activa o no
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
