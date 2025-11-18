<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votacion_registro', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_votacion');
            $table->string('ip', 45);
            // solo para saber desde donde esta votando el usuario
            $table->text('user_agent')->nullable();

            $table->dateTime('fecha');

            // Relación
            $table->foreign('id_votacion')->references('id')->on('votacion')->onDelete('cascade');

            // 🔒 Solo 1 voto por IP EN TODA LA VOTACIÓN
            $table->unique('ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votacion_registro');
    }
};
