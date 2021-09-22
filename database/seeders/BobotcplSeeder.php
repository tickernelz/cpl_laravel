<?php

namespace Database\Seeders;

use App\Models\Bobotcpl;
use Illuminate\Database\Seeder;

class BobotcplSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bobotcpl::create([
            'id' => '1',
            'tahun_ajaran_id' => '1',
            'mata_kuliah_id' => '1',
            'cpl_id' => '1',
            'cpmk_id' => '1',
            'btp_id' => '1',
            'semester' => '1',
            'bobot_cpl' => '20',
        ]);

        Bobotcpl::create([
            'id' => '2',
            'tahun_ajaran_id' => '2',
            'mata_kuliah_id' => '2',
            'cpl_id' => '2',
            'cpmk_id' => '2',
            'btp_id' => '2',
            'semester' => '2',
            'bobot_cpl' => '30',
        ]);
    }
}
