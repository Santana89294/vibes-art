<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('texto_emo');                    // texto que escribió el usuario
            $table->string('emocion_amo');                // alegría, tristeza, rabia...
            $table->integer('intensidad_emo');            // 1-10
            $table->date('fecha_emo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emotions');
    }
};
