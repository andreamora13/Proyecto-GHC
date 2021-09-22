<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonoCantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_cants', function (Blueprint $table) {
            $table->increments('id_abonocant');
            $table->double('abono_cant');
            $table->integer('semana');
            $table->boolean('crecimiento');
           
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
        Schema::dropIfExists('abono_cants');
    }
}
