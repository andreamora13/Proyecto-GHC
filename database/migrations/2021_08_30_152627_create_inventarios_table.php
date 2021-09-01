<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->increments('id_inventario');
            $table->double('prod_planta');
            $table->double('semana');
            $table->boolean('vendido');
            $table->unsignedInteger('id_planta');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_partida');
            

            $table->foreign('id_planta')->references('id_planta')->on('plantas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('id_usuario')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('id_partida')->references('id_partida')->on('partidas')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventarios');
    }
}
