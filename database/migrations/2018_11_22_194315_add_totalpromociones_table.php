<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalpromocionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promociones', function (Blueprint $table) {
             $table->float('por_total',15,2);
             $table->float('porcentaje_total',15,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promociones', function (Blueprint $table) {
            //
        });
    }
}
