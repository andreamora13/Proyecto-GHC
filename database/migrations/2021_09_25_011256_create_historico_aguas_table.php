<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoAguasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('historico_aguas', function (Blueprint $table) {
            $table->increments('id_histagua');
            $table->double('agua_total');
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
        Schema::dropIfExists('historico_aguas');
    }
}
