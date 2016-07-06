<?php

use Illuminate\Database\Seeder;
use App\Models\UserProfile;
class UserProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $adminProfile = UserProfile::create([
		    'nombre' => 'Carlos',
		    'apellido' => 'Ruano',
		    'user_id' => 1, // optional, set to 1 by default
		    'activo' => 1, // optional, set to 1 by default
		]);
    }
}
