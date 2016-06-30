<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
class RoletableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $adminRole = Role::create([
		    'name' => 'Admin',
		    'slug' => 'admin',
		    'description' => 'Acceso completo a todo el sistema', // optional
		    'level' => 1, // optional, set to 1 by default
		]);

		$editorRole = Role::create([
		    'name' => 'Operativo',
		    'slug' => 'operativo',
		    'description' => 'Acceso a editar varias opciones en el sistema', // optional
		    'level' => 2, // optional, set to 1 by default
		]);

		$campeonRole = Role::create([
		    'name' => 'Vendedor',
		    'slug' => 'vendedor',
		    'description' => 'Usuario que utilizará el area de ventas', // optional
		    'level' => 3, // optional, set to 1 by default
		]);
    }
}
