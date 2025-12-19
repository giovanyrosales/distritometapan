<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * LISTA DE GANADORES Y QUE HAN GANADO
     */
    public function up(): void
    {
        Schema::create('rifa_ganadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rifapremios');
            $table->unsignedBigInteger('id_rifa');

            $table->foreign('id_rifapremios')->references('id')->on('rifa_premios')->onDelete('cascade');
            $table->foreign('id_rifa')->references('id')->on('rifa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rifa_ganadores');
    }
};
