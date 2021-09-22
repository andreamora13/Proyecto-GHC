<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partida_usuarios', function (Blueprint $table) {
            $table->increments('id_partidausu');
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
        Schema::dropIfExists('partida_usuarios');
    }
}
