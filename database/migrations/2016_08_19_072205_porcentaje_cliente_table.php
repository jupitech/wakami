<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PorcentajeClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porcentaje_cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cliente')->unsigned()->index();
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->integer('tipo_cliente');
            $table->float('porcentaje');
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
        Schema::drop('porcentaje_cliente');
    }
}
