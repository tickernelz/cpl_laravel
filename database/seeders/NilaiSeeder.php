<?php

namespace Database\Seeders;

use App\Models\Nilai;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nilai::create([
            'mahasiswa_id' => '1',
            'btp_id' => '1',
            'nilai' => '90',
        ]);

        Nilai::create([
            'mahasiswa_id' => '2',
            'btp_id' => '2',
            'nilai' => '80',
        ]);
    }
}
