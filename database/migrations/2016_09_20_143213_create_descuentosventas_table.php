<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentosventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuentos_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ventas')->unsigned()->index();
            $table->foreign('id_ventas')->references('id')->on('ventas');
            $table->integer('id_cliente');
            $table->float('porcentaje');
            $table->float('descuento');
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
        Schema::drop('descuentos_ventas');
    }
}
