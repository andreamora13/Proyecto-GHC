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
            $table->boolean('vendido');
            $table->integer('semana');
            $table->unsignedInteger('id_planta');
            $table->unsignedInteger('id_partidausu');
            
            $table->foreign('id_planta')->references('id_planta')->on('plantas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('inventarios');
    }
}
