<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidaDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partida_dets', function (Blueprint $table) {
            $table->increments('id_partidaDet');
            $table->unsignedInteger('id_partida');
            $table->unsignedInteger('id_cultivo');
             $table->unsignedInteger('id_usuario');

            $table->foreign('id_partida')->references('id_partida')->on('partidas')
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->foreign('id_cultivo')->references('id_cultivo')->on('cultivos')
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
        Schema::dropIfExists('partida_dets');
    }
}
