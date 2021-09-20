<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'username' => 'admin',
            'password' => bcrypt('123'),
            'status' => 'Admin',
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'username' => 'koor',
            'password' => bcrypt('123'),
            'status' => 'Dosen Koordinator',
        ]);

        $user->assignRole('dosen_koordinator');
    }
}
