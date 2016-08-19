<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serie_factura');
            $table->integer('correlativo');
            $table->integer('id_cliente');
            $table->float('total');
            $table->timestamp('fecha_factura');
            $table->integer('id_sucursal')->unsigned()->index();
            $table->foreign('id_sucursal')->references('id')->on('sucursales');
            $table->integer('id_user')->unsigned()->index();
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('id_porcliente');
            $table->integer('estado_ventas');
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
        Schema::drop('ventas');
    }
}
