<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnadepositoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saldo_deposito', function (Blueprint $table) {
            $table->string('banco');
             $table->timestamp('fecha_deposito')->nullable();
            $table->integer('id_sucursal');
            $table->integer('id_user');
            $table->integer('estado_deposito');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saldo_deposito', function (Blueprint $table) {
            //
        });
    }
}
