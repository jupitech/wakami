<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenconsignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_consignacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_consignacion')->unsigned()->index();
            $table->foreign('id_consignacion')->references('id')->on('consignacion');
            $table->integer('id_user')->unsigned()->index();
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamp('fecha_entrega');
            $table->float('total_compra');
            $table->integer('estado_orden');
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
        Schema::drop('orden_consignacion');
    }
}
