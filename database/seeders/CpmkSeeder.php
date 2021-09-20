<?php

namespace Database\Seeders;

use App\Models\Cpmk;
use Illuminate\Database\Seeder;

class CpmkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cpmk::create([
            'id' => '1',
            'mata_kuliah_id' => '1',
            'kode_cpmk' => 'CPMK1',
            'nama_cpmk' => 'Menjelaskan Konsep Fisika',
        ]);

        Cpmk::create([
            'id' => '2',
            'mata_kuliah_id' => '2',
            'kode_cpmk' => 'CPMK1',
            'nama_cpmk' => 'menjelaskan sesuatu',
        ]);
    }
}
