<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * DISTRITO SERVICIOS
     */
    public function up(): void
    {
        Schema::create('distrito_servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_distrito');
            $table->string('nombre', 100);

            $table->foreign('id_distrito')->references('id')->on('distrito')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distrito_servicios');
    }
};
