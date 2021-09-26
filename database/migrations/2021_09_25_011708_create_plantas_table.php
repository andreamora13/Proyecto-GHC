<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantas', function (Blueprint $table) {
            $table->increments('id_planta')->unique();
            $table->string('tipo_planta');
            $table->double('alt_max');
            $table->double('agua_re');
            $table->double('ab_re');
            $table->double('tab_ag');
            $table->double('tab_ab');
            $table->double('prod');
            $table->double('precio');
            $table->double('inv_acumulado');
            $table->double('cant_riegos');
            $table->double('cant_abonos');
            $table->unsignedInteger('id_partida');

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
        Schema::dropIfExists('plantas');
    }
}
