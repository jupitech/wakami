<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditosventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditos_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ventas')->unsigned()->index();
            $table->foreign('id_ventas')->references('id')->on('ventas');
            $table->integer('dias_credito');
            $table->timestamp('fecha_limite');
            $table->integer('estado_credito');
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
        Schema::drop('creditos_ventas');
    }
}
