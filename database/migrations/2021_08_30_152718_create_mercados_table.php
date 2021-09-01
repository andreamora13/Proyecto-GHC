<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercados', function (Blueprint $table) {
            $table->increments('id_mercado');
            $table->double('precio');
            $table->double('ventas');
            $table->double('inv_deseado');
            $table->double('inv_acumulado');
            $table->double('radio_inv');
            $table->double('efecto_precio');
            $table->double('precio_deseado');
            $table->double('cambio_precio');
            $table->double('semana');
            $table->unsignedInteger('id_planta');
            $table->unsignedInteger('id_partida');

            $table->foreign('id_planta')->references('id_planta')->on('plantas')
            ->onDelete("cascade")
            ->onUpdate("cascade");

           

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
        Schema::dropIfExists('mercados');
    }
}
