<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotografiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotografia', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('noticia_id')->unsigned();
            $table->string('nombrefotografia', 100);

            $table->foreign('noticia_id')->references('id')->on('noticia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fotografia');
    }
}
