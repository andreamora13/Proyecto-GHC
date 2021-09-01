<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAguasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aguas', function (Blueprint $table) {
            $table->increments('id_agua');
            $table->double('agua');
            $table->double('cob_a');
            $table->double('absor');
            $table->double('m_tc_a');
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
        Schema::dropIfExists('aguas');
    }
}
