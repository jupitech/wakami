<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacturacomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_compra', function (Blueprint $table) {
            $table->string('nfactura');
            $table->timestamp('fecha_factura');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprasorden_compra', function (Blueprint $table) {
            //
        });
    }
}
