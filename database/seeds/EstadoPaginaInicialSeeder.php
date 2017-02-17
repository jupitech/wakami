<?php

use Illuminate\Database\Seeder;
use App\Models\EstadoPagina;

class EstadoPaginaInicialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado_pagina')->insert([
            'nombre' => 'developer',
            'estado'  => 2
        ]);

    }
}
