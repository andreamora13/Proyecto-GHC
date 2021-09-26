<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCultivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivos', function (Blueprint $table) {
            $table->increments('id_cultivo');
            $table->double('altura');
            $table->double('produccion');
            $table->string('tipo_planta');
            $table->boolean('cosecha');
            $table->boolean('estado');
            $table->integer('semana');
            $table->unsignedInteger('id_planta');
            $table->unsignedInteger('id_partidausu');
            

            
            $table->foreign('id_planta')->references('id_planta')->on('plantas')
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign('id_partidausu')->references('id_partidausu')->on('partida_usuarios')
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
        Schema::dropIfExists('cultivos');
    }
}
