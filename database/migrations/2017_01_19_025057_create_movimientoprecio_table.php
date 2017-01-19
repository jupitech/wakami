<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoprecioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_precio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_producto')->unsigned()->index();
            $table->foreign('id_producto')->references('id')->on('producto');
            $table->float('precio_anterior');
            $table->float('precio_actual');
            $table->integer('id_user');
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
        Schema::drop('movimiento_precio');
    }
}
