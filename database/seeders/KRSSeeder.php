<?php

namespace Database\Seeders;

use App\Models\KRS;
use Illuminate\Database\Seeder;

class KRSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KRS::create([
            'id' => '1',
            'mahasiswa_id' => '1',
            'tahun_ajaran_id' => '2',
            'mata_kuliah_id' => '1',
            'semester' => '1',
        ]);

        KRS::create([
            'id' => '2',
            'mahasiswa_id' => '2',
            'tahun_ajaran_id' => '1',
            'mata_kuliah_id' => '2',
            'semester' => '2',
        ]);
    }
}
