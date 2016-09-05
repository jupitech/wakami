<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendientepenvioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendiente_penvio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sucursal')->unsigned()->index();
            $table->foreign('id_sucursal')->references('id')->on('sucursales');
            $table->integer('id_orden')->unsigned()->index();
            $table->foreign('id_orden')->references('id')->on('orden_envio');
            $table->integer('id_proenvio')->unsigned()->index();
            $table->foreign('id_proenvio')->references('id')->on('producto_envio');
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
        Schema::drop('pendiente_penvio');
    }
}
