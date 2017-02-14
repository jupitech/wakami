<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;

class RolDevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devRole = Role::create([
		    'name' => 'Developer',
		    'slug' => 'developer',
		    'description' => 'Acceso completo a todo el sistema como desarrollador', // optional
		    'level' => 1, // optional, set to 1 by default
		]);
    }
}
