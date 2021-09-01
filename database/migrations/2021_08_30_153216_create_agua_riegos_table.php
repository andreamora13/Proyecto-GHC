<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAguaRiegosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agua_riegos', function (Blueprint $table) {
            $table->increments('id_aguariego');
            $table->double('agua_riego');
            $table->double('semana');
            $table->boolean('crecimiento');
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
        Schema::dropIfExists('agua_riegos');
    }
}
