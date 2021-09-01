<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->increments('id_abono');
            $table->double('abono');
            $table->double('ca');
            $table->double('ab_abs');
            $table->double('m_tc_ab');
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
        Schema::dropIfExists('abonos');
    }
}