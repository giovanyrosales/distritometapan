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
        Schema::create('sugerencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_distritoservicios');

            $table->dateTime('fecha');
            $table->string('nombre', 100);
            $table->string('telefono', 25);
            $table->string('correo', 100)->nullable();
            $table->text('comentarios');

            $table->boolean('revisado')->default(0);

            $table->foreign('id_distritoservicios')->references('id')->on('distrito_servicios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sugerencias');
    }
};
