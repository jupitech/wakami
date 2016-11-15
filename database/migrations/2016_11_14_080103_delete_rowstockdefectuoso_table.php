<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteRowstockdefectuosoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_defectuoso', function (Blueprint $table) {
             $table->dropColumn('desde_sucursal');
             $table->dropColumn('desde_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_defectuoso', function (Blueprint $table) {
            //
        });
    }
}
