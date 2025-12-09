<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * DISTRITOS
     *
     * 1- DISTRITO DE METAPAN
     * 2- DISTRITO DE SANTA ROSA
     * 3- DISTRITO DE MASAHUAT
     * 4- DISTRITO DE TEXISTEPEQUE
     */
    public function up(): void
    {
        Schema::create('distrito', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distrito');
    }
};
