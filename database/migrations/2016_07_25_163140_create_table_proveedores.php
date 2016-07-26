<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('empresa');
            $table->string('encargado');
            $table->string('nit')->unique();
            $table->string('direccion');
            $table->integer('telefono');
            $table->integer('telefono_encargado');
            $table->string('email_encargado');
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
          Schema::drop('proveedores');
    }
}
