<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductodonacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_donacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_donacion')->unsigned()->index();
            $table->foreign('id_donacion')->references('id')->on('donacion');
            $table->integer('id_producto')->unsigned()->index();
            $table->foreign('id_producto')->references('id')->on('producto');
            $table->integer('cantidad');
            $table->integer('estado_producto');
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
        Schema::drop('producto_donacion');
    }
}
