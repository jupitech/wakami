<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cliente')->unsigned()->index();
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->integer('estado_consignacion');
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
        Schema::drop('consignacion');
    }
}
