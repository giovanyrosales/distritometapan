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
        Schema::create('diplomado_alumnos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('certificado_id');

            // fecha generado
            $table->date('fecha');

            $table->string('codigo_verificacion')->unique();

            // nombre alumno
            $table->string('nombre', 100);

            // nombre curso
            $table->string('curso', 100);

            // periodo del curso
            $table->string('periodo', 100)->nullable();

            // nombre certificado
            $table->string('certificado', 100);

            $table->foreign('curso_id')->references('id')->on('diplomado_cursos')->onDelete('cascade');
            $table->foreign('certificado_id')->references('id')->on('diplomado_certificado')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diplomado_alumnos');
    }
};
