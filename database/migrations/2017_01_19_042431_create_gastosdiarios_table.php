<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGastosdiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos_diarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referencia');
            $table->integer('id_cierre')->unsigned()->index();
            $table->foreign('id_cierre')->references('id')->on('cierre_caja');
            $table->string('descripcion');
            $table->float('gasto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gastos_diarios');
    }
}
