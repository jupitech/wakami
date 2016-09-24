<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockconsignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_consignacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_consignacion')->unsigned()->index();
            $table->foreign('id_consignacion')->references('id')->on('consignacion');
            $table->integer('id_producto')->unsigned()->index();
            $table->foreign('id_producto')->references('id')->on('producto');
            $table->integer('stock');
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
        Schema::drop('stock_consignacion');
    }
}
