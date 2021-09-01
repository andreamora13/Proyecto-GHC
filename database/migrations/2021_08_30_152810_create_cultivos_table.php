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
            $table->double('semana');
            $table->string('tipo_planta');
            $table->boolean('cosecha');
            $table->boolean('estado');
            $table->unsignedInteger('id_planta');
            

            
            $table->foreign('id_planta')->references('id_planta')->on('plantas')
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
        Schema::dropIfExists('cultivos');
    }
}
