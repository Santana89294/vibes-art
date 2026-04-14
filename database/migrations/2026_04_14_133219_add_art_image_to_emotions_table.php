<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emotions', function (Blueprint $table) {
            $table->longText('art_image')->nullable()->after('all_scores');
        });
    }

    public function down(): void
    {
        Schema::table('emotions', function (Blueprint $table) {
            $table->dropColumn('art_image');
        });
    }
};
