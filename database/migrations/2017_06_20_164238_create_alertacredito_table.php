<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertacreditoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('alerta_credito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_credito');
            $table->timestamp('fecha_credito')->nullable();
            $table->integer('estado_alerta');
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
        Schema::drop('alerta_credito');
    }
}
