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

            $table->date('fecha');

            $table->string('nombre', 100);
            $table->string('telefono', 25);
            $table->string('correo', 100)->nullable();
            $table->text('comentarios');
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
