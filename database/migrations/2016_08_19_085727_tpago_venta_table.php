<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TpagoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpago_venta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ventas')->unsigned()->index();
            $table->foreign('id_ventas')->references('id')->on('ventas');
            $table->integer('tipo_pago');
            $table->string('referencia');
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
        Schema::drop('tpago_venta');
    }
}
