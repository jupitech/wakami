<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCierrepagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierre_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cierre')->unsigned()->index();
            $table->foreign('id_cierre')->references('id')->on('cierre_caja');
            $table->integer('id_tpago');
            $table->float('monto_sis');
            $table->float('monto_fisico');
            $table->float('monto_diferencia');
            $table->float('conversion');
            $table->float('monto_fisicod');
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
        Schema::drop('cierre_pago');
    }
}
