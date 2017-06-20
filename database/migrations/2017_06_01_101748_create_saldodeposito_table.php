<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldodepositoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_deposito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_saldo')->unsigned()->index();
            $table->foreign('id_saldo')->references('id')->on('saldo_actual');
            $table->float('monto');
            $table->float('montosis');
            $table->string('numero');
            $table->string('descripcion');
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
        Schema::drop('saldo_deposito');
    }
}
