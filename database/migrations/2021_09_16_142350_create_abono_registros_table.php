<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonoRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_registros', function (Blueprint $table) {
            $table->increments('id_abono');
            $table->double('abono');
            $table->double('ca');
            $table->double('ab_abs');
            $table->double('m_tc_ab');
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
        Schema::dropIfExists('abono_registros');
    }
}
