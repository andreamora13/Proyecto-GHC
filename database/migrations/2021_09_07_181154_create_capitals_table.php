<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitals', function (Blueprint $table) {
            $table->increments('id_capital');
            $table->double('capital');
            $table->unsignedInteger('id_partida');
            $table->unsignedInteger('id_usuario');

            $table->foreign('id_partida')->references('id_partida')->on('partidas')
            ->onDelete("cascade")
            ->onUpdate("cascade");
           
            $table->foreign('id_usuario')->references('id')->on('users')
            ->onDelete("cascade")
            ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capitals');
    }
}
