<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('tipo_promocion');
            $table->integer('id_producto');
            $table->integer('id_linea');
            $table->integer('por_cantidad');
            $table->float('porcentaje_producto');
            $table->float('porcentaje_linea');
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin');
            $table->integer('estado_promocion');
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
        Schema::drop('promociones');
    }
}
