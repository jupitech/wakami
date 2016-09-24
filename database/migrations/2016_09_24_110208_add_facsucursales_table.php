<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacsucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sucursales', function (Blueprint $table) {
           $table->integer('codigo_esta');
           $table->integer('codigo_sat');
           $table->string('resolucion');
           $table->string('fresolucion');
           $table->integer('codigo_satnce');
           $table->string('serie_nce');
           $table->string('resolucion_nce');
           $table->string('fresolucion_nce');
           $table->integer('codigo_satnde');
           $table->string('serie_nde');
           $table->string('resolucion_nde');
           $table->string('fresolucion_nde');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sucursales', function (Blueprint $table) {
            //
        });
    }
}
