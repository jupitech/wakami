<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StockSucursalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_sucursal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sucursal')->unsigned()->index();
            $table->foreign('id_sucursal')->references('id')->on('sucursales');
            $table->integer('id_producto')->unsigned()->index();
            $table->foreign('id_producto')->references('id')->on('producto');
            $table->integer('stock');
            $table->integer('estado_producto');
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
        Schema::drop('stock_sucursal');
    }
}
