<?php

namespace Database\Seeders;

use App\Models\Cpl;
use Illuminate\Database\Seeder;

class CplSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cpl::create([
            'id' => '1',
            'kode_cpl' => 'KU1',
            'nama_cpl' => 'Memiliki kemampuan untuk memecahkan masalah san menemukan solusi yang tepat',
        ]);

        Cpl::create([
            'id' => '2',
            'kode_cpl' => 'S1',
            'nama_cpl' => 'Menginternalisasi sikap sesuai Pancasila',
        ]);
    }
}
