<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('desde_sucursal');
            $table->integer('desde_user');
            $table->integer('a_sucursal');
            $table->integer('a_user');
            $table->timestamp('fecha_entrega');
            $table->string('descripcion');
            $table->integer('estado_devolucion');
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
        Schema::drop('devolucion');
    }
}
