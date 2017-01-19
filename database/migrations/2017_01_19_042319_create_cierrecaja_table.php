<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCierrecajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierre_caja', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sucursal')->unsigned()->index();
            $table->foreign('id_sucursal')->references('id')->on('sucursales');
            $table->integer('id_user')->unsigned()->index();
            $table->foreign('id_user')->references('id')->on('users');
            $table->float('saldo_efectivo');
            $table->integer('estado_caja');
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
        Schema::drop('cierre_caja');
    }
}
