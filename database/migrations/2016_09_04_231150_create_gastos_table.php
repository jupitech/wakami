<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_categoria')->unsigned()->index();
            $table->foreign('id_categoria')->references('id')->on('categoria_gasto');
            $table->string('descripcion');
            $table->integer('mes');
            $table->float('costo');
            $table->timestamp('fecha_gasto');
            $table->integer('estado_gasto');
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
        Schema::drop('gastos');
    }
}
