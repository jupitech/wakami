<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntregacompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega_compra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_orden');
            $table->integer('id_procompra')->unsigned()->index();
            $table->foreign('id_procompra')->references('id')->on('producto_compra');
            $table->integer('id_producto');
            $table->integer('cantidad');
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
        Schema::drop('entrega_compra');
    }
}
