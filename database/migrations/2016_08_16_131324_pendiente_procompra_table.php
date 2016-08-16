<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PendienteProcompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendiente_procompra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_orden')->unsigned()->index();
            $table->foreign('id_orden')->references('id')->on('orden_compra');
            $table->integer('id_procompra')->unsigned()->index();
            $table->foreign('id_procompra')->references('id')->on('producto_compra');
            $table->integer('id_producto')->unsigned()->index();
            $table->foreign('id_producto')->references('id')->on('producto');
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
        Schema::drop('pendiente_procompra');
    }
}
