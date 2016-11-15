<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteRowdevolucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devolucion', function (Blueprint $table) {
             $table->dropColumn('a_sucursal');
             $table->dropColumn('a_user');
             $table->integer('hacia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devolucion', function (Blueprint $table) {
            //
        });
    }
}
