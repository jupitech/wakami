<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductocompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_compra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_orden')->unsigned()->index();
            $table->foreign('id_orden')->references('id')->on('orden_compra');
            $table->integer('id_producto')->unsigned()->index();
            $table->foreign('id_producto')->references('id')->on('producto');
            $table->float('precio_producto');
            $table->integer('cantidad');
            $table->float('subtotal');
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
        Schema::drop('producto_compra');
    }
}
