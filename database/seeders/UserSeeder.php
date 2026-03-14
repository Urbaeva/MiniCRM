<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	    $manager = User::factory()->create([
		    'name' => 'Manager',
		    'email' => 'manager@minicrm.test',
		    'password' => Hash::make('password'),
	    ]);

	    $manager->assignRole('manager');
    }
}
