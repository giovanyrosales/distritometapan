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
        Schema::create('rifa', function (Blueprint $table) {
            $table->id();

            $table->dateTime('fecha');
            $table->string('nombre', 100)->nullable();
            $table->string('dui', 20)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->boolean('ganador');
            $table->dateTime('fecha_ganador')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rifa');
    }
};
