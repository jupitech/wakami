<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdencompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_proveedor')->unsigned()->index();
            $table->foreign('id_proveedor')->references('id')->on('proveedores');
            $table->integer('id_user')->unsigned()->index();
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamp('fecha_entrega');
            $table->float('total_compra');
            $table->integer('estado_orden');
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
        Schema::drop('orden_compra');
    }
}
