<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_usuarios', function (Blueprint $table) {
           $table->increments('id_tipoUsu');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_tipo');

            $table->foreign('id_usuario')->references('id')->on('users')
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign('id_tipo')->references('id_tipo')->on('tipos')
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
        Schema::dropIfExists('tipo_usuarios');
    }
}
