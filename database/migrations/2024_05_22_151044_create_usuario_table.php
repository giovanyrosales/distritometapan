<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * USUARIO ADMINISTRADOR
     */
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->boolean('activo');
            $table->string('usuario', 50);
            $table->string('password', 255);

            // ASIGNAR A UN DISTRITO PARA VER BUZON DE SUGERENCIAS
            $table->integer('id_distrito');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
