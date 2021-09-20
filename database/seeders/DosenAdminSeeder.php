<?php

namespace Database\Seeders;

use App\Models\DosenAdmin;
use Illuminate\Database\Seeder;

class DosenAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DosenAdmin::create([
            'user_id' => '1',
            'nip' => '12345',
            'nama' => 'Zhafron Adani Kautsar',
        ]);

        DosenAdmin::create([
            'user_id' => '2',
            'nip' => '197601182003122003',
            'nama' => 'Felicia Sylviana, ST., MM',
        ]);
    }
}
