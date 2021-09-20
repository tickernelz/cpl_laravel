<?php

namespace Database\Seeders;

use App\Models\Btp;
use Illuminate\Database\Seeder;

class BtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Btp::create([
            'id' => '1',
            'tahun_ajaran_id' => '1',
            'mata_kuliah_id' => '1',
            'cpmk_id' => '1',
            'dosen_admin_id' => '1',
            'nama' => 'Tugas 1',
            'semester' => '1',
            'kategori' => 'Tugas',
            'bobot' => '20',
        ]);

        Btp::create([
            'id' => '2',
            'tahun_ajaran_id' => '2',
            'mata_kuliah_id' => '2',
            'cpmk_id' => '2',
            'dosen_admin_id' => '2',
            'nama' => 'UTS',
            'semester' => '2',
            'kategori' => 'UTS',
            'bobot' => '30',
        ]);
    }
}
