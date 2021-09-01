<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alturas', function (Blueprint $table) {
            $table->increments('id_altura');
            $table->double('altura');
            $table->double('tasa_cre');
            $table->double('crec');
            $table->double('cre_fal');
            $table->double('semana');
            $table->unsignedInteger('id_partidaDet');

            

            $table->foreign('id_partidaDet')->references('id_partidaDet')->on('partida_dets')
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
        Schema::dropIfExists('alturas');
    }
}
