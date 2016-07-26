<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('codigo')->unique();
            $table->integer('linea')->unsigned()->index();
            $table->foreign('linea')->references('id')->on('linea_producto');
            $table->string('nombre');
            $table->float('costo');
            $table->float('preciop');
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
          Schema::drop('producto');
    }
}
