<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjusteinventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajuste_inventario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_producto')->unsigned()->index();
            $table->foreign('id_producto')->references('id')->on('producto');
            $table->integer('id_user')->unsigned()->index();
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('stock_anterior');
            $table->integer('stock_actual');
            $table->integer('stock_restante');
            $table->string('tipo_stock');
            $table->string('justificacion');
            $table->integer('id_sucursal');
            $table->integer('id_consignacion');
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
        Schema::drop('ajuste_inventario');
    }
}
