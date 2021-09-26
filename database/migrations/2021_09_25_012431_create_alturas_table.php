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
            $table->integer('semana');
         

            $table->unsignedInteger('id_cultivo');

            $table->foreign('id_cultivo')->references('id_cultivo')->on('cultivos')
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
        Schema::dropIfExists('alturas');
    }
}
